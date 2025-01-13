<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    protected $table = 'Classes'; // Pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
    ];
}
