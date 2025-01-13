<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function student()
{
    return $this->hasOne(Student::class); // Pastikan ini sesuai dengan hubungan di database
}
    // Tambahkan method isAdmin()
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Opsional: tambahkan juga method untuk role lainnya
    public function isTeacher()
    {
        return $this->role === 'guru';
    }

    public function isStudent()
    {
        return $this->role === 'siswa';
    }
}
