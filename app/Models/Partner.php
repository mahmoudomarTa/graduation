<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('uploads/images/partners/' . $value) : url('uploads/images/partners/defualt.jpg');
    }
}

