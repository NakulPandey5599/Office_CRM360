<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hourly Payroll</title>

  <!-- REQUIRED FOR AJAX TO WORK -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
      /* your exact UI kept same */
      .custom-table-uni input[type="number"] {
        width: 100%;
        height: 34px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 4px 6px;
        text-align: right;
        font-size: 14px;
        color: #111827;
        background-color: #fff;
        font-family: "Poppins", sans-serif;
      }
      .custom-table-uni .saveRowBtn {
        background-color: #2563eb;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
      }
  </style>
</head>


<body>
<div class="main-content-uni">
  <div class="card-uni">
    <h2>Hourly Payroll</h2>

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
      <tr style="background:#1764e8; color:#fff;">
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
        <th>Loan Adv.</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="hourlyTableBody-uni">
      <tr><td colspan="14" style="text-align:center;">No data yet</td></tr>
    </tbody>
  </table>

  <div id="pagination-uni"></div>
</div>

<script>

// ---------------- SAFE CSRF TOKEN ----------------
function getCSRF() {
    const t = document.querySelector('meta[name="csrf-token"]');
    return t ? t.content : "";
}

document.addEventListener("DOMContentLoaded", function () {

    const fromDate = document.getElementById("from_date");
    const toDate = document.getElementById("to_date");
    const daysCount = document.getElementById("days_count");
    const tableBody = document.getElementById("hourlyTableBody-uni");
    const searchBtn = document.getElementById("searchBtn");

    // ----------- DATE HANDLING -------------
    const today = new Date().toISOString().split("T")[0];
    fromDate.max = today;
    toDate.max = today;

    const firstDay = new Date();
    firstDay.setDate(1);
    fromDate.value = firstDay.toISOString().split("T")[0];
    toDate.value = today;

    function updateDays() {
        if (!fromDate.value || !toDate.value) return;
        const start = new Date(fromDate.value);
        const end = new Date(toDate.value);

        if (end < start) {
            toDate.value = fromDate.value;
            daysCount.value = 1;
            return;
        }

        const diff = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
        daysCount.value = diff;
    }

    fromDate.addEventListener("change", updateDays);
    toDate.addEventListener("change", updateDays);
    updateDays();

    // ========== FETCH HOURLY PAYROLL ==========
    searchBtn.addEventListener("click", function () {

        const from = fromDate.value;
        const to = toDate.value;

        if (!from || !to) {
            alert("Select both dates");
            return;
        }

        tableBody.innerHTML = `<tr><td colspan="14" style="text-align:center;">Loading...</td></tr>`;

        fetch("{{ route('hourly.fetch') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCSRF()
            },
            body: JSON.stringify({ from_date: from, to_date: to })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.length) {
                tableBody.innerHTML = `<tr><td colspan="14" style="text-align:center;">No Data Found</td></tr>`;
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

    <td>${emp.hourly_wage} ₹</td>

    <td>${emp.standard_hours} </td>
    <td>${emp.overtime_hours} </td>
    <td>${emp.total_hours} </td>

    <td>${emp.gross_wages} ₹</td>
    <td>${emp.overtime_pay} ₹</td>

    <td>${emp.adjustment} ₹</td>
    <td>${emp.penalties} ₹</td>
    <td>${emp.loan_adv} ₹</td>

    <td><button class="saveRowBtn" data-id="${emp.emp_id}">💾 Save</button></td>
</tr>`;

            });

            document.querySelectorAll(".saveRowBtn").forEach(btn => {
                btn.addEventListener("click", function() {
                    saveHourlyRow(this.closest("tr"));
                });
            });

        })
        .catch(() => {
            tableBody.innerHTML = `<tr><td colspan="14" style="text-align:center;color:red;">Error fetching data</td></tr>`;
        });
    });

    // ========== SAVE HOURLY ROW ==========
    function saveHourlyRow(row) {

        const empId = row.querySelector(".saveRowBtn").dataset.id;

        const payload = {
            emp_id: empId,
            adjustment:  row.querySelector(".adjustment").value,
            penalties:   row.querySelector(".penalties").value,
            loan_adv:    row.querySelector(".loan-adv").value
        };

        fetch("{{ route('hourly.saveRow') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCSRF()
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.status === "success") {
                alert(`Saved Payroll for ${resp.employee}`);
            } else {
                alert("Save failed");
            }
        })
        .catch(() => alert("Server error while saving."));
    }

});

</script>

</body>
</html>
