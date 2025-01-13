@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Classes</h1>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('admin.manageClasses') }}" method="GET" class="form-inline">
                <div class="input-group mr-2">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by class name..."
                           value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Search</button>
                <a href="{{ route('admin.manageClasses') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.createClass') }}" class="btn btn-success">Add New Class</a>
        </div>
    </div>

    <!-- Classes Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->start_time }}</td>
                            <td>{{ $class->end_time }}</td>
                            <td>{{ $class->students_count ?? 0 }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.editClass', $class->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{ $class->id }}" data-name="{{ $class->name }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                @if(request('search'))
                                    No classes found matching your search.
                                @else
                                    No classes available.
                                    <a href="{{ route('admin.createClass') }}" class="btn btn-link">Create a new class</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the class <strong id="className"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Event listener saat modal akan ditampilkan
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button yang diklik
        var classId = button.data('id'); // Ambil data-id
        var className = button.data('name'); // Ambil data-name

        // Masukkan nama class ke dalam modal
        var modal = $(this);
        modal.find('#className').text(className);

        // Set form action untuk class yang akan dihapus
        var form = modal.find('#deleteForm');
        form.attr('action', '{{ route('admin.deleteClass', '') }}/' + classId);
    });
</script>
@endpush
