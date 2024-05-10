<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Line extends Model
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
            'direction' => AsArrayObject::class,
            'various' => AsArrayObject::class,
        ];
    }

    /**
     * The stops that belong to the line.
     */
    public function stops(): BelongsToMany
    {
        return $this->belongsToMany(Stop::class);
    }
}
