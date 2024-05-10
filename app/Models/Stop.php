<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// https://stackoverflow.com/questions/24689852/fetching-mysql-geo-point-data-and-storing-result-in-php-variable
// @todo: Consider moving it to its custom Cast (https://laravel.com/docs/11.x/eloquent-mutators#custom-casts).
function rawPointToFloatPair($data)
{
    $res = unpack("lSRID/CByteOrder/lTypeInfo/dX/dY", $data);
    return [$res['X'],$res['Y']];
}

class Stop extends Model
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
            'name' => AsArrayObject::class,
        ];
    }

    /**
     * Get the user's first name.
     */
    protected function coordinates(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => rawPointToFloatPair($value),
        );
    }

    /**
     * The lines that belong to the line.
     */
    public function lines(): BelongsToMany
    {
        return $this->belongsToMany(Line::class);
    }

    /**
     * The statuses that belong to the stop.
     */
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class);
    }
}
