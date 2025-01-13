<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi App - Welcome</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center relative">
    <div class="max-w-lg mx-auto text-center p-8 bg-white shadow-lg rounded-lg transform transition-all duration-300 hover:scale-105 relative z-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang</h1>
        <p class="text-gray-600 mb-6">Aplikasi absensi resmi SMK 911, memudahkan anda untuk menginput absensi harian dan melihat riwayat absensi.</p>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transform transition-all duration-300 hover:scale-110">Log in</a>
        </div>
    </div>

    <!-- Animated background circles -->
    <div class="absolute inset-0 overflow-hidden z-0">
        <div class="bg-blue-400 opacity-50 w-72 h-72 rounded-full absolute top-0 left-10 animate-ping"></div>
        <div class="bg-indigo-400 opacity-30 w-96 h-96 rounded-full absolute bottom-10 right-10 animate-ping"></div>
    </div>

    <footer class="absolute bottom-4 w-full text-center text-gray-100 text-sm">
        &copy; 2024 SMK 911 ABSENSI RORRRR 💀
    </footer>
</body>
</html>
