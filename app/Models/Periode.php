<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table = "periode";



    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}

