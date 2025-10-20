<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level_id',
        'department_id',
        'admission_no',
        'phone'
    ];


    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
