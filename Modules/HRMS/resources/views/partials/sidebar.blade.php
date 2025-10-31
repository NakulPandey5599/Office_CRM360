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
    <li><a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i> Dashboard</a></li>
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
    <li><a href="{{ route('trainingAssessment.index') }}"><i class="fas fa-chalkboard-teacher"></i> Training & Assessment</a></li>
    <li><a href="{{ route('report.index') }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
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
    <li><a href="{{ route('bulkAttendence.index') }}"><i class="fas fa-clipboard-list submenu-icon"></i> Bulk Attendance</a></li>
    <li><a href="{{ route('monthlyPayroll.index') }}"><i class="fas fa-calendar-check submenu-icon"></i> Monthly Payroll</a></li>
    <li><a href="{{ route('hourlyPayroll.index') }}"><i class="fas fa-clock submenu-icon"></i> Hourly Payroll</a></li>
    <li><a href="{{ route('finalizedPayroll.index') }}"><i class="fas fa-file-invoice-dollar submenu-icon"></i> Finalized Payroll</a></li>
  </ul>
</div>
</div>
