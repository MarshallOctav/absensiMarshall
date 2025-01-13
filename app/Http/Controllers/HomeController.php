@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Kotak Utama -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ auth()->user()->name }}</h6>
        </div>
        <div class="card-body">
            <!-- Tanggal dan Jam -->
            @include('student.clock')

            <!-- Tombol Absen -->
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <a href="#" class="btn btn-success mx-2" data-toggle="modal" data-target="#checkInModal">Absen Masuk</a>
                    <a href="#" class="btn btn-danger mx-2" onclick="handleCheckOut()">Absen Pulang</a>
                </div>
            </div>

            <!-- Section Tombol Coming Soon -->
            <div class="row">
                <div class="col-lg-3 text-center">
                    <a href="#" class="btn btn-primary btn-block">Jadwal</a>
                </div>
                <div class="col-lg-3 text-center">
                    <a href="#" class="btn btn-primary btn-block">Absensi</a>
                </div>
                <div class="col-lg-3 text-center">
                    <a href="#" class="btn btn-primary btn-block">Nilai</a>
                </div>
                <div class="col-lg-3 text-center">
                    <a href="#" class="btn btn-primary btn-block">Event</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Absen Masuk -->
<div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInModalLabel">Absen Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('absen.masuk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="image">Ambil Foto</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokasi</label>
                        <div id="location"></div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Absen Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                document.getElementById('location').textContent = "Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude;
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Trigger location fetching when modal is shown
    $('#checkInModal').on('shown.bs.modal', function () {
        getLocation();
    });
</script>
@endsection
