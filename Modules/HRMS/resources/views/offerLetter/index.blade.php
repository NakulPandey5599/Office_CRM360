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
</style>

<body>
    <!-- Sidebar same as index.html -->
    @include('hrms::partials.sidebar')


    <!-- Main content -->
    <div class="offer-main-content">
        <div class="offer-top-bar">
            <div>Offer Letter</div>
            <div>Admin <button class="offer-logout-btn">Logout</button></div>
        </div>

        <!-- Search -->
        <div class="search-bar34">
            <input type="text" id="searchInput" placeholder="Search by name or employee ID...">
            <button type="button" id="clearSearch"><i class="fas fa-times"></i></button>
        </div>
        <div id="searchResults"></div>

        <!-- Offer Letter Section -->
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
            <form id="offerLetterForm">
                @csrf
                <!-- Hidden fields to track selected candidate -->
                <input type="hidden" id="offerCandidateId" name="candidate_id" value="{{ $candidate->id ?? '' }}">
                <input type="hidden" id="offerCandidateEmail" name="candidate_email" value="">



                <div class="offer-generator-section">
                    <div class="offer-generator-form">
                        <div class="offer-form-group"><label>Candidate ID</label>
                            <input type="text" id="offerCandIdInput" name="candidate_id">
                        </div>
                        <div class="offer-form-group"><label>Candidate Name</label>
                            <input type="text" id="offerNameInput" name="candidate_name" >
                        </div>
                        <div class="offer-form-group"><label>Designation</label>
                            <input type="text" id="offerDesignationInput" name="designation">
                        </div>
                        <div class="offer-form-group"><label>Department</label>
                            <input type="text" id="offerDeptInput" name="department">
                        </div>
                        <div class="offer-form-group"><label>Joining Date</label>
                            <input type="date" id="offerDateInput" name="joining_date">
                        </div>
                        <div class="offer-form-group"><label>Location</label>
                            <input type="text" id="offerLocationInput" name="location">
                        </div>
                        <div class="offer-form-group"><label>CTC</label>
                            <input type="text" id="offerCtcInput" name="ctc">
                        </div>
                        <button type="button" class="offer-btn-primary" onclick="offerShowPreview()">Generate Offer
                            Letter</button>
                    </div>
                    <div class="offer-preview-box" id="offerPreviewBox"></div>
                </div>
            </form>

            <div class="offer-preview-actions" id="offerPreviewActions">
                <button type="button" class="offer-btn-download" id="downloadOfferPDF">📥 Download PDF</button>
                {{-- <button class="offer-btn-print" onclick="window.print()">🖨️ Print</button> --}}
                <button type="button" class="offer-btn-email" id="sendOfferEmailBtn">✉️ Send via Email</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleMenu(header) {
  const submenu = header.nextElementSibling;
  const isOpen = submenu.classList.contains("open");
  document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
  document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
  if(!isOpen){ submenu.classList.add("open"); header.classList.add("active"); }
}
function toggleDropdown(trigger) {
  const container = trigger.nextElementSibling;
  const isOpen = container.classList.contains("open");
  trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
  trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
  if(!isOpen){ container.classList.add("open"); trigger.classList.add("active"); }
}

        $(document).ready(function() {

            // 🔍 Search candidates
            $('#searchInput').on('keyup', function() {
                let query = $(this).val();
                if (query.length < 2) {
                    $('#searchResults').html('');
                    return;
                }
                $.ajax({
                    url: '/hrms/offerletter/search',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        let resultsHtml = '';
                        if (data.length > 0) {
                            data.forEach(emp => {
                                let fullName = emp.first_name && emp.last_name ?
                                    emp.first_name + ' ' + emp.last_name :
                                    emp.name;
                                let job = emp.job_profile || emp.department || 'N/A';
                                resultsHtml += `
                                    <div class="search-item"
                                        data-id="${emp.id}"
                                        data-name="${fullName}"
                                        data-job="${job}"
                                        data-type="${emp.type || 'experienced'}"
                                        data-email="${emp.email || ''}"
                                        data-status="${emp.status}">
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

            // Clear search
            $('#clearSearch').on('click', function() {
                $('#searchInput').val('');
                $('#searchResults').html('');
            });

            // Select candidate
           // Select candidate
$(document).on('click', '.search-item', function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let job = $(this).data('job');
    let type = $(this).data('type');
    let email = $(this).data('email');
    let status = $(this).data('status'); // ✅ new line

    // Populate visible fields
    $('#offerCandIdInput').val(id);
    $('#offerNameInput').val(name);
    $('#offerDesignationInput').val(job);
    $('#offerDeptInput').val(type === 'fresher' ? 'Fresher Department' : 'Experienced Department');

    // Populate hidden email field
    $('#offerCandidateEmail').val(email);

    // Update profile box
    $('#offerProfileName').text(name);
    $('#offerProfileDesignation').text(`${id} • ${job}`);
    $('#offerProfilePic').text(name.split(' ').map(n => n[0]).join('').toUpperCase());

    // ✅ Update status dynamically
    $('#offerProfileStatus')
        .text(status)
        .css({
            color:
                status.toLowerCase().includes('approved') ? '#28a745' :
                status.toLowerCase().includes('rejected') ? '#dc3545' :
                '#ffc107' // yellow for pending
        });

    // Clear search
    $('#searchResults').html('');
    $('#searchInput').val('');
});

            // Offer preview
            window.offerShowPreview = function() {
                const candId = $('#offerCandIdInput').val();
                const name = $('#offerNameInput').val();
                const designation = $('#offerDesignationInput').val();
                const dept = $('#offerDeptInput').val();
                const joiningDate = $('#offerDateInput').val();
                const location = $('#offerLocationInput').val();
                const ctc = $('#offerCtcInput').val();

                if (!candId || !name) {
                    alert('Select a candidate first!');
                    return;
                }

                const preview = `
                    <strong>XYZ Corp</strong><br><br>
                    Dear ${name},<br><br>
                    We are pleased to offer you the position of <b>${designation}</b> 
                    in the <b>${dept}</b> department at our ${location} office with CTC <b>${ctc}</b>. 
                    Your joining date is <b>${new Date(joiningDate).toLocaleDateString()}</b>.<br><br>
                    Regards,<br>HR Team
                `;
                $('#offerPreviewBox').html(preview).show();
                $('#offerPreviewActions').css('display', 'flex');

                $('#offerProfileName').text(name);
                $('#offerProfileDesignation').text(`${candId} • ${dept}`);
                $('#offerProfilePic').text(name.split(' ').map(n => n[0]).join('').toUpperCase());

                saveOfferLetter(candId, name, designation, dept, joiningDate, location, ctc);
            }

            // Save offer letter
            function saveOfferLetter(candId, name, designation, dept, joiningDate, location, ctc) {
                const data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
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
                        if (response.success) showToast('Offer Letter saved successfully!', 'success');
                        else showToast('Failed to save Offer Letter', 'error');
                    })
                    .catch(() => showToast('Error saving Offer Letter!', 'error'));
            }

            // Toast notification
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

            // Send offer email
            $('#sendOfferEmailBtn').on('click', function() {
                const candidateEmail = $('#offerCandidateEmail').val();

                if (!candidateEmail) {
                    alert('Candidate email missing!');
                    return;
                }
                console.log("Sending email to:", candidateEmail);

                fetch("/hrms/offer/send-email", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            email: candidateEmail
                        })
                    })
                    .then(res => res.json())
                    .then(data => alert(data.message))
                    .catch(() => alert('Error sending email!'));
            });

        });
        $('.offer-btn-download').on('click', function () {
    const data = {
        candidate_name: $('#offerNameInput').val(),
        designation: $('#offerDesignationInput').val(),
        department: $('#offerDeptInput').val(),
        joining_date: $('#offerDateInput').val(),
        location: $('#offerLocationInput').val(),
        ctc: $('#offerCtcInput').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    fetch("{{ route('hrms.offer.download') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': data._token
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to generate PDF');
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${data.candidate_name}_Offer_Letter.pdf`;
        document.body.appendChild(a);
        a.click();
        a.remove();
    })
    .catch(() => alert('Error downloading PDF!'));
});

    </script>
</body>

</html>
