<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monthly Payroll</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet"  href="{{ asset('css/app.css') }}">
</head>
@include('hrms::partials.sidebar')

<body class="monthly-page">
  <!-- Sidebar -->

 <!-- Main Content -->
<div class="payroll-main-content">
  <div class="payroll-card">
    <h2 class="payroll-title">Monthly Payroll</h2>
    <div class="payroll-filters">
      <div class="payroll-filter-item"><label>From</label><input type="date" value="2025-08-01"></div>
      <div class="payroll-filter-item"><label>To</label><input type="date" value="2025-08-27"></div>
      <div class="payroll-filter-item"><label>Days</label><div class="payroll-input-icon"><input type="text" value="27" readonly></div></div>
      <button class="payroll-btn payroll-btn-primary">Search</button>

      <!-- Filters Right -->
      <div class="payroll-filters-right">
        <button class="payroll-btn payroll-btn-outline">Switch To Old</button>
        <div class="payroll-dropdown">
          <button class="payroll-btn payroll-btn-outline payroll-dropdown-btn">Actions <i class="fas fa-caret-down" style="margin-left:6px;"></i></button>
          <div class="payroll-dropdown-content">
            <a href="#">Export CSV</a>
            <a href="#">Export PDF</a>
            <a href="#">Old payroll</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="payroll-note-box"><strong>Note:</strong> Payroll dates marked as finalized can't be selected...</div>

  <table class="payroll-table">
    <thead>
      <tr>
        <th>Emp Id</th><th>Name</th><th>Department</th><th>Designation</th>
        <th>Full Day</th><th>Half Day</th><th>Off Days</th><th>Paid Leaves</th>
        <th>Paid Days</th><th>Unpaid Days</th><th>Daily Wage</th><th>Gross Wages</th>
        <th>Earned Wages</th><th>Other Earnings</th><th>Quest</th>
      </tr>
    </thead>
    <tbody id="payrollTableBody">
      <tr><td>998</td><td>Mayuri Sonsale</td><td>Manager head</td><td>Manager</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>1</td><td>749.23</td><td>20000</td><td>0</td><td>2000.00</td><td>0.00</td></tr>
      <tr><td>9988</td><td>997 demo</td><td>owner</td><td>Owner</td><td>1</td><td>0</td><td>0</td><td>0</td><td>1</td><td>2</td><td>800.00</td><td>20800</td><td>600</td><td>2230.22</td><td>300.00</td></tr>
    </tbody>
  </table>
</div>

  <script>
    function toggleMenu(header){
      const submenu = header.nextElementSibling;
      const isOpen = submenu.classList.contains("open");
      document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
      document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
      if(!isOpen){ submenu.classList.add("open"); header.classList.add("active"); }
    }

    function toggleDropdown(trigger){
      const container = trigger.nextElementSibling;
      const isOpen = container.classList.contains("open");
      trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
      trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
      if(!isOpen){ container.classList.add("open"); trigger.classList.add("active"); }
    }
  </script>

</body>
</html>
