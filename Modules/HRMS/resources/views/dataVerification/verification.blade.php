<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Verification</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

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

        <div class="content-sections34">
            <div class="column34">
                <div class="card34">
                    <h3>Candidate Profile</h3>
                    <div class="profile-container34">
                        <div class="profile-photo34">M</div>
                        <div>
                            <div class="profile-info34">

                                <p><b>Name:</b> {{ $employee->first_name }}</p>
                                <p><b>Employee ID:</b> {{ $employee->id }}</p>
                                <p><b>Department:</b> {{ $employee->job_profile }}</p>
                                 <p><b>Joining Date:</b></p>

                            </div>
                            <span class="profile-status34">Pending</span>
                        </div>
                    </div>
                </div>

                <div class="card34">
                    <h3>Verification Request</h3>
                    <form action="{{ route('dataVerification.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="request-grid34">
                        <input type="text" name="previous_company_name" placeholder="Previous Company Name">
                        <input type="text" name="hr_contact_name" placeholder="HR Contact Name">
                        <input type="email" name="hr_contact_email" placeholder="HR Email ID">
                        <input type="text" name="hr_contact_phone" placeholder="HR Phone Number">
                    </div>
                    <div class="file-buttons34">
                        <input type="file" name="receiving_letter" id="receivingFile" style="display:none"
                            onchange="updateFileName34(this,'receivingBtn')">
                        <button type="button" id="receivingBtn"
                            onclick="document.getElementById('receivingFile').click()">📄 Receiving Letter</button>

                        <input type="file" name="experience_certificate" id="expFile" style="display:none"
                            onchange="updateFileName34(this,'expBtn')">
                        <button type="button" id="expBtn" onclick="document.getElementById('expFile').click()">📄
                            Experience Certificate</button>
                    </div>
                        <button type="submit" class="send-btn34" fdprocessedid="51djvk">Send Request</button>
                    </form>

                    <div class="timeline34">
                        <div class="step34">
                            <div class="circle34"></div>Request Sent
                        </div>
                        <div class="step34">
                            <div class="circle34"></div>Awaiting Response
                        </div>
                        <div class="step34">
                            <div class="circle34"></div>Approved / Rejected
                        </div>
                    </div>
                </div>
            </div>

            <div class="column34">
                <div class="card34">
                    <h3>HR Response</h3>
                    <p><b>HR Name:</b> {{ $dataVerification->hr_contact_name }}</p>
                    <p><b>Email:</b> {{ $dataVerification->hr_contact_email }}</p>
                    <p><b>Verification Result:</b> <span class="pending34">Awaiting Response</span></p>
                </div>

                <div class="card34">
                    <h3>Verification History</h3>
                    <div class="list-item34"><span>John Doe</span> <span class="verified34">Verified</span></div>
                    <div class="list-item34"><span>Rita Singh</span> <span class="pending34">Pending</span></div>
                    <div class="list-item34"><span>Amit Kumar</span> <span class="rejected34">Rejected</span></div>
                </div>
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
