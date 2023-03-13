<?php

namespace App\Models;

use App\Enum\Clock\ClockingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'worker_id',
        'timestamp',
        'longitude',
        'latitude',
    ];

    protected $casts = [
        'type' => ClockingType::class,
    ];
}
