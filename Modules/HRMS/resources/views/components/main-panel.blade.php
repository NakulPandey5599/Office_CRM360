<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header-box">
        <h1>Recruitment Process</h1>
    </div>

    <!-- Dashboard -->
    <div class="dashboard">
        <!-- New Candidate Card -->
        <div class="card pink" onclick="window.location.href='{{ route('candidate.create') }}'">
            <h2>➕ New Candidate</h2>
            <a class="link">Add Candidate</a>
        </div>

        <!-- Interview Status Card -->
        <div class="card blue" onclick="window.location.href='{{ route('interviews.index') }}'">
            <h2>📄 Interview Status</h2>
            <a class="link">View Status</a>
        </div>


        <!-- Final Selections Card -->
        <div class="card green" onclick="window.location.href='{{ route('final-selections.index') }}'">
            <h2>✅ Final Selections</h2>
            <a class="link">View Selections</a>
        </div> 

        <div class="card green" onclick="window.location.href='{{ route('candidate.index') }}'">
            <h2>📋 All Candidates List</h2>
            <a class="link">View Candidates List</a>
        </div>


        
    </div>
</div>
