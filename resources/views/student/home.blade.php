<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f6f7fb; /* Warna dasar body */
            color: #333;
            position: relative; /* Agar pseudo-element berfungsi dengan baik */
            min-height: 100vh; /* Memastikan halaman memenuhi tinggi penuh */
        }

        /* Tambahkan warna setengah halaman dengan pseudo-element */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 30%; /* Menentukan setengah bagian halaman */
            background-color: #4e73df; /* Warna untuk setengah halaman */
            z-index: -1; /* Agar berada di belakang konten */
        }

        /* Header */
        .header {
            background-color: #4e73df;
            padding: 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
        }

        .header .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
        }

        /* Tombol Logout */
        .header .logout-btn {
            background-color: #dc3545; /* Warna merah untuk tombol logout */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .header .logout-btn:hover {
            background-color: #c82333; /* Warna lebih gelap saat hover */
        }

        /* Kotak Selamat Datang dan Menu */
        .welcome-menu-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            position: relative;
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }

        .welcome h2 {
            color: #6c63ff;
            font-size: 24px;
        }

        .welcome h3 {
            font-size: 18px;
            margin-top: 10px;
        }

        /* Menu Section */
        .menu {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .menu .menu-item {
            background-color: #fff;
            border-radius: 10px;
            width: 19%;
            padding: 26px;
            text-align: center;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            cursor: pointer;
            text-decoration: none;
        }

        .menu .menu-item i {
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 20%; /* Ikon tetap berbentuk bulat */
        }

        .menu .menu-item:hover {
            background-color: transparent; /* Hilangkan perubahan warna */
            box-shadow: none; /* Hilangkan bayangan */
        }

        span {
            color: #525252;
        }

        /* Table Section */
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-container h3 {
            color: #4e73df;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
        }

        ```html
        table th {
            background-color: #4e73df;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:nth-child(odd) {
            background-color: #e4e8fc;
        }

        table td {
            color: #333;
        }
    </style>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Absensi</h1>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <!-- Form logout menggunakan POST method dan csrf token -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout()">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Dashboard -->
    <div class="dashboard">
        <!-- Bungkus Selamat Datang dan Menu -->
        <div class="welcome-menu-container">
            <!-- Welcome Section -->
            <div class="welcome" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="text-align: left;">
                    <h4>Selamat Sore</h4>
                    <h1>{{ auth()->user()->name }}</h1>
                </div>

            </div>
            <hr>
            <img src="" alt="">
            <!-- Menu Section -->
            <div class="menu">
                <a href="{{ route('absen.masuk') }}" class="menu-item">
                    <i class="fas fa-sign-in-alt" aria-hidden="true" style="background-color:#f43268;"></i>
                    <span>Masuk</span>
                </a>
                <a href="#" class="menu-item" id="absen-pulang">
                    <i class="fas fa-sign-out-alt" aria-hidden="true" style="background-color: #1dce72;"></i>
                    <span>Pulang</span>
                </a>

                <a href="/jadwal" class="menu-item">
                    <i class="fas fa-calendar-alt" aria-hidden="true" style="background-color: #4e73df;"></i>
                    <span>Jadwal</span>
                </a>
                <a href="/nilai" class="menu-item">
                    <i class="fas fa-pencil-alt
                    " aria-hidden="true" style="background-color: #fab202;"></i>
                    <span>Nilai</span>
                </a>
            </div>
        </div>
        <!-- Table Section -->
        <div class="table-container">
            <h3>1 Minggu Terakhir</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absences as $absence)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absence->date)->format('d-m-Y') }}</td>
                            <td>{{ $absence->check_in ? \Carbon\Carbon::parse($absence->check_in)->format('H:i:s') : '-' }}</td>
                            <td>{{ $absence->check_out ? \Carbon\Carbon::parse($absence->check_out)->format('H:i:s') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan tanggal saat ini
    const currentDate = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD

    // Mendapatkan tanggal terakhir dari localStorage
    const lastStoredDate = localStorage.getItem('lastStoredDate');

    // Memeriksa apakah tanggal telah berubah
    if (lastStoredDate !== currentDate) {
        // Jika tanggal berbeda, hapus semua data di localStorage
        localStorage.clear();
        // Simpan tanggal saat ini ke localStorage
        localStorage.setItem('lastStoredDate', currentDate);
    }
    });

document.getElementById('absen-pulang').addEventListener('click', function (event) {
    event.preventDefault(); // Mencegah navigasi default

    // Cek apakah sudah absen pulang
    const absenPulang = localStorage.getItem('absenPulang');

    if (absenPulang === 'true') {
        // Tampilkan modal info jika sudah absen pulang
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: 'Anda sudah absen pulang.',
            confirmButtonText: 'OK'
        });
        return; // Hentikan eksekusi jika sudah absen pulang
    }

    // Tampilkan modal loading
    Swal.fire({
        title: 'Memproses Absen Pulang...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Kirim data ke server
    fetch("{{ route('absen.pulang') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({}) // Tidak perlu mengirimkan data lain
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Simpan status absen pulang ke localStorage
            localStorage.setItem('absenPulang', 'true');

            // Tampilkan pesan berhasil
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonText: 'OK'
            });
        } else {
            // Tampilkan pesan error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menyimpan data.',
            confirmButtonText: 'OK'
        });
    });
});
        // Fungsi untuk menampilkan modal jika sudah absen masuk
        function handleMasukClick(event) {
            const absenMasuk = localStorage.getItem('absenMasuk'); // Ambil nilai absenMasuk dari localStorage

            if (absenMasuk === 'true') {
                event.preventDefault(); // Mencegah aksi default tombol (navigasi)
                Swal.fire({
                    title: 'Informasi',
                    text: 'Anda sudah absen masuk.',
                    icon: 'info',
                    confirmButtonColor: '#4e73df',
                    confirmButtonText: 'OK'
                });
            }
        }

        // Tambahkan event listener ke tombol masuk
        document.addEventListener('DOMContentLoaded', function () {
            const absenMasukButton = document.querySelector('[href="{{ route('absen.masuk') }}"]'); // Tombol "Masuk"
            if (absenMasukButton) {
                absenMasukButton.addEventListener('click', handleMasukClick); // Tambahkan handler untuk klik
            }
        });

        // Fungsi untuk logout dengan SweetAlert2
        // Fungsi untuk logout dengan SweetAlert2
        function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan diarahkan ke halaman login.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Menghapus semua data di localStorage
                localStorage.clear();

                // Menyerahkan form logout untuk mengarahkan pengguna keluar
                document.getElementById('logout-form').submit();
            }
        });

        document.getElementById('absen-pulang').addEventListener('click', function (event) {
        event.preventDefault(); // Mencegah navigasi default

        // Tampilkan modal loading
        Swal.fire({
            title: 'Memproses Absen Pulang...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Kirim data ke server
        fetch("{{ route('absen.pulang') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({}) // Tidak perlu mengirimkan data lain
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan pesan berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
                // Tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat menyimpan data.',
                confirmButtonText: 'OK'
            });
        });
    });


}

    </script>

</body>

</html>
