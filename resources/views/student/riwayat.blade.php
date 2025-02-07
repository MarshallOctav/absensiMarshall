<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Absensi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales/id.js'></script>
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

        .calendar-container {
            max-width: 900px;
            margin: 3rem auto;
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .legend {
            margin-top: 20px;
            font-size: 1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            margin-right: 10px;
            border-radius: 50%;
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

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            <i class="fas fa-pencil-alt pencil-icon"></i>
            Riwayat Absensi
        </h1>
    </div>
    <div class="schedule-container">
        <div class="calendar-container">
            <div id='calendar'></div>
            <div class="legend">
                <h6>Keterangan:</h6>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #4CAF50;"></div>
                    <span>Tepat Waktu</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #F44336;"></div>
                    <span>Terlambat</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                events: [
                    @foreach($attendances as $attendance)
                        {
                            start: '{{ $attendance->date }}',
                            color: '{{ $attendance->check_in_status == "Tepat Waktu" ? "#4CAF50" : ($attendance->check_in_status == "Terlambat" ? "#FFEB3B" : "#F44336") }}'
                        },
                    @endforeach
                ],
                eventRender: function(info) {
                    // Ensure the date number is visible
                    info.el.style.color = 'black'; // Set the text color to black
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
