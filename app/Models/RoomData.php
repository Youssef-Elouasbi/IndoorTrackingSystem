<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomData extends Model
{
    use HasFactory;
    protected $fillable = ['room', 'data_entries_id'];



    public function DataEntry(): HasMany
    {
        return $this->hasMany(DataEntry::class);
    }
}
