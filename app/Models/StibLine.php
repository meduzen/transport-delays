<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StibLine extends Model
{
    use HasFactory;

    protected function casts()
    {
        return [
            'direction' => AsArrayObject::class,
            'various' => AsArrayObject::class,
        ];
    }

    /**
     * The stops that belong to the line.
     */
    public function stops(): BelongsToMany
    {
        return $this->belongsToMany(StibStop::class, 'stib_line_stib_stop', 'stop_id', 'line_id');
    }

    /**
     * The statuses that belong to the line.
     */
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(StibStatus::class, 'stib_line_stib_status', 'status_id', 'line_id');
    }

    /**
     * The cricital statuses that belong to the line.
     */
    public function disruptions(): BelongsToMany
    {
        return $this->statuses()->disruptions();
    }

    /**
     * The cricital statuses that belong to the line and are active.
     */
    public function activeDisruptions(): BelongsToMany
    {
        return $this->disruptions()->active();
    }

    /**
     * Today’s cricital statuses that belong to the line.
     */
    public function todaysDisruptions(): BelongsToMany
    {
        return $this->disruptions()->today();
    }
}
