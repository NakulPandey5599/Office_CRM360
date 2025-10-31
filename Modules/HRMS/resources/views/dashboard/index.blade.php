<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <!-- Sidebar -->
    @include('hrms::partials.sidebar')

    <!-- Main dashboard -->
    <div class="monthly-main-content">
        <div class="monthly-top-bar">
            <div>HR Management System</div>
            <div>{{ Auth::user()->name ?? 'Admin' }} <button class="monthly-logout-btn">Logout</button></div>
        </div>

        <!-- Stats cards -->
        <div class="monthly-dashboard-cards">
            <div class="monthly-stat-card">
                <span class="emoji">👥</span>
                <h3>Registered Candidates</h3>
                <div class="number">{{ $registeredCandidates }}</div>
            </div>

            <div class="monthly-stat-card">
                <span class="emoji">⏳</span>
                <h3>Pending Pre-Joining</h3>
                <div class="number">{{ $pendingPreJoining }}</div>
            </div>

            <div class="monthly-stat-card">
                <span class="emoji">📄</span>
                <h3>Offer Letters Sent</h3>
                <div class="number">{{ $offerLettersSent }}</div>
            </div>

            <div class="monthly-stat-card">
                <span class="emoji">🎓</span>
                <h3>Active Training Modules</h3>
                {{-- <div class="number">{{ $activeTrainings }}</div> --}}
            </div>
        </div>

        <div class="monthly-content-sections">
            <!-- Left column -->
            <div class="monthly-column">
                <div class="monthly-card">
                    <h3>Employee Management Overview</h3>

                    <div class="monthly-subhead">Candidate Pipeline</div>
                    <div class="monthly-pipeline-wrap">
                        <div class="monthly-progress-track">
                            {{-- <div class="monthly-progress-fill" style="width: {{ $pipelineProgress }}%;"></div> --}}
                        </div>
                        <div class="monthly-pipeline-labels">
                            <span>Registration</span>
                            <span>Pre-Joining</span>
                            <span>Verification</span>
                        </div>
                    </div>

                    <div class="monthly-subhead">Latest Registered Candidates</div>
                    @foreach ($latestCandidates as $candidate)
                        <div class="monthly-list-item">
                            <span class="monthly-left-inline">
                                {{ $candidate->full_name }}
                                <span class="dept">{{ $candidate->job_profile }}</span>
                            </span>
                            <span
                                class="status {{ strtolower($candidate->status) }}">{{ ucfirst($candidate->status) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="monthly-card" style="flex:1;">
                    <h3>Training Completion Progress</h3>
                    <div class="monthly-chart-container">
                        <canvas id="monthly-trainingChart" class="monthly-tiny-canvas"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="monthly-column">
                <div class="monthly-card">
                    <h3>Onboarding & Confirmation</h3>
                    <div class="monthly-chart-container">
                        <canvas id="monthly-onboardingChart" class="monthly-tiny-canvas"></canvas>
                    </div>
                </div>

                <div class="monthly-card">
                    <h3>Latest Offer Letters</h3>
                    @foreach ($latestOffers as $offer)
                        <div class="monthly-list-item">
                            <span>{{ $offer->candidate_name }}</span>
                            <span class="monthly-status sent">Sent</span>
                        </div>
                    @endforeach
                </div>

                <div class="monthly-card">
                    <h3>Upcoming MCQ Assessments</h3>
                    {{-- @foreach ($upcomingAssessments as $assessment)
          <div class="monthly-list-item">
            <span>{{ $assessment->title }}</span>
            <span>{{ \Carbon\Carbon::parse($assessment->date)->format('M d - h:i A') }}</span>
          </div>
          @endforeach --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
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

        // Training chart (Dynamic)
        new Chart(document.getElementById('monthly-trainingChart'), {
            type: 'bar',
            data: {
                labels: @json($trainingLabels),
                datasets: [{
                    label: 'Completed',
                    data: @json($trainingData),
                    backgroundColor: '#047edf',
                    barThickness: 40,
                    maxBarThickness: 30,
                    categoryPercentage: 0.7,
                    barPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

        // Onboarding chart (Dynamic)
        new Chart(document.getElementById('monthly-onboardingChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Completed', 'Confirmed'],
                datasets: [{
                    data: @json($onboardingData),
                    backgroundColor: ['#bce5ff', '#047edf', '#82d173']
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
