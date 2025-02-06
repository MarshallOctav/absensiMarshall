@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Attendance</h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.manageAttendance') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <select name="class_id" class="form-control">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control"
                               value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">All Check-In Status</option>
                            <option value="tepat waktu" {{ request('status') == 'tepat waktu' ? 'selected' : '' }}>
                                Tepat Waktu
                            </option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <a href="{{ route('admin.manageAttendance') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check In Status</th>
                            <th>Check Out</th>
                            <th>Check Out Status</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Image</th>
                            <th>Late Reason</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->id }}</td>
                                <td>{{ $attendance->student_id }}</td>
                                <td>{{ $attendance->student->name }}</td>
                                <td>{{ $attendance->student->class->name }}</td>
                                <td>{{ $attendance->date }}</td>

                                <!-- Check In Details -->
                                <td>
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}
                                </td>
                                <td>
                                    @if($attendance->check_in_status)
                                        <span class="badge
                                            {{ $attendance->check_in_status == 'terlambat' ? 'badge-warning' : 'badge-success' }}">
                                            {{ $attendance->check_in_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <!-- Check Out Details -->
                                <td>
                                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}
                                </td>
                                <td>
                                    @if($attendance->check_out_status)
                                        <span class="badge
                                            {{ $attendance->check_out_status == 'pulang cepat' ? 'badge-warning' : 'badge-success' }}">
                                            {{ $attendance->check_out_status }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <!-- Location -->
                                <td>{{ $attendance->latitude ?? '-' }}</td>
                                <td>{{ $attendance->longitude ?? '-' }}</td>

                                <!-- Image -->
                                <td>
                                    @if($attendance->image)
                                        <button type="button" class="btn btn-primary btn-sm"
                                                data-toggle="modal"
                                                data-target="#imageModal{{ $attendance->id }}">
                                            View Image
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="imageModal{{ $attendance->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Attendance Image</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $attendance->image) }}"
                                                             class="img-fluid" alt="Attendance Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>

                                <!-- Reasons -->
                                <td>{{ $attendance->late_reason ?? '-' }}</td>


                                <!-- Timestamps -->
                                <td>{{ $attendance->created_at }}</td>
                                <td>{{ $attendance->updated_at }}</td>

                                <!-- Actions -->
                                <td>
                                    <form action="{{ route('admin.deleteAttendance', $attendance->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this attendance record?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center">No attendance records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $attendances->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
@endpush
@endsection
