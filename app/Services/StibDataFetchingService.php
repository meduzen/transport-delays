<?php

namespace App\Services;

use App\Models\StibLine;
use App\Models\StibStatus;
use App\Models\StibStop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class StibDataFetchingService
{
    protected string $baseUrl = 'https://data.stib-mivb.brussels/api/explore/v2.1/catalog/datasets';

    protected Collection $activeDisruptions;

    public function __construct()
    {
        $this->activeDisruptions = StibStatus::disruptions()
            ->active()
            ->with(['lines', 'stops'])
            ->get();
    }

    /**
     * Fetch Stib messages.
     */
    public function fetch(): mixed
    {
        /** @todo Test `config('app.timezone')`. */
        $res = Http::timeout(60)
            ->withHeader('Authorization', 'ApiKey '.config('services.stib.api.key'))
            ->get($this->baseUrl.'/travellers-information-rt-production/exports/json?timezone=Europe%2FBrussels');

        if (! $res->ok()) {
            // @todo: should throw instead?
            return false;
        }

        return $this->process(collect($res->json()));
    }

    /**
     * Add new statuses to the database and flag stale ones.
     *
     * @return newStatusesCount Number of statuses being actually new.
     */
    public function process(Collection $data): int
    {
        $statuses = $data->map(fn ($entry) => $this->createModel($entry));

        // Are existing disruptions still active or stale?

        [$active, $stale] = $this->activeDisruptions->partition(function ($status) use ($statuses) {
            return $statuses->first(fn ($entry) => $status->equal($entry));
        });

        // Only keep new statuses.

        $statuses = $statuses->reject(function ($entry) {
            return $this->activeDisruptions->first(fn ($status) => $status->equal($entry));
        });

        // Active disruptions: update `updated_at` by touching the model (`active` is already `true`).

        if ($active->isNotEmpty()) {
            $active->toQuery()->update(['active' => true]);
        }

        // End of disruption: last `updated_at` is now the end time.

        if ($stale->isNotEmpty()) {
            $stale->toQuery()->update([
                'active' => false,
                'ended_at' => $stale->first()->updated_at,
            ]);
        }

        // Save new disruptions.

        $statuses->each(fn ($new_status) => $this->store($new_status));

        return $statuses->count();
    }

    public function store(StibStatus $status): void
    {
        $status->save();

        $lines_id = collect($status->raw->lines)->pluck('id');
        $stops_id = collect($status->raw->points)->pluck('id');

        $lines = StibLine::whereIn('name', $lines_id)->get();
        $stops = StibStop::whereIn('internal_id', $stops_id)->get();

        $status->lines()->sync($lines);
        $status->stops()->sync($stops);
    }

    public function createModel(array $info): StibStatus
    {
        /**
         * Replace stringified JSON to have proper objects. It’s
         * needed to store the raw stringified JSON status.
         */
        $info['content'] = json_decode($info['content']);
        $info['lines'] = json_decode($info['lines']);
        $info['points'] = json_decode($info['points']);

        $status = new StibStatus();
        $status->priority = $info['priority'];
        $status->type = $info['type'];
        $status->content = $info['content'];
        $status->raw = $info;

        return $status;
    }
}
