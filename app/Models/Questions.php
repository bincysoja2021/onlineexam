<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $table="questions";
    protected $fillable = [
        'id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option'
    ];
}
