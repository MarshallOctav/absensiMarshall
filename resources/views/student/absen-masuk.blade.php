<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <style>
        body {
            background-color: #f6f7fb;
            color: #333;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 30%;
            background-color: #4e73df;
            z-index: -1;
        }

        .header {
            background-color: #4e73df;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .absen {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            padding: 16px;
            width: 90%;
            max-width: 500px;
        }

        video {
            display: block;
            width: 100%;
            height: auto;
            margin-bottom: 16px;
            border-radius: 10px;
        }

        #absenMasukBtn, #start-btn {
            font-weight: bold;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            width: 100%;
            margin: 10px 0;
        }

        #absenMasukBtn:disabled, #start-btn:disabled {
            background-color: #d1d1d1;
            cursor: not-allowed;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>Absen Masuk</h1>
    </div>
    <div class="absen">
        <video id="webcam" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <form id="attendance-form">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <input type="hidden" id="image" name="image">
            <input type="hidden" name="student_id" value="1"> <!-- ID Siswa diisi dinamis -->
            <button type="button" id="start-btn">Aktifkan Webcam</button>
            <button type="submit" id="absenMasukBtn" disabled>Absen Masuk</button>
        </form>
    </div>

    <script>
        const webcam = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const startBtn = document.getElementById('start-btn');
        const absenMasukBtn = document.getElementById('absenMasukBtn');
        let stream = null;

        // Aktifkan Webcam
        startBtn.addEventListener('click', async () => {
            // Dapatkan lokasi
            navigator.geolocation.getCurrentPosition(
                position => {
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    checkReadyState();
                },
                error => {
                    alert('Gagal mendapatkan lokasi. Pastikan GPS aktif.');
                }
            );

            // Aktifkan webcam
            try {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    webcam.srcObject = stream;
                    checkReadyState();
                }
            } catch (error) {
                alert('Gagal mengaktifkan webcam. Periksa izin kamera.');
            }
        });

        // Cek apakah form siap
        function checkReadyState() {
            if (latitudeInput.value && longitudeInput.value && stream) {
                absenMasukBtn.disabled = false;
            }
        }

        // Ambil Gambar dan Kirim Data
        document.getElementById('attendance-form').addEventListener('submit', (e) => {
            e.preventDefault();

            if (!latitudeInput.value || !longitudeInput.value) {
                alert('Lokasi tidak ditemukan. Pastikan GPS aktif.');
                return;
            }

            const ctx = canvas.getContext('2d');
            canvas.width = webcam.videoWidth;
            canvas.height = webcam.videoHeight;
            ctx.drawImage(webcam, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                const formData = new FormData();
                formData.append('latitude', latitudeInput.value);
                formData.append('longitude', longitudeInput.value);
                formData.append('student_id', 1); // Ganti dengan ID dinamis
                formData.append('image', blob, 'attendance.jpg');

                axios.post('/attendance', formData)
                    .then(response => {
                        alert(response.data.message);

                        // Simpan status absen di localStorage
                        localStorage.setItem('absenMasuk', true);

                        // Hentikan stream webcam
                        if (stream) {
                            stream.getTracks().forEach(track => track.stop());
                            stream = null;
                        }

                        // Pindah ke halaman home
                        window.location.href = "{{ route('student.home') }}";
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Terjadi kesalahan saat mengirim data.');
                    });
            }, 'image/jpeg');
        });
    </script>

</body>
</html>
