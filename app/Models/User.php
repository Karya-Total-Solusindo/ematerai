<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'password',
        'address',
        'city',
        'country',
        'postal',
        'about',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ematerai_token', // Token dari login peruri 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
    * @return string
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function company()
    {
        return $this->hasMany(Company::class);
    }

    public function pemungut()
    {
        return $this->hasOne(Pemungut::class)->withDefault();
    }

    public function scopefilter($query, array $filters){
        $query->when($filters['active'] ?? false, function($query, $active){
            // return $query->where('active', function($query) use ($active){
                if($active=='true'){
                    return    $query->where('active','1');
                }else{
                    return    $query->where('active','0');
                }
            // });  
        });

        // $query->when($filters['periode'] ?? false, function($query, $periode){
        //     //return $query->where('document', function($query) use ($periode) {
        //         $splitdate = explode('-',$periode);
        //         $dateStart = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-',$splitdate[0])));
        //         $dateEnd = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-',$splitdate[1])));
        //         return    $query->where('user_id','=',Auth::user()->id)
        //         ->whereBetween('updated_at',[$dateStart, $dateEnd])
        //         ->orderBy('updated_at', 'desc');
        //     //});   
        // });

    }

}
