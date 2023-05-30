<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEntry extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'sensor_id', 'PWR', 'log_at'];
}
