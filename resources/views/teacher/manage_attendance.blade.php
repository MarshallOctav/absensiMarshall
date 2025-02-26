@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Attendance</h1>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('teacher.attendance') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <input type="date" name="date" class="form-control"
                               value="{{ request('date') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <a href="{{ route('teacher.attendance') }}" class="btn btn-secondary">Reset</a>
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
                            <th>Early Leave Reason</th>
                            <th>Created At</th>
                            <th>Updated At</th>
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
                                <td>{{ $attendance->early_leave_reason ?? '-' }}</td>

                                <!-- Timestamps -->
                                <td>{{ $attendance->created_at }}</td>
                                <td>{{ $attendance->updated_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center">No attendance records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
