<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $classes = ClassModel::withCount('students')->get();
        $attendances = Attendance::all();
        $maxClassCapacity = 30;

        return view('admin.dashboard', compact('classes', 'attendances', 'maxClassCapacity'));
    }

    public function manageStudents(Request $request)
    {
        $classes = ClassModel::all();
        $query = Student::query();

        // Filter berdasarkan kelas
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Pencarian berdasarkan nama atau student_id
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('student_id', 'LIKE', "%{$searchTerm}%");
            });
        }

        $students = $query->get();

        return view('admin.manage_students', compact('students', 'classes'));
    }

    public function manageClasses(Request $request)
    {
        // Query dasar untuk kelas
        $query = ClassModel::withCount('students');

        // Jika ada pencarian
        if ($request->has('search') && $request->search) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        // Ambil data kelas
        $classes = $query->get();

        // Kembalikan view dengan data
        return view('admin.manage_classes', compact('classes'));
    }

    public function createStudent()
    {
        $classes = ClassModel::all(); // Ambil data kelas
        return view('admin.create_student', compact('classes'));
    }
    public function storeStudent(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
        ]);

        // Menyimpan data siswa
        Student::create(array_merge($request->only(['name', 'student_id', 'class_id']), [
            'user_id' => auth()->id(), // Mengisi user_id dengan ID pengguna yang sedang login
        ]));

        return redirect()->route('admin.manageStudents')->with('success', 'Siswa berhasil ditambahkan');
    }
    public function createClass()
    {
        // Menampilkan form untuk menambahkan kelas baru
        return view('admin.create_class');
    }

    public function storeClass(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        // Menyimpan data kelas
        ClassModel::create($request->only(['name', 'start_time', 'end_time']));

        return redirect()->route('admin.manageClasses')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function editStudent(Student $student)
    {
        $classes = ClassModel::all(); // Ambil data kelas untuk dipilih
        return view('admin.edit_student', compact('student', 'classes'));
    }

    public function updateStudent(Request $request, Student $student)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P', // Validasi gender
        ]);

        // Update data siswa
        $student->update($request->only(['name', 'student_id', 'class_id']));

        return redirect()->route('admin.manageStudents')->with('success', 'Siswa berhasil diperbarui');
    }

    public function editClass(ClassModel $class)
    {
        return view('admin.edit_class', compact('class'));
    }

    public function updateClass(Request $request, ClassModel $class)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        // Update data kelas
        $class->update($request->only(['name', 'start_time', 'end_time']));

        return redirect()->route('admin.manageClasses')->with('success', 'Kelas berhasil diperbarui');
    }

    public function deleteStudent(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.manageStudents')->with('success', 'Siswa berhasil dihapus');
    }

    public function deleteClass(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('admin.manageClasses')->with('success', 'Kelas berhasil dihapus');
    }

    public function manageUsers(Request $request)
    {
        $classes = ClassModel::all();
        $query = User::where('role', '!=', 'admin');

        // Filter berdasarkan kelas
        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        // Pencarian berdasarkan nama atau email
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        $users = $query->get();

        return view('admin.manage_users', compact('users', 'classes'));
    }

    public function createUser ()
{
    $classes = ClassModel::all();
    return view('admin.create_user', compact('classes'));
}

public function storeUser(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:guru,siswa',
    ]);

    // Jika role adalah siswa, cek apakah nama ada di tabel students
    if ($validatedData['role'] === 'siswa') {
        $student = Student::where('name', $validatedData['name'])->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Nama siswa tidak terdaftar di sistem.');
        }
    }

    // Buat pengguna baru
    User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
        'role' => $validatedData['role'],
    ]);

    // Redirect ke halaman manageUsers dengan pesan sukses
    return redirect()->route('admin.manageUsers')->with('success', 'User created successfully.');
}

    public function updateUser (Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:guru,siswa',
        'class_id' => 'required_if:role,siswa|exists:classes,id'
    ]);

    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ];

    if ($request->password) {
        $userData['password'] = bcrypt($request->password); // Pastikan password di-hash
    }

    $userData['class_id'] = $request->role === 'siswa' ? $request->class_id : null;

    $user->update($userData);

    return redirect()->route('admin.manageUsers')->with('success', 'User  berhasil diperbarui');
}

    public function editUser(User $user)
    {
        $classes = ClassModel::all();
        return view('admin.edit_user', compact('user', 'classes'));
    }



    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.manageUsers')->with('success', 'User berhasil dihapus');
    }
    public function manageAttendance(Request $request)
    {
        // Ambil semua kelas
        $classes = ClassModel::all();

        // Query dasar untuk mengambil data absensi
        $query = Attendance::with(['student', 'student.class']);

        // Filter berdasarkan kelas jika ada class_id yang dipilih
        if ($request->has('class_id') && $request->class_id) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status) {
            $query->where('check_in_status', $request->status);
        }

        // Eksekusi query dan ambil hasilnya
        $attendances = $query->latest()->paginate(10);

        // Kirim data ke view
        return view('admin.manage_attendance', compact('attendances', 'classes'));
    }

    public function deleteAttendance(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.manageAttendance')
            ->with('success', 'Attendance record deleted successfully');
    }



}
