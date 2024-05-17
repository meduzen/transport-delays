<?php

namespace App\Services;

use App\Models\StibLine;
use App\Models\StibStatus;
use Illuminate\Support\Facades\Http;

class StibDataFetchingService
{
    protected string $baseUrl = 'https://data.stib-mivb.brussels/api/explore/v2.1/catalog/datasets';

    public function __construct()
    {
        //
    }

    /**
     * Fetch Stib messages.
     */
    public function fetch(): bool
    {
        $res = Http::timeout(60)->get($this->baseUrl.'/travellers-information-rt-production/exports/json?timezone=Europe%2FBrussels');

        if (! $res->ok()) {
            return false;
        }

        collect($res->json())->each(fn ($info) => $this->store($info));

        return true;
    }

    public static function store($info): void
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

        $status->save();

        $lines_id = collect($info['lines'])->pluck('id');
        $lines = StibLine::whereIn('name', $lines_id)->get();

        $status->lines()->sync($lines);
    }
}
