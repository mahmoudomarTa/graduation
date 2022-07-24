<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory,SoftDeletes,Translatable;
    protected $translatedAttributes = ['name'];

    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('uploads/images/departments/' . $value) : url('uploads/images/users/defualtUser.jpg');
    }

    public function scopeFilter($query)
    {
        if (request()->has('name')) {
            if (request()->get('name') != null)
                $query->where(function($q)
                {$q->whereTranslationLike('name', '%'. request()->get('name').'%');
                });
        }


        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }

    }

    public  function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function years(){
      return  $this->hasMany(DepartmentYear::class);
    }


}
