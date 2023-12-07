<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemungut extends Model
{
    use HasFactory;
    protected $table = 'pemungut';
    protected $primaryKey = 'id';
    protected $foreignKey = 'user_id';
    protected $fillable = [
        'namejidentitas',
        'noidentitas',
        'namedipungut',
        'active',
        'user_id',
        'p_user',
        'p_password'
    ];
    protected $hidden = [
        'p_password',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class)->withDefault();
    // }
    
}
