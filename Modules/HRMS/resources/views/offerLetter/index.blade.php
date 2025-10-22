<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Offer Letter | HR Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

    <!-- Sidebar same as index.html -->
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

        <div class="menu-section">
            <h3 onclick="toggleMenu(this)">
                <i class="fas fa-briefcase menu-icon"></i> HR Management
                <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="index.html"><i class="fas fa-home"></i> Dashboard</a></li>
                <li>
                    <div class="dropdown-btn" onclick="toggleDropdown(this)">
                        <i class="fas fa-user-plus"></i> Employee Management
                        <span class="arrow">▶</span>
                    </div>
                    <div class="dropdown-container">
                        <a href="reg.html"><i class="fas fa-pen"></i> Candidate Registration</a>
                        <a href="preeprocess.html"><i class="fas fa-user-check"></i> Pre-Joining Process</a>
                        <a href="dataverification.html"><i class="fas fa-id-card"></i> Data Verification</a>
                    </div>
                </li>
                <li>
                    <div class="dropdown-btn" onclick="toggleDropdown(this)">
                        <i class="fas fa-handshake"></i> Onboarding & Confirmation
                        <span class="arrow">▶</span>
                    </div>
                    <div class="dropdown-container">
                        <a href="offerletter.html"><i class="fas fa-file-signature"></i> Offer Letter</a>
                        <a href="joining.html"><i class="fas fa-user-tie"></i> Joining Letter</a>
                    </div>
                </li>
                <li><a href="training.html"><i class="fas fa-chalkboard-teacher"></i> Training & Assessment</a></li>
                <li><a href="reports.html"><i class="fas fa-chart-bar"></i> Reports</a></li>

            </ul>
        </div>

        <div class="menu-section">
            <h3 onclick="toggleMenu(this)">
                <i class="fas fa-user-tie menu-icon"></i> Employee
                <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-users submenu-icon"></i> Employees</a></li>
                <li><a href="#"><i class="fas fa-building submenu-icon"></i> Department</a></li>
                <li><a href="#"><i class="fas fa-id-badge submenu-icon"></i> Designation</a></li>
                <li><a href="#"><i class="fas fa-award submenu-icon"></i> Appreciation</a></li>
            </ul>
        </div>

        <div class="menu-section">
            <h3 onclick="toggleMenu(this)">
                <i class="fas fa-calendar-alt menu-icon"></i> Leaves & Holidays
                <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-calendar-plus submenu-icon"></i> Leave Create</a></li>
                <li><a href="#"><i class="fas fa-glass-cheers submenu-icon"></i> Holiday Create</a></li>
            </ul>
        </div>

        <div class="menu-section">
            <h3 onclick="toggleMenu(this)">
                <i class="fas fa-clock menu-icon"></i> Manage Shift
                <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-calendar-day submenu-icon"></i> Shift Roster</a></li>
            </ul>
        </div>

        <div class="menu-section">
            <h3 onclick="toggleMenu(this)">
                <i class="fas fa-money-check menu-icon"></i> Payroll
                <span class="arrow">▶</span>
            </h3>
            <ul class="submenu">
                <li><a href="bulk.html"><i class="fas fa-clipboard-list submenu-icon"></i> Bulk Attendance</a></li>
                <li><a href="monthly.html"><i class="fas fa-calendar-check submenu-icon"></i> Monthly Payroll</a></li>
                <li><a href="hourly.html"><i class="fas fa-clock submenu-icon"></i> Hourly Payroll</a></li>
                <li><a href="payroll_final.html"><i class="fas fa-file-invoice-dollar submenu-icon"></i> Finalized
                        Payroll</a></li>
            </ul>
        </div>
    </div>

    <!-- Main content -->
    <!-- Main content -->
    <div class="offer-main-content">
        <div class="offer-top-bar">
            <div>Offer Letter</div>
            <div>Admin <button class="offer-logout-btn">Logout</button></div>
        </div>

        <div class="offer-card">
            <div class="offer-profile" id="offerProfileBox">
                <div class="offer-profile-left">
                    <div class="offer-profile-pic" id="offerProfilePic">RK</div>
                    <div class="offer-profile-info">
                        <strong id="offerProfileName">Rohit Kumar</strong>
                        <span id="offerProfileDesignation" style="font-size:12px;color:#666;">CND-1023 • Sales</span>
                    </div>
                </div>
                <span class="offer-status-tag" id="offerProfileStatus">⏳ Waiting for Candidate Approval</span>
            </div>

            <h3>Offer Letter Generator</h3>
           <form action="{{ route('offerLetter.store') }}" method="POST">
                @csrf 
               <div class="offer-generator-section">
                <div class="offer-generator-form">
                    <div class="offer-form-group"><label>Candidate ID</label>
                      <input type="text" name="candidate_id" id="offerCandIdInput"></div>
                    <div class="offer-form-group"><label>Candidate Name</label>
                      <input type="text" name="candidate_name" id="offerNameInput" value="Rohit Kumar"></div>
                    <div class="offer-form-group"><label>Designation</label>
                      <input type="text" name="designation" id="offerDesignationInput" value="Sales Executive"></div>
                    <div class="offer-form-group"><label>Department</label>
                      <input type="text" name="department" id="offerDeptInput" value="Sales"></div>
                    <div class="offer-form-group"><label>Joining Date</label>
                      <input type="date" name="joining_date" id="offerDateInput" value="2025-03-10"></div>
                    <div class="offer-form-group"><label>Location</label>
                      <input type="text" name="location" id="offerLocationInput" value="Mumbai"></div>
                    <div class="offer-form-group"><label>CTC</label>
                      <input type="text" name="ctc" id="offerCtcInput" value="INR 8,00,000"></div>
                    <button type="button" class="offer-btn-primary" onclick="offerShowPreview()">Generate Offer Letter</button>
                </div>
                <div class="offer-preview-box" id="offerPreviewBox"></div>
              </div>
            </form>

            <div class="offer-preview-actions" id="offerPreviewActions">
                <button class="offer-btn-download">📥 Download</button>
                <button class="offer-btn-print" onclick="window.print()">🖨️ Print</button>
                {{-- <button type="button" class="offer-btn-email" onclick="sendOfferEmail()">✉️ Send via Email</button> --}}
                <form id="offerEmailForm" action="{{ route('offer.sendEmail', $candidate->id ?? 1) }}" method="POST">
                 @csrf
                  <input type="hidden" id="offerCandidateNumericId" value="6">
    <!-- all input fields here -->
<button type="button" class="offer-btn-email" id="sendOfferEmailBtn">✉️ Send via Email</button>
</form>

            </div>
        </div>
    </div>


<script>
    // Sidebar menu toggles
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
        trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
        trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
        if (!isOpen) {
            container.classList.add("open");
            trigger.classList.add("active");
        }
    }

    // Show offer letter preview
    function offerShowPreview() {
        const candId = document.getElementById("offerCandIdInput").value;
        const name = document.getElementById("offerNameInput").value;
        const designation = document.getElementById("offerDesignationInput").value;
        const dept = document.getElementById("offerDeptInput").value;
        const joiningDate = document.getElementById("offerDateInput").value;
        const location = document.getElementById("offerLocationInput").value;
        const ctc = document.getElementById("offerCtcInput").value;

        const preview = `
            <strong>XYZ Corp</strong><br><br>
            Dear ${name},<br><br>
            We are pleased to offer you the position of <b>${designation}</b> 
            in the <b>${dept}</b> department at our ${location} office with CTC <b>${ctc}</b>. 
            Your joining date is <b>${new Date(joiningDate).toLocaleDateString()}</b>.<br><br>
            Regards,<br>HR Team
        `;

        const previewBox = document.getElementById("offerPreviewBox");
        previewBox.innerHTML = preview;
        previewBox.style.display = "block";
        document.getElementById("offerPreviewActions").style.display = "flex";
        document.getElementById("offerProfileName").textContent = name;
        document.getElementById("offerProfileDesignation").textContent = `${candId} • ${dept}`;
        document.getElementById("offerProfilePic").textContent = name.split(" ").map(n => n[0]).join("").toUpperCase();

        // Save offer letter after preview
        saveOfferLetter(candId, name, designation, dept, joiningDate, location, ctc);
    }

    // Save offer letter via API
    function saveOfferLetter(candId, name, designation, dept, joiningDate, location, ctc) {
        const data = {
            _token: '{{ csrf_token() }}',
            candidate_id: candId,
            candidate_name: name,
            designation: designation,
            department: dept,
            joining_date: joiningDate,
            location: location,
            ctc: ctc
        };

        fetch("{{ route('offerLetter.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                console.log('✅ Offer letter saved:', response.offer);
                showToast('Offer Letter saved successfully!', 'success');
            } else {
                showToast('Failed to save Offer Letter', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error saving Offer Letter!', 'error');
        });
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.position = 'fixed';
        toast.style.bottom = '30px';
        toast.style.right = '30px';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '8px';
        toast.style.color = 'white';
        toast.style.fontWeight = 'bold';
        toast.style.zIndex = '9999';
        toast.style.backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
        toast.style.boxShadow = '0 4px 10px rgba(0,0,0,0.3)';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Send offer email
  
    document.getElementById('sendOfferEmailBtn').addEventListener('click', function(e) {
    e.preventDefault();

    const candidateId = document.getElementById('offerCandidateNumericId').value;
    if (!candidateId) {
        alert('Candidate ID missing!');
        return;
    }

    fetch("{{ url('hrms/offer/send-email') }}/" + candidateId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    })
    .catch(err => {
        console.error(err);
        alert('Error sending email!');
    });
});


</script>


</body>

</html>
