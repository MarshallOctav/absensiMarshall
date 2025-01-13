<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Attendance extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'attendances'; // Nama tabel yang baru

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'student_id',
        'date',
        'check_in',
        'check_out',
        'start_time',
        'end_time',
        'latitude',
        'longitude',
        'image',
        'check_in_status',
        'check_out_status',
        'late_reason',
        'early_leave_reason',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }

    // Relasi dengan model Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
