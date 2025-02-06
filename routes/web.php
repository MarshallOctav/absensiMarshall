<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\ClassModel;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

// Halaman dashboard setelah login
Route::middleware('auth')->get('/home', function () {
    return redirect()->route('dashboard');
});

// Halaman dashboard (admin atau teacher)
Route::get('/dashboard', function () {
    $classes = ClassModel::withCount('students')->get();
    return view('dashboard', compact('classes'));
})->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manage Students
    Route::get('/students', [AdminController::class, 'manageStudents'])->name('manageStudents');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('createStudent');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('storeStudent');
    Route::get('/students/{student}/edit', [AdminController::class, 'editStudent'])->name('editStudent');
    Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('updateStudent');
    Route::delete('/students/{student}', [AdminController::class, 'deleteStudent'])->name('deleteStudent');

    // Manage Attendance
    Route::get('/manage-attendance', [AdminController::class, 'manageAttendance'])->name('manageAttendance');
    Route::delete('/attendance/{attendance}', [AdminController::class, 'deleteAttendance'])->name('deleteAttendance');

    // Manage Classes
    Route::get('/classes', [AdminController::class, 'manageClasses'])->name('manageClasses');
    Route::get('/classes/create', [AdminController::class, 'createClass'])->name('createClass');
    Route::post('/classes', [AdminController::class, 'storeClass'])->name('storeClass');
    Route::get('/classes/{class}/edit', [AdminController::class, 'editClass'])->name('editClass');
    Route::put('/classes/{class}', [AdminController::class, 'updateClass'])->name('updateClass');
    Route::delete('/classes/{class}', [AdminController::class, 'deleteClass'])->name('deleteClass');

    // Manage Users
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('manageUsers');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('createUser');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('storeUser');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('editUser');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('updateUser');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('deleteUser');
});

// Teacher Routes
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

    // Route untuk manage attendance oleh teacher
    Route::get('/teacher/manage-attendance', [TeacherController::class, 'attendance'])->name('teacher.attendance');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('/student/home', [StudentController::class, 'index'])->name('student.home');
    Route::get('/student/absen/masuk', [StudentController::class, 'showCheckInForm'])->name('absen.masuk');
    Route::get('/student/absen/pulang', [StudentController::class, 'showCheckOutForm'])->name('absen.pulang');
    Route::post('/student/absen/pulang', [StudentController::class, 'storeCheckOut'])->name('absen.pulang.store');
});

Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
Route::post('/absen/pulang', [AttendanceController::class, 'absenPulang'])->name('absen.pulang');
Route::get('/attendance', [AttendanceController::class, 'index']);
Route::post('/attendance', [AttendanceController::class, 'store']);
Route::post('/student/absen/masuk', [AttendanceController::class, 'store'])->name('absen.masuk');
require __DIR__.'/auth.php';
