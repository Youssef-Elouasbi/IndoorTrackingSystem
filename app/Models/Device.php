<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['MAC', 'Name', 'Status', 'Position_x', 'Position_y', 'Room'];

    // public function room(): BelongsTo
    // {
    //     return $this->belongsTo(Room::class);
    // }

    public function DataEntry(): HasMany
    {
        return $this->hasMany(DataEntry::class);
    }
    public function Room(): HasOne
    {
        return $this->hasOne(Room::class);
    }

    public function latestDataEntry()
    {
        return $this->hasOne(DataEntry::class)->latest();
    }
}
