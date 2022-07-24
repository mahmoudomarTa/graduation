<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Video extends Model
{
    use HasFactory;
    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('uploads/images/videos/' . $value) : url('uploads/images/users/defualtUser.jpg');
    }

    public function getUrlAttribute($url){
        $search = '/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi';
        $replace = "youtube.com/embed/$1";
        $embed_url = preg_replace($search,$replace,$url);
        return $embed_url;
    }

    public function getIsFavoriteAttribute(){
        $check =$this->favorits()->where(function ($q){
            $q->where('user_key', Session::get('cart.ids'))->orWhere('user_id', auth('web')->id());
        })->first();

        if($check){
            return true;
        }
        return "0";
    }
    public function favorits(){
        return $this->hasMany(Favorite::class,"video_id");
    }

    public  function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function year(){
        return  $this->belongsTo(Year::class);
    }

    public function department(){
        return  $this->belongsTo(Department::class);
    }

    public function semester(){
        return  $this->belongsTo(Semester::class);
    }

    public function course(){
        return  $this->belongsTo(Course::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function scopeFilter($query)
    {
        if (request()->has('name')) {
            if (request()->get('name') != null)
                $query->where(function($q)
                {$q->where('name','like', '%'. request()->get('name').'%');
                });
        }


        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }

        if (request()->has('faculty_id')) {
            if (request()->get('faculty_id') != null)
                $query->where('faculty_id', request()->get('faculty_id'));
        }

        if (request()->has('department_id')) {
            if (request()->get('department_id') != null)
                $query->where('department_id', request()->get('department_id'));
        }
        if (request()->has('course_id')) {
            if (request()->get('course_id') != null)
                $query->where('course_id', request()->get('course_id'));
        }


        if (request()->has('year_id')) {
            if (request()->get('year_id') != null)
                $query->where('year_id', request()->get('year_id'));
        }
        if (request()->has('semester_id')) {
            if (request()->get('semester_id') != null)
                $query->where('semester_id', request()->get('semester_id'));
        }


    }



}
