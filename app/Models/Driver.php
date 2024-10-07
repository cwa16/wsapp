<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'activity',
        'from',
        'to',
        'start_hour',
        'finish_hour',
        'total_hour',
        'remark'
    ];

    public function HeavyEquipment(): BelongsTo
    {
        return $this->belongsTo(HeavyEquipment::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function Coordinates(): hasMany
    {
        return $this->hasMany(Coordinate::class);
    }
}
