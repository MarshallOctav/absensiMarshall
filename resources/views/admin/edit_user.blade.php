@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit User</h1>

    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="guru" {{ $user->role === 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ $user->role === 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>

        <div class="mb-3" id="class-section" style="{{ $user->role === 'siswa' ? 'display:block' : 'display:none' }}">
            <label for="class_id" class="form-label">Class</label>
            <select class="form-control" id="class_id" name="class_id">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $user->class_id === $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    const classSection = document.getElementById('class-section');
    if (this.value === 'siswa') {
        classSection.style.display = 'block';
    } else {
        classSection.style.display = 'none';
    }
});
</script>
@endsection
