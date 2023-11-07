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
