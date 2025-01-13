<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create()
    {
        return view('admin.create_class');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|unique:classes',
        ]);

        // Simpan data kelas baru
        ClassModel::create($request->all());

        // Redirect ke halaman manage classes
        return redirect()->route('admin.manageClasses')->with('success', 'Class added successfully');
    }

    public function edit(ClassModel $class)
    {
        return view('admin.edit_class', compact('class'));
    }

    public function update(Request $request, ClassModel $class)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|unique:classes,name,' . $class->id,
        ]);

        // Update data kelas
        $class->update($request->all());

        // Redirect ke halaman manage classes
        return redirect()->route('admin.manageClasses')->with('success', 'Class updated successfully');
    }

    public function destroy(ClassModel $class)
    {
        // Hapus kelas
        $class->delete();

        // Redirect ke halaman manage classes
        return redirect()->route('admin.manageClasses')->with('success', 'Class deleted successfully');
    }
}
