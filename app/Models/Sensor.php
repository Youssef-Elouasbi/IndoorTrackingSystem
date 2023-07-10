<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'position_x', 'position_y', 'details'];
    public function DataEntry(): HasMany
    {
        return $this->hasMany(DataEntry::class);
    }
}
