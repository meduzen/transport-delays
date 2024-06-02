<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StibStatus extends Model
{
    use HasFactory;

    protected $fillable = ['active', 'ended_at'];

    protected function casts()
    {
        return [
            'content' => AsArrayObject::class,
            'ended_at' => 'datetime',
            'raw' => AsArrayObject::class,
        ];
    }

    /**
     * Scope a query to filter critical statuses.
     *
     * Priorities are defines as such (email from 30 April 2024):
     * 0. Urgent communication
     * 1. Urgent communication
     * 2. Real-time disruptions
     * 3. Real-time disruptions
     * 4. Planned disruptions
     * 5. Planned disruptions
     * 6. Planned disruptions
     * 7. Commercial announcement (safety, corporate,…)
     * 8. Commercial announcement (safety, corporate,…)
     * 9. Advertisement (never external)
     *
     * “As such, the best way to interpret the priority is “the lower, the more
     * important”, as internal good practices are how agents decide to place
     * a disruption in 2 or 3 / 4 or 5 or 6.”
     */
    public function scopeDisruptions(Builder $query): Builder
    {
        return $query->where('priority', '<=', 6);
    }

    /**
     * Scope a query to filter active statuses.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', '=', true);
    }

    /**
     * Scope a query to filter today statuses.
     *
     * Included statuses are the ones that have ended today or not ended yet.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query
            ->whereDate('ended_at', '=', date('Y-m-d'))
            ->OrWhereNull('ended_at');
    }

    /**
     * The lines that belong to the status.
     */
    public function lines(): BelongsToMany
    {
        return $this->belongsToMany(StibLine::class, 'stib_line_stib_status', 'line_id', 'status_id');
    }

    /**
     * The stops that belong to the status.
     */
    public function stops(): BelongsToMany
    {
        return $this->belongsToMany(StibStop::class, 'stib_status_stib_stop', 'stop_id', 'status_id');
    }

    /**
     * Check if another status is equal to the status.
     */
    public function equal(StibStatus $status): bool
    {
        // Compare type

        if ($this->type != $status->type) {
            return false;
        }

        // Compare priority

        if ($this->priority != $status->priority) {
            return false;
        }

        // Compare stops

        $stops_id = collect($this->raw->points)->pluck('id');
        $status_stops_id = collect($status->raw->points)->pluck('id');
        $stops_diff = $stops_id->diff($status_stops_id);

        if ($stops_diff->count() > 0) {
            return false;
        }

        // Compare lines

        $lines_id = collect($this->raw->lines)->pluck('id');
        $status_lines_id = collect($status->raw->lines)->pluck('id');
        $lines_diff = $lines_id->diff($status_lines_id);

        if ($lines_diff->count() > 0) {
            return false;
        }

        // Compare content

        if (count($this->content) != count($status->content)) {
            return false;
        }

        foreach ($this->content as $key => $content) {
            $status_content = $status->content[$key];

            if ($content['type'] != $status_content['type']) {
                return false;
            }

            if (count($content['text']) != count($status_content['text'])) {
                return false;
            }

            foreach ($content['text'] as $text_key => $text) {
                $diff = array_diff($text, $status_content['text'][$text_key]);
                if (count($diff) > 0) {
                    return false;
                }
            }
        }

        return true;
    }
}
