<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomData extends Model
{
    use HasFactory;
    protected $fillable = ['room', 'data_entries_id'];
}
