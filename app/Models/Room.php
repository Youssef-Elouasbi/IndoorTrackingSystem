<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'Position_x', 'Position_y', 'Length', 'Width'];
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
    public function room_data(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
