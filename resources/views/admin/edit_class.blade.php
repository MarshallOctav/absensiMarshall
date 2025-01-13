@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Class</h1>

    <form action="{{ route('admin.updateClass', $class->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Class Name</label>
            <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control" value="{{ $class->start_time }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control" value="{{ $class->end_time }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Class</button>
    </form>
</div>
@endsection
