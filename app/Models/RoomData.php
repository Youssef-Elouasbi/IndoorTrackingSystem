<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoomData extends Model
{
    use HasFactory;
    protected $fillable = ['room', 'data_entries_id'];





    public function DataEntry(): HasOne
    {
        return $this->hasOne(DataEntry::class, 'id', 'data_entries_id');
    }
}
