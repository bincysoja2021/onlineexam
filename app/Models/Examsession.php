<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examsession extends Model
{
    use HasFactory;
    protected $table="exam_sessions";
    protected $fillable = [
        'id',
        'user_id',
        'start_time',
        'end_time',
        'status'
    ];
}