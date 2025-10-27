<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Pre-Joining Process</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display:flex; min-height:100vh; background:#fff; color:black; }

/* Sidebar */
.sidebar {
  width: 280px;
  background: linear-gradient(to right,#90caf9,#047edf 99%);
  color: #fff;
  padding: 25px 15px;
  border-top-right-radius: 25px;
  border-bottom-right-radius: 25px;
  box-shadow: 8px 0 25px rgba(0,0,0,0.3);
  overflow-y:auto;
  position:fixed;
  top:0; left:0; bottom:0; z-index:10;
}
.sidebar h2 { text-align:center; font-size:24px; margin-bottom:20px; font-weight:700; color:#fff; text-shadow:0 2px 4px rgba(0,0,0,0.4); }
.menu-section { margin-bottom:22px; }
.menu-section h3, .submenu .dropdown-btn {
  font-size:16px; cursor:pointer; padding:12px 15px 12px 45px;
  background: rgba(255,255,255,0.08); border-radius:10px;
  transition: all 0.3s ease; display:flex; align-items:center; font-weight:500; color:#fff; position:relative;
}
.menu-section h3:hover, .submenu .dropdown-btn:hover { background: rgba(255,255,255,0.12); transform:translateX(5px); }
.submenu { list-style:none; display:none; padding-left:15px; margin-top:8px; }
.submenu.open { display:block; }
.submenu li { margin-bottom:5px; }
.submenu a, .submenu .dropdown-btn { display:flex; align-items:center; padding:10px 15px; border-radius:8px; font-size:14px; color:#fff; text-decoration:none; gap:10px; transition:0.3s; }
.submenu a:hover, .submenu .dropdown-btn:hover { background: rgba(255,255,255,0.1); transform:translateX(5px); }
.arrow { margin-left:auto; font-size:12px; opacity:0.7; transition:transform .3s; }
.active .arrow { transform:rotate(90deg); }
.dropdown-container { list-style:none; display:none; padding-left:30px; margin-top:5px; }
.dropdown-container.open { display:block; }
.dropdown-container a { display:flex; align-items:center; padding:8px 12px; border-radius:6px; font-size:13px; color:#fff; text-decoration:none; gap:10px; transition:0.3s; }
.dropdown-container a:hover { background: rgba(255,255,255,0.15); transform:translateX(5px); }

/* Main content */
.main-content { margin-left:280px; flex:1; padding:20px; display:flex; flex-direction:column; }

/* Top bar */
.top-bar { display:flex; justify-content:space-between; align-items:center; background:linear-gradient(to right,#90caf9,#047edf 99%); padding:12px 20px; border-radius:10px; font-size:18px; margin-bottom:30px; color:#fff; font-weight:bold; }
.logout-btn { background:#f43f5e; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-weight:bold; color:#fff; }
.logout-btn:hover { background:#e11d48; }

/* Pre-Joining option card */
.option-card {
  background: linear-gradient(-45deg, #e3f2fd, #bbdefb, #90caf9, #64b5f6);
  background-size: 400% 400%;
  animation: gradientBG 12s ease infinite;
  padding: 30px; border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
  max-width: 600px; width:100%; text-align:center; margin:40px auto; color:#03396c;
}
@keyframes gradientBG { 0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;} }
.option-card h1{ font-size:24px; margin-bottom:8px; }
.option-card p{ font-size:15px; margin-bottom:25px; }
.option { display:flex; align-items:flex-start; border:1px solid rgba(3,57,108,0.3); border-radius:10px; padding:15px; text-align:left; margin-bottom:15px; cursor:pointer; transition:all 0.2s; gap:10px; background:rgba(255,255,255,0.7); color:#03396c; }
.option:hover { border-color:#047edf; background:rgba(255,255,255,0.9); }
.option input[type="radio"] { margin-top:4px; transform:scale(1.2); cursor:pointer; }
.option strong{ font-size:16px; margin-bottom:5px; display:block; }
.continue-btn { background:#047edf; border:none; padding:10px 22px; border-radius:6px; cursor:pointer; font-weight:bold; color:#fff; margin-top:15px; font-size:15px; transition:0.3s; }
.continue-btn:hover{ background:#0356b6; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
<h2>HRMS</h2>
 <div class="menu-section">
    <h3>
      <a href="main.html" style="color:white; text-decoration:none; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-home"></i> Dashboard
      </a>
    </h3>
  </div>
<!-- HR Management -->
<div class="menu-section">
  <h3 onclick="toggleMenu(this)"><i class="fas fa-briefcase menu-icon"></i> HR Management <span class="arrow">▶</span></h3>
  <ul class="submenu">
    <li><a href="index.html"><i class="fas fa-home"></i> Dashboard</a></li>
    <li>
      <div class="dropdown-btn" onclick="toggleDropdown(this)"><i class="fas fa-user-plus"></i> Employee Management <span class="arrow">▶</span></div>
      <div class="dropdown-container">
        <a href="{{ route('recruitment.index') }}"><i class="fas fa-pen"></i> Candidate Registration</a>
        <a href="{{ route('preJoiningProcess.index') }}"><i class="fas fa-user-check"></i> Pre-Joining Process</a>
        <a href="{{ route('dataVerification.index') }}"><i class="fas fa-id-card"></i> Data Verification</a>
      </div>
    </li>
    <li>
      <div class="dropdown-btn" onclick="toggleDropdown(this)"><i class="fas fa-handshake"></i> Onboarding & Confirmation <span class="arrow">▶</span></div>
      <div class="dropdown-container">
        <a href="{{ route('offerLetter.index') }}"><i class="fas fa-file-signature"></i> Offer Letter</a>
        <a href="{{ route('joiningLetter.index') }}"><i class="fas fa-user-tie"></i> Joining Letter</a>
      </div>
    </li>
    <li><a href="training.html"><i class="fas fa-chalkboard-teacher"></i> Training & Assessment</a></li>
    <li><a href="reports.html"><i class="fas fa-chart-bar"></i> Reports</a></li>
  </ul>
</div>
<!-- Employee, Leaves, Shifts, Payroll Sections as in your previous sidebar -->
<div class="menu-section">
  <h3 onclick="toggleMenu(this)"><i class="fas fa-user-tie menu-icon"></i> Employee <span class="arrow">▶</span></h3>
  <ul class="submenu">
    <li><a href="#"><i class="fas fa-users submenu-icon"></i> Employees</a></li>
    <li><a href="#"><i class="fas fa-building submenu-icon"></i> Department</a></li>
    <li><a href="#"><i class="fas fa-id-badge submenu-icon"></i> Designation</a></li>
    <li><a href="#"><i class="fas fa-award submenu-icon"></i> Appreciation</a></li>
  </ul>
</div>
<div class="menu-section">
  <h3 onclick="toggleMenu(this)"><i class="fas fa-calendar-alt menu-icon"></i> Leaves & Holidays <span class="arrow">▶</span></h3>
  <ul class="submenu">
    <li><a href="#"><i class="fas fa-calendar-plus submenu-icon"></i> Leave Create</a></li>
    <li><a href="#"><i class="fas fa-glass-cheers submenu-icon"></i> Holiday Create</a></li>
  </ul>
</div>
<div class="menu-section">
  <h3 onclick="toggleMenu(this)"><i class="fas fa-clock menu-icon"></i> Manage Shift <span class="arrow">▶</span></h3>
  <ul class="submenu">
    <li><a href="#"><i class="fas fa-calendar-day submenu-icon"></i> Shift Roster</a></li>
  </ul>
</div>
<div class="menu-section">
  <h3 onclick="toggleMenu(this)"><i class="fas fa-money-check menu-icon"></i> Payroll <span class="arrow">▶</span></h3>
  <ul class="submenu">
    <li><a href="bulk.html"><i class="fas fa-clipboard-list submenu-icon"></i> Bulk Attendance</a></li>
    <li><a href="monthly.html"><i class="fas fa-calendar-check submenu-icon"></i> Monthly Payroll</a></li>
    <li><a href="hourly.html"><i class="fas fa-clock submenu-icon"></i> Hourly Payroll</a></li>
    <li><a href="payroll_final.html"><i class="fas fa-file-invoice-dollar submenu-icon"></i> Finalized Payroll</a></li>
  </ul>
</div>
</div>

<!-- Main content -->
<div class="main-content">
<div class="top-bar">
  <div>Pre-Joining Process</div>
  <div>Admin <button class="logout-btn">Logout</button></div>
</div>

{{-- <!-- success Message -->
     @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif --}}

<div class="option-card">
  <h1>Welcome to TalentTrack</h1>
  <p>Please select the option that best describes your professional experience.</p>

  <label class="option">
    <input type="radio"  name="experience_type" value="fresher">
    <div>
      <strong>I am a Fresher</strong>
      <span>I have recently completed my education and have no prior professional work experience.</span>
    </div>
  </label>

  <label class="option">
    <input type="radio" name="experience_type" value="experienced">
    <div>
      <strong>I have Work Experience</strong>
      <span>I have prior professional work experience in a relevant field.</span>
    </div>
  </label>

  <button class="continue-btn" onclick="goNext()">Continue</button>
</div>
</div>

<script>
// Sidebar toggle
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
// Navigation
function goNext(){
  const selected=document.querySelector('input[name="experience_type"]:checked');
  if(!selected){ alert("Please select an option"); return; }
  if(selected.value==="fresher"){ window.location.href="{{ route('preJoiningProcess.fresher') }}"; }
  else { window.location.href="{{ route('preJoiningProcess.experienced') }}"; }
}
</script>
</body>
</html>
