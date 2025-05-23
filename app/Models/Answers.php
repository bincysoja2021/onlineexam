<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;
    protected $table="answers";
    protected $fillable = [
        'id',
        'user_id',
        'question_id',
        'selected_option'
    ];
}
