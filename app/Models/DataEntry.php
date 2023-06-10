<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataEntry extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'sensor_id', 'PWR', 'log_at'];

    public function device(): BelongsTo
    {
        return $this->belongsTo(device::class);
    }
    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }
    public function roomdata(): HasMany
    {
        return $this->hasMany(RoomData::class);
    }
}
