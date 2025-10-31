<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finalized Payroll Details</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <!-- ================= Sidebar ================= -->
  @include('hrms::partials.sidebar')

    
  <!-- ================= Dashboard Main Content ================= -->
<div class="dashboard-main-content">
  <div class="dashboard-card">
    <h2>Finalized Payroll Details</h2>
  </div>

  <table class="dashboard-table">
    <thead>
      <tr style="background:#1764e8;">
        <th>From</th>
        <th>To</th>
        <th>Paid Amount</th>
        <th>Finalized On</th>
        <th>Payroll Module</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="dashboardFinalizedTableBody">
      <tr>
        <td>23 Feb 2025</td>
        <td>25 Mar 2025</td>
        <td>₹ 6,750.10</td>
        <td>22 Aug 2025, 02:52 PM</td>
        <td>Standard Monthly Payroll</td>
        <td><button class="dashboard-btn dashboard-btn-outline">👁 View Payroll</button></td>
      </tr>
      <tr>
        <td>23 Jan 2025</td>
        <td>22 Feb 2025</td>
        <td>₹ 8,476.731</td>
        <td>22 Aug 2025, 01:32 PM</td>
        <td>Standard Monthly Payroll</td>
        <td><button class="dashboard-btn dashboard-btn-outline">👁 View Payroll</button></td>
      </tr>
      <tr>
        <td>22 Jan 2025</td>
        <td>22 Jan 2025</td>
        <td>₹ 1,516.73</td>
        <td>23 Jan 2025, 02:44 PM</td>
        <td>Standard Monthly Payroll</td>
        <td><button class="dashboard-btn dashboard-btn-outline">👁 View Payroll</button></td>
      </tr>
      <tr>
        <td>01 Jan 2025</td>
        <td>19 Jan 2025</td>
        <td>₹ 25,509.461</td>
        <td>20 Jan 2025, 04:57 PM</td>
        <td>Standard Monthly Payroll</td>
        <td><button class="dashboard-btn dashboard-btn-outline">👁 View Payroll</button></td>
      </tr>
      <tr>
        <td>01 Dec 2024</td>
        <td>03 Dec 2024</td>
        <td>₹ 4,541.502</td>
        <td>14 Dec 2024, 11:46 AM</td>
        <td>Standard Monthly Payroll</td>
        <td><button class="dashboard-btn dashboard-btn-outline">👁 View Payroll</button></td>
      </tr>
    </tbody>
  </table>

  <div class="dashboard-pagination" id="dashboardPagination"></div>
</div>

<script>
  // Sidebar toggle scripts
  function dashboardToggleMenu(header){
    const submenu = header.nextElementSibling;
    const isOpen = submenu.classList.contains("open");
    document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
    document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
    if(!isOpen){ submenu.classList.add("open"); header.classList.add("active"); }
  }

  function dashboardToggleDropdown(trigger){
    const container = trigger.nextElementSibling;
    const isOpen = container.classList.contains("open");
    trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
    trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
    if(!isOpen){ container.classList.add("open"); trigger.classList.add("active"); }
  }

  // Pagination script
  function dashboardInitPagination() {
    const rowsPerPage = 5;
    const tbody = document.getElementById("dashboardFinalizedTableBody");
    if (!tbody) return;

    const rows = tbody.querySelectorAll("tr");
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    const pagination = document.getElementById("dashboardPagination");
    pagination.innerHTML = '';

    function showPage(page) {
      rows.forEach((row, index) => {
        row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? "" : "none";
      });
      document.querySelectorAll('#dashboardPagination button').forEach(btn => btn.classList.remove('active'));
      const activeBtn = document.querySelector(`#dashboardPagination button[data-page="${page}"]`);
      if (activeBtn) activeBtn.classList.add('active');
    }

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.setAttribute("data-page", i);
      if (i === 1) btn.classList.add("active");
      btn.addEventListener("click", () => showPage(i));
      pagination.appendChild(btn);
    }

    showPage(1);
  }

  document.addEventListener('DOMContentLoaded', dashboardInitPagination);
</script>
</body>
</html>

