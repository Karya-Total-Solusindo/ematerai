<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use HasFactory;
    protected $table = 'document';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'user_id',
        'company_id',
        'directory_id',
        'docnumber',
        'template',
        'x1',
        'x2',
        'y1',
        'y2',
        'height',
        'width',
        'page',
        'source',
        'filename',
        'certificatelevel',
        'namadoc',
        'namadoc_detail',

    ];

    //TODO Filter
    public function scopefilter($query, array $filters){
        // $query->when($filters['s'] ?? false, function($query, $s){
        //     return $query->where('filename','like','%'.$s.'%')
        //                 ->where('user_id','=',Auth::user()->id)
        //                 ->orderBy('updated_at', 'desc');
        //                  //->whereBetween('updated_at', )
        //                 //  ->orWhere('company','like','%'.$s.'%');   
        // });
        // $query->when($filters['company'] ?? false, function($query, $company){
        //     return $query->whereHas('company', function($query) use ($company) {
        //         $query->where('id', $company)
        //         ->where('user_id','=',Auth::user()->id)
        //         ->orderBy('updated_at', 'desc');
        //     });  
        // });
        $query->when($filters['directory'] ?? false, function($query, $directory){
            return $query->whereHas('directory', function($query) use ($directory){
                $query->where('id', $directory)
                ->where('user_id','=',Auth::user()->id)
                ->orderBy('updated_at', 'desc');
            });  
        });
        // $query->when(($filters['company'] ?? false) && ($filters['directory'] ?? false), function($query, $company, $directory){
        //     return $query->whereHas('company', function($query) use ($company,$directory){
        //         $query->where('company', $company)
        //         ->where('directory', $directory)
        //         ->where('user_id','=',Auth::user()->id)
        //         ->orderBy('updated_at', 'desc');
        //     });  
        // });
        $query->when($filters['periode'] ?? false, function($query, $periode){
            //return $query->where('document', function($query) use ($periode) {
                $splitdate = explode('-',$periode);
                $dateStart = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-',$splitdate[0])));
                $dateEnd = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-',$splitdate[1])));
                return    $query->where('user_id','=',Auth::user()->id)
                ->whereBetween('updated_at',[$dateStart, $dateEnd])
                ->orderBy('updated_at', 'desc');
            //});   
        });

    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id','document')->withDefault();
    }
    public function pemungut()
    {
        return $this->belongsTo(Pemungut::class,'user_id','user_id','document')->withDefault();
    }
    public function company()
    {
        // return $this->belongsTo(Company::class,'directories','id','company_id');
        return $this->belongsTo(Company::class)->withDefault();
    }
    public function directory()
    {
        // return $this->belongsTo(Company::class,'directories','id','company_id');
        return $this->belongsTo(Directory::class)->withDefault();
    }
    // public function pemungut()
    // {
    //     // return $this->belongsTo(Company::class,'directories','id','company_id');
    //     return $this->hasOneThrough(Document::class,Pemungut::class,'user_id','user_id','id','id')->withDefault('token');
    // }
}
