<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serialnumber extends Model
{
    use HasFactory;
    protected $table = 'serialnumber';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'documet_id',
        'sn', 
        'image',
        'namejidentitas',
        'noidentitas',
        'namedipungut',
        'docid',
        'nodoc',
        'use',
        'useby',
    ];
    protected $hidden = [
        'sn',
        'noidentitas',
    ];
}
