<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;
    public function year(){
        return $this->belongsTo(Year::class);
    }


    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function getMainVideoAttribute(){
        return Video::where('course_id',$this->id)->orderByDesc('id')->first();
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }

    public function files(){
        return $this->hasMany(File::class);
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

        if (request()->has('department_id')) {
            if (request()->get('department_id') != null)
                $query->where('department_id', request()->get('department_id'));
        }


    }

}
