<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #111827;
        }

        /* --- Header --- */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(to right, #bbf7d0, #86efac);
            padding: 15px 25px;
            font-size: 22px;
            font-weight: bold;
            color: #065f46;
            border-radius: 10px 10px 0 0;
            margin-bottom: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header .back {
            margin-right: 12px;
            font-size: 26px;
            cursor: pointer;
            color: #059669;
            transition: transform 0.2s;
        }

        .header .back:hover {
            transform: scale(1.2);
        }

        /* Add Candidate Button in Header */
        .add-btn-header {
            background: #7e22ce;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .add-btn-header:hover {
            background: #9333ea;
            transform: scale(1.05);
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: linear-gradient(to right, #90caf9, #047edf 99%) !important;
            color: #fff;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin: 0 0 20px;
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
        }

        .sidebar a {
            display: block;
            padding: 14px 20px;
            color: #ffffff;
            text-decoration: none;
            transition: 0.3s;
            font-size: 15px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .sidebar .active {
            background: #ffffff !important;
            font-weight: bold;
            color: #047edf !important;
        }

        /* Main content wrapper */
        .main-content {
            margin-left: 240px;
            display: flex;
            justify-content: center;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            padding: 20px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        h4 {
            margin-bottom: 10px;
            color: #7e22ce;
            font-weight: bold;
        }

        .form-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            outline: none;
        }

        /* --- Input Coloring (only inside, not row bg) --- */
        .row1 input,
        .row1 textarea,
        .row1 select {
            background: #fef9c3;
        }

        .row2 input,
        .row2 textarea,
        .row2 select {
            background: #e0f2fe;
        }

        .row3 input,
        .row3 textarea,
        .row3 select {
            background: #ede9fe;
        }

        .row4 input,
        .row4 textarea,
        .row4 select {
            background: #ffe4e6;
        }

        /* File Upload */
        .file-upload {
            border: 2px dashed #bbb;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin: 15px 0;
            background: #fff;
            color: #666;
        }

        .file-upload button {
            padding: 6px 14px;
            border: 1.5px solid #7e22ce;
            background: #fff;
            color: #7e22ce;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
        }

        .file-upload button:hover {
            background: #7e22ce;
            color: #fff;
        }

        .file-name {
            margin-top: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        /* Action Buttons */
        .actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .actions button {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #f43f5e;
            color: #fff;
        }

        .btn-primary:hover {
            background: #e11d48;
        }

        .btn-secondary {
            background: #fff;
            border: 1.5px solid #7e22ce;
            color: #7e22ce;
        }

        .btn-secondary:hover {
            background: #7e22ce;
            color: #fff;
        }

        /* Send Mail Button */
        .send-mail {
            padding: 10px 20px;
            border-radius: 8px;
            background: #059669;
            color: #fff;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .send-mail:hover {
            background: #047857;
        }
.popup {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    animation: slideDown 0.5s ease;
}

.popup-content {
    background: #fff;
    border-radius: 4px; /* smaller radius for rectangle */
    padding: 15px 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    font-size: 15px;
    font-weight: 500;
    display: inline-block;
    min-width: 400px; /* wider rectangle */
    text-align: center;
    opacity: 0.95;
    animation: fadeIn 0.6s ease forwards;
}

/* Success (green) and Error (red) */
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

/* Animations */
@keyframes slideDown {
    from {
        transform: translate(-50%, -30px);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}

@keyframes fadeIn {
    from { opacity: 0; } 
    to { opacity: 1; }
}

        
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Recruitment</h2>
        <a href="{{ route('recruitment.index') }}">Dashboard</a>
    </div>

    <div class="main-content">
        <div class="container">
            <!-- Header with Back Arrow + Add Candidate -->
            <div class="header">
                <div class="header-left">
                    <span class="back" onclick="goToDashboard()">&#8592;</span>
                    Candidate Details
                </div>
                {{-- <button class="add-btn-header" title="Add Candidate">➕ Add Candidate</button> --}}
            </div>
            @if (session('success') || session('error'))
                <div id="customPopup" class="popup">
                    <div class="popup-content {{ session('error') ? 'error' : 'success' }}">
                        <h2>{{ session('error') ? 'Error ' : 'Success' }}</h2>
                        <p>{{ session('error') ?? session('success') }}</p>
                        <button onclick="closePopup()">OK</button>
                    </div>
                </div>
                @endif

                <form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4>Candidate Info</h4>
                    <div class="form-group row1">
                        <input type="text" name="full_name" placeholder="Full Name">
                        <input type="email" name="email" placeholder="Email">
                    </div>

                    <div class="form-group row2">
                        <input type="text" name="phone" placeholder="Phone Number">
                        <input type="text" name="linkedin_profile" placeholder="LinkedIn Profile">
                    </div>

                    <h4>Job Info</h4>
                    <div class="form-group row3">
                        <textarea name="job_summary" placeholder="Job Summary"></textarea>
                        <select name="job_profile">
                            <option disabled selected>Select Job Profile</option>
                            <option>Developer</option>
                            <option>Designer</option>
                            <option>Manager</option>
                            <option>Tester</option>
                            <option>HR</option>
                            <option>Analyst</option>
                            <option>Intern</option>
                            <option>Support</option>
                        </select>
                    </div>

                    <h4>Interview Info</h4>
                    <div class="form-group row4">
                        <select class="interview-mode" id="interview-mode" name="interview_mode">
                            <option disabled selected>Select Interview Mode</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                        <input type="date" placeholder="Date" name="interview_date">
                        <input type="time" placeholder="Time" name="interview_time">
                    </div>

                    <div class="form-group row1">
                        <select class="status" name="status">
                            <option value="Scheduled" selected>Scheduled</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    {{-- <h4>Final Selection</h4>
                    <div class="form-group row2">
                        <select class="final-selection" name="final_selection">
                            <option disabled selected>Select Final Selection</option>
                            <option value="Selected">Selected</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Not Selected">Not Selected</option>
                        </select>
                    </div> --}}

                    <h4>Other Details</h4>
                    <div class="form-group row3">
                        <textarea name="notes" placeholder="Notes"></textarea>
                    </div>

                    <!-- File Upload -->
                    <div class="file-upload">
                        <p>📂 Drag and drop or click below to upload resume</p>
                        <input type="file" name="resume" id="resume" style="display:none;">
                        <button type="button" onclick="document.getElementById('resume').click()">Upload
                            Resume</button>
                        <div class="file-name" id="file-name">No file chosen</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="actions">
                        <button type="submit" class="btn-secondary">Save</button>
                        <button type="submit" class="btn-secondary">Save & Add More</button>
                        <button type="submit" name="send_mail" value="1" id="send-mail" class="send-mail" style="display:none;">Send Mail</button>
                    </div>
                </form>
        </div>
    </div>

    <script>
        function goToDashboard() {
            window.location.href = "reg.html"; // Replace with actual dashboard page
        }

        // Show selected file name
        document.getElementById("resume").addEventListener("change", function() {
            const fileName = this.files[0] ? this.files[0].name : "No file chosen";
            document.getElementById("file-name").textContent = fileName;
        });

        // Show Send Mail button only if Interview Mode = Online
        document.getElementById("interview-mode").addEventListener("change", function() {
            const sendMailBtn = document.getElementById("send-mail");
            if (this.value === "Online") {
                sendMailBtn.style.display = "inline-block";
            } else {
                sendMailBtn.style.display = "none";
            }
        });
        // Close popup
        function closePopup() {
            document.getElementById('customPopup').style.display = 'none';
        }

        // Optional: Auto-close popup after 3 seconds
        setTimeout(() => {
            const popup = document.getElementById('customPopup');
            if (popup) popup.style.display = 'none';
        }, 3000);
    </script>
</body>

</html>
