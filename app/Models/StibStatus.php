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
        ];
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
