<div class="clock-container text-center mb-4">
    <div id="date" class="h5 font-weight-bold"></div>
    <div id="time" class="h3 font-weight-bold"></div>
</div>

<script>
    function updateClock() {
        const now = new Date();

        // Format tanggal
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = now.toLocaleDateString('id-ID', options);

        // Format waktu
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const time = `${hours}:${minutes}:${seconds}`;

        // Update DOM
        document.getElementById('date').textContent = date;
        document.getElementById('time').textContent = time;
    }

    // Jalankan setiap detik
    setInterval(updateClock, 1000);
    updateClock();
</script>
