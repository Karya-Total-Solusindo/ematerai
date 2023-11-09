<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'company_id',
        'user_id',
        'template',
        'x1',
        'x2',
        'y1',
        'y2',
        'height',
        'width',
        'page',
    ];

    public function company()
    {
        // return $this->belongsTo(Company::class,'directories','id','company_id');
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class,'companies','id','user_id');
    }
}
