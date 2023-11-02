<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;

class Company extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'detail','user_id'
    ];
    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function directory()
    {
        return $this->hasMany(Directory::class,'company_id','id');
    }
}
