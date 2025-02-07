<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Absensi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #4e73df;
            --accent-color: #4f46e5;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--light-color) 50%, #e2e8f0 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2rem 1rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -50px;
            left: -10%;
            width: 120%;
            height: 60px;
            background: var(--light-color);
            transform: rotate(-3deg);
        }

        .header h1 {
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 1s ease;
        }

        .schedule-container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .schedule-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .schedule-card:hover {
            transform: translateY(-5px);
        }

        .schedule-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        img:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.2);
        }

        .calendar-icon {
            font-size: 2rem;
            margin-right: 1rem;
            animation: bounce 2s infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
            60% {
                transform: translateY(-7px);
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .schedule-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            <i class="fas fa-calendar-alt calendar-icon"></i>
            Jadwal Pelajaran
        </h1>
    </div>

    <div class="schedule-container">
        <div class="schedule-card">
            <img src="{{ asset('assets/img/jadwal.png') }}"
                 alt="Jadwal Digital"
                 class="schedule-image">
        </div>
    </div>
</body>
</html>
