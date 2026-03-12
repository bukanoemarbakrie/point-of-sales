<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'gender', 'address', 'image'
    ];
    protected $casts = [
    'gender' => 'integer', // if column is INT
    ];
}
