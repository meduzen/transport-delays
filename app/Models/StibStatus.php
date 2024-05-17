<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StibStatus extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => AsArrayObject::class,
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
    public function scopeDisruptions($query)
    {
        return $query->where('priority', '<=', 6);
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
     * Currently not done nor needed.
     */
    // public function stops(): BelongsToMany
    // {
    //     return $this->belongsToMany(StibStop::class, 'stib_status_stib_stop');
    // }
}
