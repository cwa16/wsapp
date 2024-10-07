<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    protected $table = 'Coordinates';

    protected $fillable = [
        'driver_id',
        'latitude',
        'longitude',
        'timestamp',
    ];

    public function Driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
