<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'certificatelevel'
    ];

    public function company()
    {
        // return $this->belongsTo(Company::class,'directories','id','company_id');
        return $this->belongsTo(Company::class);
    }
    public function directory()
    {
        // return $this->belongsTo(Company::class,'directories','id','company_id');
        return $this->belongsTo(Directory::class);
    }
}
