<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'Position_x', 'Position_y', 'Details'];
    public function DataEntry(): HasMany
    {
        return $this->hasMany(DataEntry::class);
    }
}
