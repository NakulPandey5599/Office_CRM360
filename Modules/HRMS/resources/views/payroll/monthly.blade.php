<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Payroll</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="monthly-page">
    <div class="payroll-main-content">
        <div class="payroll-card">
            <h2 class="payroll-title">Monthly Payroll</h2>

            <!-- Filters -->
            <div class="payroll-filters">
                <div class="payroll-filter-item">
                    <label>From</label>
                    <input type="date" id="from_date">
                </div>

                <div class="payroll-filter-item">
                    <label>To</label>
                    <input type="date" id="to_date">
                </div>

                <div class="payroll-filter-item">
                    <label>Days</label>
                    <div class="payroll-input-icon">
                        <input type="text" id="days_count" value="0" readonly>
                    </div>
                </div>

                <button class="payroll-btn payroll-btn-primary" id="searchBtn">Search</button>

                <div class="payroll-filters-right">
                    <button class="payroll-btn payroll-btn-outline">Switch To Old</button>
                    <div class="payroll-dropdown">
                        <button class="payroll-btn payroll-btn-outline payroll-dropdown-btn">
                            Actions <i class="fas fa-caret-down" style="margin-left:6px;"></i>
                        </button>
                        <div class="payroll-dropdown-content">
                            <a href="#">Export CSV</a>
                            <a href="#">Export PDF</a>
                            <a href="#">Old Payroll</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="payroll-note-box"><strong>Note:</strong> Payroll dates marked as finalized can't be selected...
        </div>

        <!-- Table -->
<table class="payroll-table">
  <thead>
    <tr>
      <th>Emp Id</th>
      <th>Name</th>
      <th>Department</th>
      <th>Designation</th>
      <th>Full Day</th>
      <th>Half Day</th>
      <th>Off Days</th>
      <th>Paid Leaves</th>
      <th>Paid Days</th>
      <th>Unpaid Days</th>
      <th>Daily Wage</th>
      <th>Gross Wages</th>
      <th>Earned Wages</th>
      <th>Other Earnings</th>
      
    </tr>
  </thead>
  <tbody id="payrollTableBody">
    <tr>
      <td colspan="15" style="text-align:center;">No data yet</td>
    </tr>
  </tbody>
</table>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fromDate = document.getElementById("from_date");
            const toDate = document.getElementById("to_date");
            const daysCount = document.getElementById("days_count");
            const tableBody = document.getElementById("payrollTableBody");
            const searchBtn = document.getElementById("searchBtn");

            const today = new Date().toISOString().split("T")[0];
            fromDate.max = today;
            toDate.max = today;

            // Default range (current month)
            const firstDay = new Date();
            firstDay.setDate(1);
            fromDate.value = firstDay.toISOString().split("T")[0];
            toDate.value = today;

            function updateDays() {
                if (fromDate.value && toDate.value) {
                    const start = new Date(fromDate.value);
                    const end = new Date(toDate.value);
                    if (end < start) {
                        alert("To Date cannot be earlier than From Date!");
                        toDate.value = "";
                        daysCount.value = 0;
                        return;
                    }
                    const diffTime = end - start;
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    daysCount.value = diffDays;
                }
            }

            fromDate.addEventListener("change", updateDays);
            toDate.addEventListener("change", updateDays);
            updateDays();

            // 🔹 Fetch payroll data dynamically
            searchBtn.addEventListener("click", function() {
                const from = fromDate.value;
                const to = toDate.value;

                if (!from || !to) {
                    alert("Please select both dates.");
                    return;
                }

                tableBody.innerHTML =
                `<tr><td colspan="14" style="text-align:center;">Loading...</td></tr>`;

                fetch("{{ route('payroll.fetch') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            from_date: from,
                            to_date: to
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            tableBody.innerHTML =
                                `<tr><td colspan="14" style="text-align:center;">No records found</td></tr>`;
                            return;
                        }

                        tableBody.innerHTML = "";
                        data.forEach(emp => {
                            tableBody.innerHTML += `
          <tr>
            <td>${emp.emp_id}</td>
            <td>${emp.name}</td>
            <td>${emp.department}</td>
            <td>${emp.designation.replace(/[\[\]"]/g, '')}</td>
            <td>${emp.full_day}</td>
            <td>${emp.half_day}</td>
            <td>${emp.off_days}</td>
            <td>${emp.paid_leaves}</td>
            <td>${emp.paid_days}</td>
            <td>${emp.unpaid_days}</td>
            <td>${emp.daily_wage}</td>
            <td>${emp.gross_wages}</td>
            <td>${emp.earned_wages}</td>
            <td>${emp.other_earnings}</td>
          </tr>`;
                        });
                    })
                    .catch(() => {
                        tableBody.innerHTML =
                            `<tr><td colspan="14" style="text-align:center;color:red;">Error fetching data.</td></tr>`;
                    });
            });
        });
    </script>

</body>

</html>
