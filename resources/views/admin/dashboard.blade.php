@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kapasitas Kelas</h6>
                </div>
                <div class="card-body">
                    @php $colors = ['danger', 'warning', 'info', 'success']; @endphp
                    @foreach($classes as $index => $class)
                        @php
                            $percentage = ($class->students_count / $maxClassCapacity) * 100;
                            $colorClass = $colors[$index % count($colors)];
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="m-0 font-weight-bold text-{{ $colorClass }}">{{ $class->name }}</h6>
                                <small class="text-muted">{{ $class->students_count }}/{{ $maxClassCapacity }} ({{ number_format($percentage, 1) }}%)</small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $colorClass }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $class->students_count }}" aria-valuemin="0" aria-valuemax="{{ $maxClassCapacity }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran</h6>
                </div>
                <div class="card-body">
                    @php
                    $onTimeCount = $attendances->filter(function ($attendance) {
                        return $attendance->check_in_status === 'on_time';
                    })->count();

                    $lateCount = $attendances->filter(function ($attendance) {
                        return $attendance->check_in_status === 'late';
                    })->count();
                @endphp

                    @if($onTimeCount + $lateCount > 0)
                        <div class="chart-bar">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    @else
                        <p class="text-center text-muted">Belum ada data kehadiran.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($onTimeCount + $lateCount > 0)
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tepat Waktu', 'Terlambat'],
                datasets: [{
                    data: [{{ $onTimeCount }}, {{ $lateCount }}],
                    backgroundColor: ['rgba(28, 200, 138, 0.8)', 'rgba(231, 74, 59, 0.8)']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    @endif
});
</script>
@endpush
@endsection
