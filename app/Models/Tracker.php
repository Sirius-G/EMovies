<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{

    //Table Name
    protected $table = 'trackers';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tracer_type', 'current_play_time', 'total_play_time', 'tracer_id', 'percentage_completed', 'tracker_check',
    ];
}