@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Students</h1>

    <!-- Form Pencarian dan Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('admin.manageStudents') }}" method="GET" class="form-inline">
                <div class="input-group mr-2">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or student ID..." value="{{ request('search') }}">
                </div>
                <div class="input-group mr-2">
                    <select name="class_id" class="form-control">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('admin.manageStudents') }}" class="btn btn-secondary ml-2">Reset</a>
            </form>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.createStudent') }}" class="btn btn-success">Add New Student</a>
        </div>
    </div>

    <!-- Tabel Students -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Student ID</th>
                <th>Class</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($students->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No students found.</td>
                </tr>
            @else
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->class->name }}</td>
                        <td>
                            <a href="{{ route('admin.editStudent', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{ $student->id }}" data-name="{{ $student->name }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="studentName"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var studentId = button.data('id'); // Extract info from data-* attributes
            var studentName = button.data('name');

            var modal = $(this);
            modal.find('#studentName').text(studentName);
            modal.find('#deleteForm').attr('action', '/admin/students/' + studentId); // Adjust route as necessary
        });
    });
</script>
@endpush
