@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <!-- Kapasitas Kelas -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kapasitas Kelas</h6>
                </div>
                <div class="card-body">
                    @php
                        $colors = ['danger', 'warning', 'info', 'success'];
                    @endphp

                    @foreach($classes as $index => $class)
                        @php
                            $percentage = ($class->students_count / 30) * 100;
                            $colorClass = $colors[$index % count($colors)];
                        @endphp

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="m-0 font-weight-bold text-{{ $colorClass }}">{{ $class->name }}</h6>
                                <small class="text-muted">
                                    {{ $class->students_count }}/30
                                    ({{ number_format($percentage, 1) }}%)
                                </small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $colorClass }}"
                                     role="progressbar"
                                     style="width: {{ $percentage }}%"
                                     aria-valuenow="{{ $class->students_count }}"
                                     aria-valuemin="0"
                                     aria-valuemax="30">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pie Chart Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Siswa per Kelas</h6>
                </div>

                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="classStudentChart"></canvas>
                    </div>

                    <div class="mt-4 text-center small">
                        @foreach($classes as $index => $class)
                            <span class="mr-2">
                                <i class="fas fa-circle text-{{ ['primary', 'success', 'info', 'warning', 'danger'][$index % 5] }}"></i>
                                {{ $class->name }} ({{ $class->students_count }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('classStudentChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($classes->pluck('name')),
            datasets: [{
                data: @json($classes->pluck('students_count')),
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',   // primary
                    'rgba(28, 200, 138, 0.8)',   // success
                    'rgba(54, 185, 204, 0.8)',   // info
                    'rgba(255, 193, 7, 0.8)',    // warning
                    'rgba(231, 74, 59, 0.8)'     // danger
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        }
    });
});
</script>
@endpush
@endsection
