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
    .active-step34 .circle34 {
        background: #047edf;
        box-shadow: 0 0 8px rgba(4, 126, 223, 0.5);
        transition: background 0.3s, box-shadow 0.3s;
    }

    /* ✅ Timeline Container */
.timeline34 {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding: 0 10px;
}

/* ⚪ Gray base line */
.timeline34::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 5%;
    width: 90%;
    height: 4px;
    background: #ccc;
    z-index: 1;
    transform: translateY(-50%);
    border-radius: 4px;
}

/* 🔵 Blue progress line (dynamic fill) */
/* 🔵 Blue progress line (controlled via CSS variable) */
.timeline34::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 5%;
    height: 4px;
    background: #047edf;
    z-index: 2;
    transform: translateY(-50%);
    border-radius: 4px;
    width: var(--progress-width, 0%);
    transition: width 0.6s ease;
}


/* Each step */
.step34 {
    position: relative;
    text-align: center;
    width: 33%;
    font-size: 14px;
    color: #555;
    z-index: 3;
}

/* Circles */
.circle34 {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ccc;
    margin: 0 auto 8px;
    position: relative;
    z-index: 4;
    transition: all 0.3s ease;
}

/* Active step */
.active-step34 .circle34 {
    background: #047edf;
    box-shadow: 0 0 8px rgba(4, 126, 223, 0.6);
    border-color: #047edf;
}

.active-step34 {
    color: #047edf;
}

    </style>

    <body class="data">

        <!-- Sidebar -->
        @include('hrms::partials.sidebar')

        <!-- Main content -->
        <div class="main-content34">
            <div id="notification"
                style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #28a745; /* green for success */
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        display: none;
        z-index: 9999;
    ">
            </div>

            <div class="top-bar34">
                <div>HR Management System</div>
                <div>Admin <button class="logout-btn34">Logout</button></div>
            </div>

            <div class="content-sections34">

                <div class="column34">

                    <!-- 🔍 Search Section (separate from Candidate Profile) -->

                    <div class="search-section34">
                        <h3 style="margin-bottom:10px;">Search Candidates</h3>
                        <div class="search-bar34">
                            <input type="text" id="searchInput" placeholder="Search by name or employee ID...">
                            <button type="button" id="clearSearch"><i class="fas fa-times"></i></button>
                        </div>
                        <div id="searchResults"></div>
                    </div>
                    <div class="card34">
                        <h3>Candidate Profile</h3>
                        <div class="profile-container34">
                            <div class="profile-photo34">M</div>
                            <div>
                                <div class="profile-info34">

                                    <p><b>Name:</b></p>
                                    <p><b>Employee ID:</b></p>
                                    <p><b>Department:</b> </p>
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
                            <input type="hidden" name="candidate_name" id="candidate_name">
                            <input type="hidden" name="candidate_department" id="candidate_department">
                            <input type="hidden" name="candidate_id" id="candidate_id">


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
                                <button type="button" id="expBtn"
                                    onclick="document.getElementById('expFile').click()">📄
                                    Experience Certificate</button>
                            </div>
                            <button type="submit" class="send-btn34" fdprocessedid="51djvk">Send Request</button>
                        </form>

    <div class="timeline34">
        <div class="step34" data-step="sent">
            <div class="circle34"></div>Request Sent
        </div>
        <div class="step34" data-step="awaiting">
            <div class="circle34"></div>Awaiting Response
        </div>
        <div class="step34" data-step="final">
            <div class="circle34"></div>Approved / Rejected
        </div>
    </div>




                    </div>
                </div>

                <div class="column34">
                    <div class="card34">
                        <h3>HR Response</h3>
                        <p><b>HR Name:</b> </p>
                        <p><b>Email:</b> </p>
                        <p><b>Verification Result:</b> <span class="pending34">Awaiting Response</span></p>
                    </div>

                    <div class="card34">
                        <h3>Verification History</h3>

                        @forelse ($dataVerification as $item)
                            @php
                                $statusClass = match ($item->status) {
                                    'verified' => 'verified34',
                                    'rejected' => 'rejected34',
                                    default => 'pending34',
                                };
                            @endphp

                            <div class="list-item34">
                                <span>{{ $item->candidate_name ?? 'N/A' }}</span>
                                <span class="{{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                            </div>
                        @empty
                            <p>No verification records yet.</p>
                        @endforelse
                    </div>

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

        function updateFileName34(input, btnId) {
            if (input.files.length > 0) {
                document.getElementById(btnId).textContent = "✅ " + input.files[0].name;
            }
        }

        // ✅ New: Timeline Dynamic Updater
        function updateTimeline34(status) {
    const timeline = document.querySelector('.timeline34');
    const steps = document.querySelectorAll('.step34');
    steps.forEach(step => step.classList.remove('active-step34'));
    document.querySelector('[data-step="final"]').querySelector('.circle34').textContent = '';

    let progress = 0;

    switch (status) {
        case 'pending':
        case 'sent':
            $('[data-step="sent"]').addClass('active-step34');
            progress = 0;
            break;

        case 'awaiting':
        case 'in-progress':
        case 'waiting':
            $('[data-step="sent"], [data-step="awaiting"]').addClass('active-step34');
            progress = 50;
            break;

        case 'verified':
            $('[data-step="sent"], [data-step="awaiting"], [data-step="final"]').addClass('active-step34');
            $('[data-step="final"]').find('span').text('Approved');
            progress = 100;
            break;

        case 'rejected':
            $('[data-step="sent"], [data-step="awaiting"], [data-step="final"]').addClass('active-step34');
            $('[data-step="final"]').find('span').text('Rejected');
            progress = 100;
            break;

        default:
            $('[data-step="sent"]').addClass('active-step34');
            progress = 0;
    }

    // 🌈 Animate line fill up to progress
    document.querySelector('.timeline34').style.setProperty('--progress', `${progress}%`);
    timeline.style.setProperty('--progress-width', `${progress}%`);
    timeline.style.setProperty('overflow', 'visible');

    // Update the ::after width manually
    timeline.style.setProperty('--progress-width', `${progress}%`);
    timeline.style.setProperty('--progress', `${progress}%`);
    timeline.style.setProperty('--progress-color', '#047edf');
    timeline.querySelector('::after'); // force reflow
    timeline.style.setProperty('--progress-width', `${progress}%`);
    timeline.style.setProperty('--progress', `${progress}%`);
    timeline.style.setProperty('transition', 'width 0.6s ease');

    // Actually apply width on ::after (via JS)
    document.styleSheets[0].addRule('.timeline34::after', `width: ${progress}%;`);
}


        $(document).ready(function () {
            // 🔍 Search as user types
            $('#searchInput').on('keyup', function () {
                let query = $(this).val();

                if (query.length < 2) {
                    $('#searchResults').html('');
                    return;
                }

                $.ajax({
                    url: '/search-experienced-employee',
                    type: 'GET',
                    data: { query: query },
                    success: function (data) {
                        let resultsHtml = '';

                        if (data.length > 0) {
                            data.forEach(candidate => {
                                resultsHtml += `
                                    <div class="search-item" 
                                        data-id="${candidate.id}" 
                                        data-name="${candidate.first_name} ${candidate.last_name}" 
                                        data-job="${candidate.job_profile}">
                                        <strong>${candidate.first_name} ${candidate.last_name}</strong> 
                                        <small>(${candidate.job_profile})</small>
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

            // 🧹 Clear search
            $('#clearSearch').on('click', function () {
                $('#searchInput').val('');
                $('#searchResults').html('');
            });

            // 👆 When a result is clicked
            $(document).on('click', '.search-item', function () {
                let name = $(this).data('name');
                let dept = $(this).data('job');
                let id = $(this).data('id');

                // ✅ Fill hidden fields for form submission
                $('#candidate_name').val(name);
                $('#candidate_department').val(dept);
                $('#candidate_id').val(id);

                // Update candidate profile section dynamically
                $('.profile-info34').html(`
                    <p><b>Name:</b> ${name}</p>
                    <p><b>Employee ID:</b> ${id}</p>
                    <p><b>Department:</b> ${dept}</p>
                    <p><b>Joining Date:</b> N/A</p>
                `);
                $('.profile-status34').text('Loading...');

                // Fetch verification info for selected candidate
                $.ajax({
                    url: `/get-candidate-verification/${id}`,
                    type: 'GET',
                    success: function (data) {
                        $('.profile-status34').text(data.status);

                        // Fill HR response section
                        $('.card34:contains("HR Response")').html(`
                            <h3>HR Response</h3>
                            <p><b>HR Name:</b> ${data.hr_contact_name ?? 'N/A'}</p>
                            <p><b>Email:</b> ${data.hr_contact_email ?? 'N/A'}</p>
                            <p><b>Verification Result:</b> 
                                <span class="${
                                    data.status === 'verified'
                                        ? 'verified34'
                                        : data.status === 'rejected'
                                        ? 'rejected34'
                                        : 'pending34'
                                }">${data.status}</span>
                            </p>
                        `);

                        // ✅ Dynamic Timeline Update
                        updateTimeline34(data.status);
                    },
                    error: function () {
                        $('.profile-status34').text('Pending');
                        $('.card34:contains("HR Response")').html(`
                            <h3>HR Response</h3>
                            <p><b>HR Name:</b> N/A</p>
                            <p><b>Email:</b> N/A</p>
                            <p><b>Verification Result:</b> <span class="pending34">Awaiting Response</span></p>
                        `);
                        // Default timeline to pending
                        updateTimeline34('pending');
                    }
                });

                // Clear search results
                $('#searchResults').html('');
            });
        });

        // ✅ Notification Logic
        const notification = document.getElementById('notification');

        @if (session('success'))
            notification.textContent = '{{ session('success') }}';
            notification.style.backgroundColor = '#28a745'; // green
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        @endif

        @if (session('error'))
            notification.textContent = '{{ session('error') }}';
            notification.style.backgroundColor = '#dc3545'; // red
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 4000);
        @endif
    </script>



    </body>

    </html>
