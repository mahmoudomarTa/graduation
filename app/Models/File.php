<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
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
    public function getFileAttribute($image)
    {
        return !is_null($image) ? url('uploads/files/' . $image) : null;
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
