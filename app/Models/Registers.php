<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registers extends Model
{
    use HasFactory;
    protected $table = 'registers';
    protected $primaryKey = 'reg_id';
    protected $fillable = [
        'name',
        'email',
        'gender',
        'country',
        'quali',
        'password',
        'image',
    ];
}
