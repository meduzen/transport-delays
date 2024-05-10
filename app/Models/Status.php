<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Status extends Model
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
        return $this->belongsToMany(Line::class);
    }

    /**
     * The stops that belong to the status.
     */
    public function stops(): BelongsToMany
    {
        return $this->belongsToMany(Stop::class);
    }
}
