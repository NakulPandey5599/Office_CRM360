<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hourly Payroll</title>
     <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>


 @include('hrms::partials.sidebar')

<div class="main-content-uni">
  <div class="card-uni">
    <h2>Hourly Payroll</h2>

    <div class="filters-uni">
      <div class="filter-item-uni">
        <label>From</label>
        <input type="date" value="2025-08-01">
      </div>

      <div class="filter-item-uni">
        <label>To</label>
        <input type="date" value="2025-08-27">
      </div>

      <span style="align-self: flex-end; margin-bottom: 10px; padding: 0 8px; color: var(--text-primary); font-size: 14px;">27 Days</span>

      <button class="btn-primary-uni">Search</button>
      <button class="btn-outline-uni">Export CSV</button>
      <button class="btn-outline-uni">Export PDF</button>
      <button class="btn-outline-uni">Finalize Payroll</button>
    </div>
  </div>

  <div class="note-box-uni">
    <strong>Note:</strong> Payroll dates marked as frozen can't be selected or included in any date range and Changes will only be possible on unlocked data/records.
  </div>

  <div class="note-box-uni">
    <strong>Note:</strong> You can configure column settings by clicking column Title which have underline.
  </div>

  <table class="custom-table-uni">
    <thead>
      <tr style="background:#1764e8;">
        <th>Emp Id</th>
        <th>Name</th>
        <th>Department</th>
        <th>Designation</th>
        <th>Hourly Wage</th>
        <th>Standard Worked Hours</th>
        <th>Overtime Hours</th>
        <th>Total Worked Hours</th>
        <th>Gross Wages</th>
        <th>Overtime Pay</th>
        <th>Adjustment</th>
        <th>Penalties</th>
        <th>Loan Advan</th>
      </tr>
    </thead>
    <tbody id="hourlyTableBody-uni">
      <tr>
        <td>977</td>
        <td>kashi ram banzara</td>
        <td>purchase</td>
        <td>HR</td>
        <td>0.48</td>
        <td>00h 00m</td>
        <td>00h 00m</td>
        <td>00h 00m</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      </tr>
    </tbody>
  </table>

  <div class="pagination-uni" id="pagination-uni" ></div>
</div>


 <script>
function toggleMenuUni(header) {
  const submenu = header.nextElementSibling;
  const isOpen = submenu.classList.contains("open");

  document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
  document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));

  if (!isOpen) {
    submenu.classList.add("open");
    header.classList.add("active");
  }
}

function toggleDropdownUni(trigger) {
  const container = trigger.nextElementSibling;
  const isOpen = container.classList.contains("open");

  trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
  trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));

  if (!isOpen) {
    container.classList.add("open");
    trigger.classList.add("active");
  }
}

// ================= Pagination =================
function initHourlyPaginationUni() {
  const rowsPerPage = 5;
  const tbody = document.getElementById("hourlyTableBody-uni");
  if (!tbody) return;
  
  const rows = tbody.querySelectorAll("tr");
  const totalPages = Math.ceil(rows.length / rowsPerPage);
  const pagination = document.getElementById("pagination-uni");
  pagination.innerHTML = '';

  function showPage(page) {
    rows.forEach((row, index) => {
      row.style.display = (index >= (page-1)*rowsPerPage && index<page*rowsPerPage) ? "" : "none";
    });
    pagination.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
    const activeBtn = pagination.querySelector(`button[data-page="${page}"]`);
    if(activeBtn) activeBtn.classList.add('active');
  }

  for(let i=1;i<=totalPages;i++){
    const btn = document.createElement("button");
    btn.textContent = i;
    btn.setAttribute("data-page",i);
    if(i===1) btn.classList.add("active");
    btn.addEventListener("click",()=>showPage(i));
    pagination.appendChild(btn);
  }

  showPage(1);
}

document.addEventListener('DOMContentLoaded', initHourlyPaginationUni);
</script>

</body>
</html>
