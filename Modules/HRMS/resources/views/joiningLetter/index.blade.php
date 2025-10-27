<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Joining Letter | HR Management</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
    /* 🔍 Search Section Styling */
    .search-section34 {
        background: #fff;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .search-section34 h3 {
        color: #333;
        font-size: 18px;
        font-weight: 600;
    }

    .search-bar34 {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-bar34 input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .search-bar34 input:focus {
        border-color: #007bff;
        outline: none;
    }

    .search-bar34 button {
        background: #dc3545;
        border: none;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search-bar34 button:hover {
        background: #c82333;
    }

    /* Search results below bar */
    #searchResults {
        margin-top: 10px;
        max-height: 200px;
        overflow-y: auto;
    }

    #searchResults div {
        border: 1px solid #ddd;
        padding: 8px;
        margin-bottom: 6px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s;
    }

    #searchResults div:hover {
        background: #f8f9fa;
    }

    .joining-preview-box {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fdfdfd;
    }

    .joining-preview-actions {
        display: none;
        margin-top: 10px;
        gap: 10px;
    }

    .joining-preview-actions button {
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 6px;
        border: none;
        background: #007bff;
        color: #fff;
    }

    .joining-preview-actions button:hover {
        background: #0056b3;
    }

    .signature {
        margin-top: 30px;
        font-weight: bold;
    }
    /* .joining-generator-section form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 100%;
} */
    .joining-generator-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    }

</style>
</head>
<body>

    <!-- Sidebar -->
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


    <!-- Main Content -->
    <div class="joining-main">
        <div class="joining-top-bar">
            <div>Joining Letter</div>
            <div>Admin <button class="joining-logout-btn">Logout</button></div>
        </div>

        <div class="search-bar34">
            <input type="text" id="searchInput" placeholder="Search by name or employee ID...">
            <button type="button" id="clearSearch"><i class="fas fa-times"></i></button>
        </div>
        <div id="searchResults"></div>

        <div class="joining-card">
            <div class="joining-profile" id="profileBox">
                <div class="joining-profile-left">
                    <div class="joining-profile-pic" id="profilePic">RK</div>
                    <div class="joining-profile-info">
                        <strong id="profileName">Rohit Kumar</strong>
                        <span id="profileDesignation" style="font-size:12px;color:#666;">CND-1023 • Sales</span>
                    </div>
                </div>
                <span class="joining-status-tag" id="profileStatus">✅ Offer Accepted</span>
            </div>

            <h3>Joining Letter Generator</h3>
            <div class="joining-generator-section">
    <form id="joiningLetterForm">
        <input type="hidden" id="CandidateEmail" name="candidate_email" value="">

        <div class="joining-generator-form">
            <div class="joining-form-group">
                <label>Designation</label>
                <input type="text" id="designation" name="designation" value="Sales Executive">
            </div>
            <div class="joining-form-group">
                <label>Department</label>
                <input type="text" id="department" name="department" value="Sales">
            </div>
            <div class="joining-form-group">
                <label>Joining Date</label>
                <input type="date" id="joiningDate" name="joining_date" value="2025-03-10">
            </div>
            <div class="joining-form-group">
                <label>Location</label>
                <input type="text" id="location" name="location" value="Mumbai">
            </div>
           <button type="button" class="joining-btn-primary" onclick="previewAndSaveLetter()">Preview Joining Letter</button>

        </div>
    </form>
    <div class="joining-preview-box" id="letterContent">
        Fill the details and click "Preview Joining Letter" to see the letter.
    </div>
</div>

            <div class="joining-preview-actions" id="previewActions">
                <button type="button" class="joining-btn-download" onclick="downloadPDF()">📥 Download</button>
                <button class="joining-btn-print" onclick="window.print()">🖨️ Print</button>
                <button class="joining-btn-email">✉️ Send via Email</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Sidebar toggle functions
        function toggleMenu(el) {
            $(el).next('.submenu').slideToggle();
            $(el).find('.arrow').text($(el).next('.submenu').is(':visible') ? '▼' : '▶');
        }

        function toggleDropdown(el) {
            $(el).next('.dropdown-container').slideToggle();
            $(el).find('.arrow').text($(el).next('.dropdown-container').is(':visible') ? '▼' : '▶');
        }
function previewAndSaveLetter() {
    const name = $('#profileName').text();
    const designation = $('#designation').val();
    const dept = $('#department').val();
    const date = $('#joiningDate').val();
    const location = $('#location').val();
    const email = $('#CandidateEmail').val();

    // 1️⃣ Update preview box
    const previewBox = $('#letterContent');
    previewBox.html(`
        <p>Date: ${date}</p>
        <p>To,<br><b>${name}</b><br>Department: ${dept}<br>Location: ${location}</p>
        <p>Subject: Joining Letter</p>
        <p>Dear ${name},</p>
        <p>We are pleased to confirm your appointment as <b>${designation}</b> in our ${dept} department. 
        You are requested to report at our ${location} office on <b>${date}</b>.</p>
        <p>We welcome you to our organization and look forward to your valuable contribution.</p>
        <div class="signature">Authorized Signatory<br><br>__________________</div>
    `);
    previewBox.show();
    $('#previewActions').css('display', 'flex');

    // 2️⃣ Save via AJAX
    if (!email) {
        alert("Please select a candidate first from search!");
        return;
    }

    const data = {
        candidate_email: email,
        candidate_name: name,
        designation: designation,
        department: dept,
        joining_date: date,
        location: location,
    };

    $.ajax({
        url: '/hrms/joining-letter/store',
        type: 'POST',
        data: data,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            showToast(res.message || 'Joining Letter saved successfully!', 'success');
        },
        error: function(err) {
            console.log(err.responseText); // see exact Laravel error in console
            showToast('Error saving Joining Letter. Check console.', 'error');
        }
    });
}


        // Search functionality
        $(document).ready(function () {

            $('#searchInput').on('keyup', function () {
                let query = $(this).val();
                if (query.length < 2) {
                    $('#searchResults').html('');
                    return;
                }
                $.ajax({
                    url: '/hrms/joining-letter/search',
                    type: 'GET',
                    data: { query: query },
                    success: function (data) {
                        let resultsHtml = '';
                        if (data.length > 0) {
                            data.forEach(emp => {
                                let fullName = emp.first_name && emp.last_name ? emp.first_name + ' ' + emp.last_name : emp.name;
                                let job = emp.job_profile || emp.department || 'N/A';
                                resultsHtml += `
                                    <div class="search-item"
                                        data-id="${emp.id}"
                                        data-name="${fullName}"
                                        data-job="${job}"
                                        data-type="${emp.type || 'experienced'}"
                                        data-email="${emp.email || ''}">
                                        <strong>${fullName}</strong> 
                                        <small>(${job})</small>
                                    </div>
                                `;
                            });
                        } else {
                            resultsHtml = '<div>No matching candidates found.</div>';
                        }
                        $('#searchResults').html(resultsHtml);
                    }
                });
            });

            $('#clearSearch').on('click', function () {
                $('#searchInput').val('');
                $('#searchResults').html('');
            });

            $(document).on('click', '.search-item', function () {
                let name = $(this).data('name');
                let job = $(this).data('job');
                let id = $(this).data('id');
                let email = $(this).data('email');

                $('#CandidateEmail').val(email);
                $('#profileName').text(name);
                $('#profileDesignation').text(`${id} • ${job}`);
                $('#profilePic').text(name.split(' ').map(n => n[0]).join('').toUpperCase());

                $('#searchResults').html('');
                $('#searchInput').val('');
            });
        });

          function showToast(message, type = 'success') {
    const toast = $('<div>').text(message).css({
        position: 'fixed',
        bottom: '30px',
        right: '30px',
        padding: '12px 20px',
        borderRadius: '8px',
        color: 'white',
        fontWeight: 'bold',
        zIndex: '9999',
        backgroundColor: type === 'success' ? '#28a745' : '#dc3545',
        boxShadow: '0 4px 10px rgba(0,0,0,0.3)'
    });
    $('body').append(toast);
    setTimeout(() => toast.remove(), 3000);
}
// Send via email
$(document).on('click', '.joining-btn-email', function () {
    const email = $('#CandidateEmail').val();
    if (!email) {
        showToast('Please select a candidate first!', 'error');
        return;
    }

    const data = {
        candidate_email: email,
        candidate_name: $('#profileName').text(),
        designation: $('#designation').val(),
        department: $('#department').val(),
        joining_date: $('#joiningDate').val(),
        location: $('#location').val(),
    };

    fetch('/hrms/joining-letter/send-email', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        showToast(res.message || 'Joining Letter sent successfully!', 'success');
    })
    .catch(() => {
        showToast('Error sending email!', 'error');
    });
});

function downloadPDF() {
    const data = {
        candidate_name: $('#profileName').text(),
        designation: $('#designation').val(),
        department: $('#department').val(),
        joining_date: $('#joiningDate').val(),
        location: $('#location').val(),
    };

    fetch('/hrms/joining-letter/download', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.blob())
    .then(blob => {
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `${data.candidate_name}_Joining_Letter.pdf`;
        link.click();
    })
    .catch(() => {
        showToast('Error generating PDF!', 'error');
    });
}

    </script>

</body>
</html>
