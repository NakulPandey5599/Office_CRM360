<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Verification</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<style>
    .main-content {
        margin-left: 30px;
        flex: 1;
        padding: 30px;
    }

    .header {
        display: flex;
        align-items: center;
        background: linear-gradient(to right, #bbf7d0, #86efac);
        padding: 15px 25px;
        font-size: 22px;
        font-weight: bold;
        color: #065f46;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .header .back {
        margin-right: 12px;
        font-size: 26px;
        cursor: pointer;
        color: #059669;
        transition: 0.2s;
    }

    .header .back:hover {
        transform: scale(1.2);
    }

    .table-container {
        max-width: 1000px;
        margin: 0 auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
    }

    thead {
        background: #d1fae5;
        color: #064e3b;
        font-weight: bold;
    }

    th,
    td {
        padding: 14px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    tbody tr:hover {
        background: #f0fdf4;
    }

    /* Popup alert */
    .popup {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
    }

    .popup-content {
        background: #fff;
        border-radius: 4px;
        padding: 15px 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        font-size: 15px;
        font-weight: 500;
        display: inline-block;
        min-width: 400px;
        text-align: center;
        opacity: 0.95;
    }

    .popup-content.success {
        border-left: 6px solid #22c55e;
        color: #166534;
        background: #dcfce7;
    }

    .popup-content.error {
        border-left: 6px solid #ef4444;
        color: #7f1d1d;
        background: #fee2e2;
    }
</style>

<body class="data">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>HRMS</h2>
        <div class="menu-section">
            <h3>
                <a href="main.html"
                    style="color:white; text-decoration:none; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </h3>
        </div>

        <!-- HR Management -->
        <div class="menu-section">
            <h3 onclick="toggleMenu(this)"><i class="fas fa-briefcase"></i> HR Management <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="index.html"><i class="fas fa-home"></i> Dashboard</a></li>
                <li>
                    <div class="dropdown-btn" onclick="toggleDropdown(this)"><i class="fas fa-user-plus"></i> Employee
                        Management <span class="arrow">▶</span></div>
                    <div class="dropdown-container">
                        <a href="{{ route('candidate.create') }}"><i class="fas fa-pen"></i> Candidate Registration</a>
                        <a href="{{ route('preJoiningProcess.index') }}"><i class="fas fa-user-check"></i> Pre-Joining
                            Process</a>
                        <a href="{{ route('dataVerification.index') }}" class="active"><i class="fas fa-id-card"></i>
                            Data Verification</a>
                    </div>
                </li>
                <li>
                    <div class="dropdown-btn" onclick="toggleDropdown(this)"><i class="fas fa-handshake"></i> Onboarding
                        & Confirmation <span class="arrow">▶</span></div>
                    <div class="dropdown-container">
                        <a href="offerletter.html"><i class="fas fa-file-signature"></i> Offer Letter</a>
                        <a href="joining.html"><i class="fas fa-user-tie"></i> Joining Letter</a>
                    </div>
                </li>
                <li><a href="training.html"><i class="fas fa-chalkboard-teacher"></i> Training & Assessment</a></li>
                <li><a href="reports.html"><i class="fas fa-chart-bar"></i> Reports</a></li>

            </ul>
        </div>

        <!-- Employee -->
        <div class="menu-section">
            <h3 onclick="toggleMenu(this)"><i class="fas fa-user-tie"></i> Employee <span class="arrow">▶</span></h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-users"></i> Employees</a></li>
                <li><a href="#"><i class="fas fa-building"></i> Department</a></li>
                <li><a href="#"><i class="fas fa-id-badge"></i> Designation</a></li>
                <li><a href="#"><i class="fas fa-award"></i> Appreciation</a></li>
            </ul>
        </div>

        <!-- Leaves & Holidays -->
        <div class="menu-section">
            <h3 onclick="toggleMenu(this)"><i class="fas fa-calendar-alt"></i> Leaves & Holidays <span
                    class="arrow">▶</span></h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-calendar-plus"></i> Leave Create</a></li>
                <li><a href="#"><i class="fas fa-glass-cheers"></i> Holiday Create</a></li>
            </ul>
        </div>

        <!-- Manage Shift -->
        <div class="menu-section">
            <h3 onclick="toggleMenu(this)"><i class="fas fa-clock"></i> Manage Shift <span class="arrow">▶</span></h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-calendar-day"></i> Shift Roster</a></li>
            </ul>
        </div>

        <!-- Payroll -->
        <div class="menu-section">
            <h3 onclick="toggleMenu(this)"><i class="fas fa-money-check"></i> Payroll <span class="arrow">▶</span></h3>
            <ul class="submenu">
                <li><a href="bulk.html"><i class="fas fa-clipboard-list"></i> Bulk Attendance</a></li>
                <li><a href="monthly.html"><i class="fas fa-calendar-check"></i> Monthly Payroll</a></li>
                <li><a href="hourly.html"><i class="fas fa-clock"></i> Hourly Payroll</a></li>
                <li><a href="payroll_final.html"><i class="fas fa-file-invoice-dollar"></i> Finalized Payroll</a></li>
            </ul>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content34">
        <div class="top-bar34">
            <div>HR Management System</div>
            <div>Admin <button class="logout-btn34">Logout</button></div>
        </div>

        <div class="main-content">
            <div class="header">
                <span class="back" onclick="goToDashboard()">&#8592;</span>
                Experienced Employees
            </div>

            <!-- Success/Error Popup -->
            @if (session('success') || session('error'))
                <div id="customPopup" class="popup">
                    <div class="popup-content {{ session('error') ? 'error' : 'success' }}">
                        <h2>{{ session('error') ? 'Error ' : 'Success' }}</h2>
                        <p>{{ session('error') ?? session('success') }}</p>
                        <button onclick="closePopup()">OK</button>
                    </div>
                </div>
            @endif

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Job Profile</th>
                            <th>Verification</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($experienced as $emp)
                            <tr>
                                <td>{{ $emp->first_name }}</td>
                                <td>{{ $emp->email }}</td>
                                <td>{{ $emp->job_profile }}</td>
                                <td>
                                    <a href="{{ route('dataVerification.show', ['id' => $emp->id]) }}">
                                        <button class="dash-btn dash-btn-approve">Verify</button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="color:#9ca3af; font-style:italic;">No experienced employees
                                    found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    <script>
        function toggleMenu34(element) {
            const submenu = element.nextElementSibling;
            if (submenu) submenu.classList.toggle('open');
            element.classList.toggle('active');
        }

        function toggleDropdown34(element) {
            const container = element.nextElementSibling;
            if (container) container.classList.toggle('open');
            element.classList.toggle('active');
        }

        function updateFileName34(input, btnId) {
            if (input.files.length > 0) {
                document.getElementById(btnId).textContent = "✅ " + input.files[0].name;
            }
        }
    </script>

</body>

</html>
