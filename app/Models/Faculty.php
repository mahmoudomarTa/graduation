<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Faculty extends Authenticatable
{

    use HasFactory,SoftDeletes,Translatable;
    protected $translatedAttributes = ['name'];



    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('uploads/images/faculties/' . $value) : url('uploads/images/users/defualtUser.jpg');
    }

    public function departments(){
        return $this->hasMany(Department::class);
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

}
