<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports | HR Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <!-- Sidebar -->
    @include('hrms::partials.sidebar')


    <!-- Main Content -->
    <div class="report-main-content">
        <div class="report-top-bar">
            <div>Reports & Analytics</div>
            <div>Admin <button class="report-logout-btn">Logout</button></div>
        </div>

        <!-- Stats Cards -->
        <div class="report-stats">
            <div class="report-stat-card">
                <h2>{{ $totalRegistered }}</h2>
                <p>Total Registered</p>
            </div>
            <div class="report-stat-card">
                <h2>{{ $verified }}</h2>
                <p>Verified</p>
            </div>
            <div class="report-stat-card">
                <h2>{{ $pending }}</h2>
                <p>Pending Verification</p>
            </div>
        </div>

        <!-- Charts -->
        <!-- Charts -->
        <div class="report-charts">
            <div class="report-chart-card" style="height: 340px;">
                <h3>Monthly Registrations ({{ now()->year }})</h3>
                <canvas id="report-barChart"></canvas>
            </div>

            <div class="report-chart-card"
                style="height: 340px; display: flex; flex-direction: column; justify-content: center;">
                <h3>Verification Breakdown</h3>
                <canvas id="report-pieChart" style="max-height: 260px; max-width: 100%; margin: 0 auto;"></canvas>
            </div>
        </div>

        <script>
            function toggleMenu(header) {
                const submenu = header.nextElementSibling;
                const isOpen = submenu.classList.contains("open");
                document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
                document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
                if (!isOpen) {
                    submenu.classList.add("open");
                    header.classList.add("active");
                }
            }

            function toggleDropdown(trigger) {
                const container = trigger.nextElementSibling;
                const isOpen = container.classList.contains("open");
                trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList
                    .remove("open"));
                trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove(
                    "active"));
                if (!isOpen) {
                    container.classList.add("open");
                    trigger.classList.add("active");
                }
            }

            const barLabels = @json($months);
            const barData = @json($chartData);
            const verified = {{ $verified }};
            const pending = {{ $pending }};

            // Bar Chart
            new Chart(document.getElementById('report-barChart'), {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Registered Candidates',
                        data: barData,
                        backgroundColor: '#90caf9',
                        hoverBackgroundColor: '#047edf'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Pie Chart
            new Chart(document.getElementById('report-pieChart'), {
                type: 'pie',
                data: {
                    labels: ['Pending', 'Verified'],
                    datasets: [{
                        data: [pending, verified],
                        backgroundColor: ['#bce5ff', '#047edf'],
                        hoverBackgroundColor: ['#90caf9', '#5ba9f5']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>
</body>

</html>
