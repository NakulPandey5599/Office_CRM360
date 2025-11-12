<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Salary Slip</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-bar input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .search-button {
            background-color: #2b6cb0;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-button:hover {
            background-color: #1a4f8a;
        }

        .suggestions-list {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            list-style: none;
            margin: 4px 0 0;
            padding: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 99999;
            /* highest priority */
        }

        .suggestions-list li {
            padding: 8px 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .suggestions-list li:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body>

    <div class="main-container" role="region" aria-label="Salary slip">
        <div class="top-header">
            <div class="brand-section">
                <div class="company-logo">
                    WM
                </div>
                <div class="company-info">
                    <h2>Web Digital Mantra IT Services Pvt. Ltd</h2>
                    <p>A Complete Digital Marketing Solution</p>
                </div>
            </div>

            <div class="action-buttons">
                <button class="save-button" onclick="saveFormData()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                    </svg>
                    Save Data
                </button>
                <button class="print-button" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                        <path
                            d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                    </svg>
                    Print / Save PDF
                </button>
            </div>
        </div>

        <div class="document-title">
            <h1>SALARY SLIP</h1>
            <div class="employee-info">
                <label for="employeeSearch" class="data-label">Search Employee:</label>
                <div class="search-bar">
                    <input type="text" id="employeeSearch" class="employee-name-input"
                        placeholder="Type employee name or ID..." onkeyup="searchEmployee(this.value)"
                        autocomplete="off">
                    <button type="button" class="search-button" onclick="performSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                    <ul id="employeeSuggestions" class="suggestions-list"></ul>
                </div>
            </div>

        </div>

        <div class="info-grid">
            <div class="info-panel">
                <h3>Employee Information</h3>
                <div class="data-row">
                    <span class="data-label">Employee Name</span>
                    <input type="text" name="employee_name" class="data-value highlight-text" data-field="name">
                </div>
                <div class="data-row">
                    <span class="data-label">Designation</span>
                    <input type="text" name="designation" class="data-value" data-field="designation">
                </div>
                <div class="data-row">
                    <span class="data-label">Date of Joining</span>
                    <input type="text" name="joining_date" class="data-value" data-field="joining_date">
                </div>
                <div class="data-row">
                    <span class="data-label">Employee ID</span>
                    <input type="text" name="employee_id" class="data-value" data-field="employee_id">
                </div>
                <div class="data-row">
                    <span class="data-label">CTC</span>
                    <input type="text" name="ctc" class="data-value" data-field="ctc">
                </div>


            </div>

            <div class="info-panel">
                <h3>Payroll Details</h3>
               <div class="data-row">
          <span class="data-label">Payment Month</span>
          <input type="text" class="data-value" >
        </div>
        <div class="data-row">
          <span class="data-label">Payment Date</span>
          <input type="text" class="data-value">
        </div>

                <div class="data-row">
                    <span class="data-label">Days Present</span>
                    <input type="text" name="days_present" class="data-value" value="31">
                </div>
                <div class="data-row">
                    <span class="data-label">Days Paid</span>
                    <input type="text" name="days_paid" class="data-value" value="31">
                </div>
                <div class="data-row">
                    <span class="data-label">LOP</span>
                    <input type="text" name="lop" class="data-value" value="0">
                </div>
            </div>
        </div>

        <div class="details-section">
            <table class="data-table" aria-describedby="earnings-deductions">
                <thead>
                    <tr>
                        <th>Earnings</th>
                        <th>Amount (₹)</th>
                        <th>Deductions</th>
                        <th>Amount (₹)</th>
                    </tr>
                </thead>
                <tbody id="earnings-deductions">
                    <tr>
                        <td>Basic Salary</td>
                        <td><input type="text" name="basic_salary" class="numeric-cell"></td>
                        <td>Provident Fund (PF)</td>
                        <td><input type="text" name="pf" class="numeric-cell"></td>
                    </tr>

                    <tr>
                        <td>House Rent Allowance (HRA)</td>
                        <td><input type="text" name="hra" class="numeric-cell"></td>
                        <td>Gratuity</td>
                        <td><input type="text" name="gratuity" class="numeric-cell"></td>
                    </tr>

                    <tr>
                        <td>Travel Allowance</td>
                        <td><input type="text" name="travel_allowance" class="numeric-cell"></td>
                        <td>EPF @12.00%</td>
                        <td><input type="text" name="epf" class="numeric-cell"></td>
                    </tr>

                    <tr>
                        <td>Special Allowance</td>
                        <td><input type="text" name="special_allowance" class="numeric-cell"></td>
                        <td>TDS / Income Tax</td>
                        <td><input type="text" name="tds" class="numeric-cell"></td>
                    </tr>

                    <tr>
                        <td>Performance Bonus</td>
                        <td><input type="text" name="performance_bonus" class="numeric-cell"></td>
                        <td>Professional Tax</td>
                        <td><input type="text" name="professional_tax" class="numeric-cell"></td>
                    </tr>

                    <tr class="summary-row">
                        <td>Total Earnings</td>
                        <td><input type="text" name="total_earnings" class="numeric-cell"></td>
                        <td>Total Deductions</td>
                        <td><input type="text" name="total_deductions" class="numeric-cell"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total-container">
            <div class="total-card">
                <div class="total-label">Net Salary Payable</div>
                <input type="text" name="net_salary" class="total-value">
            </div>
        </div>

        <div class="payment-section">
            <h4><i class="fas fa-university"></i> Bank Details</h4>
            <div class="payment-info-grid">
                <div class="payment-detail">
                    <p><i class="fas fa-building-columns"></i> <strong>Bank Name:</strong> State Bank of India</p>
                    <p><i class="fas fa-credit-card"></i> <strong>Account No:</strong> XXXX-XXXX-1234</p>
                    <p><i class="fas fa-code"></i> <strong>IFSC Code:</strong> SBIN0000123</p>
                </div>
            </div>
        </div>



        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-text">Employee Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-text">Authorized Signatory</div>
            </div>
        </div>

        <div class="bottom-footer">
            <div class="footer-part">
                <div class="footer-heading">Company Address</div>
                <div class="footer-text">
                    #23, 3rd Floor, Nanditha Mansion<br>
                    1st Cross, 1st Stage, Kumaraswamy Layout<br>
                    Bangalore - 560078, Karnataka, India
                </div>
            </div>

            <div class="footer-part">
                <div class="footer-heading">Contact Information</div>
                <div class="footer-text">
                    <strong>E-mail:</strong> info@webdigitalmantra.in<br>
                    <strong>Phone:</strong> +91 98765 43210<br>
                    <strong>Website:</strong> www.webdigitalmantra.in
                </div>
            </div>

            <div class="footer-part">
                <div class="footer-heading">Important Notes</div>
                <div class="footer-text">
                    This is a system generated document and does not require a physical signature.<br>
                    Please report any discrepancies within 7 days of receipt.
                </div>
            </div>
        </div>
    </div>

    <!-- External JavaScript -->
    <script src="script.js"></script>


    <script>
        // Function to save form data to localStorage
        function saveFormData() {
            const inputs = document.querySelectorAll('input[type="text"]');
            const formData = {};

            inputs.forEach(input => {
                formData[input.parentElement.textContent.trim() || input.previousElementSibling.textContent
                    .trim()] = input.value;
            });

            localStorage.setItem('salarySlipData', JSON.stringify(formData));
            alert('Data saved successfully!');
        }

        // Function to load form data from localStorage
        function loadFormData() {
            const savedData = localStorage.getItem('salarySlipData');
            if (savedData) {
                const formData = JSON.parse(savedData);
                const inputs = document.querySelectorAll('input[type="text"]');

                inputs.forEach(input => {
                    const key = input.parentElement.textContent.trim() || input.previousElementSibling.textContent
                        .trim();
                    if (formData[key]) {
                        input.value = formData[key];
                    }
                });
            }
        }

        // Load saved data when page loads
        window.addEventListener('DOMContentLoaded', loadFormData);



        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("employeeSearch");
            const suggestionsList = document.getElementById("employeeSuggestions");

            // Move suggestions list directly under <body> to avoid clipping
            document.body.appendChild(suggestionsList);

            // Keep it hidden by default
            suggestionsList.style.display = "none";

            // 🔍 Trigger live search as user types
            searchInput.addEventListener("keyup", function(e) {
                const query = e.target.value.trim();

                // If Enter key is pressed
                if (e.key === "Enter") {
                    performSearch(query);
                } else {
                    // Live suggestions after typing 2+ characters
                    if (query.length >= 2) {
                        searchEmployee(query);
                    } else {
                        suggestionsList.style.display = "none";
                    }
                }
            });

            // Recalculate position on scroll or resize
            window.addEventListener("scroll", positionSuggestionsList);
            window.addEventListener("resize", positionSuggestionsList);
        });

        // 📍 Dynamically position suggestions under the input field
        function positionSuggestionsList() {
            const input = document.getElementById("employeeSearch");
            const list = document.getElementById("employeeSuggestions");
            const rect = input.getBoundingClientRect();

            list.style.position = "fixed";
            list.style.top = rect.bottom + 5 + "px";
            list.style.left = rect.left + "px";
            list.style.width = rect.width + "px";
            list.style.zIndex = 99999;
        }

        // 🔧 Triggered when Enter key or Search button pressed
        function performSearch(query = null) {
            const input = document.getElementById("employeeSearch");
            query = query || input.value.trim();

            if (query.length < 2) {
                alert("Please type at least 2 characters to search.");
                return;
            }

            searchEmployee(query);
        }

        // 🧠 Fetch employee list via AJAX
        function searchEmployee(query) {
            const list = document.getElementById("employeeSuggestions");
            list.innerHTML = '<li>Searching...</li>';
            list.style.display = "block";
            positionSuggestionsList();

            fetch(`/hrms/payroll/salary-slip/search?query=${encodeURIComponent(query)}`)
                .then((response) => response.json())
                .then((data) => {
                    list.innerHTML = "";

                    if (data.length === 0) {
                        list.innerHTML = '<li>No results found</li>';
                        return;
                    }

                    // ✅ Auto-fill if only one match found
                    if (data.length === 1) {
                        selectEmployee(data[0]);
                        list.style.display = "none";
                        return;
                    }

                    // 🧾 Render all results
                    data.forEach((emp) => {
                        const li = document.createElement("li");
                        li.textContent = `${emp.candidate_name} (${emp.candidate_id})`;
                        li.onclick = () => {
                            selectEmployee(emp);
                            list.style.display = "none";
                        };
                        list.appendChild(li);
                    });
                })
                .catch((err) => {
                    console.error("Search error:", err);
                    list.innerHTML = '<li>Error fetching data</li>';
                });
        }

        // ✍️ Fill employee data in Salary Slip inputs
        function selectEmployee(emp) {
            document.querySelector(".employee-name-input").value = emp.candidate_name;
            document.querySelector('input[data-field="name"]').value = emp.candidate_name;
            document.querySelector('input[data-field="designation"]').value = emp.designation;
            document.querySelector('input[data-field="joining_date"]').value = emp.joining_date;
            document.querySelector('input[data-field="employee_id"]').value = emp.candidate_id;
            document.querySelector('input[data-field="ctc"]').value = emp.ctc;
        }
        // 🧮 Auto-calculate totals accurately and format numbers
        function calculateTotals() {
            const earningRows = document.querySelectorAll('#earnings-deductions tr:not(.summary-row)');
            const deductionRows = document.querySelectorAll('#earnings-deductions tr:not(.summary-row)');

            let totalEarnings = 0;
            let totalDeductions = 0;

            const parseAmount = (val) => {
                if (!val || val === '—' || val === '-' || val === '–') return 0;
                return parseFloat(val.replace(/,/g, '').trim()) || 0;
            };

            // ✅ Loop through each earning and deduction cell (ignore summary row)
            earningRows.forEach(row => {
                const earningCell = row.querySelector('td:nth-child(2) input');
                const deductionCell = row.querySelector('td:nth-child(4) input');

                if (earningCell) totalEarnings += parseAmount(earningCell.value);
                if (deductionCell) totalDeductions += parseAmount(deductionCell.value);
            });

            // 🧾 Update totals
            const totalEarningField = document.querySelector('.summary-row td:nth-child(2) input');
            const totalDeductionField = document.querySelector('.summary-row td:nth-child(4) input');
            const netSalaryField = document.querySelector('.total-value');

            totalEarningField.value = totalEarnings.toLocaleString('en-IN');
            totalDeductionField.value = totalDeductions ? totalDeductions.toLocaleString('en-IN') : '0';
            netSalaryField.value = '₹' + (totalEarnings - totalDeductions).toLocaleString('en-IN');
        }

        // 🧹 Format numeric values cleanly with commas (Indian format)
        function formatInputValue(input) {
            let val = input.value.replace(/,/g, '');
            if (!isNaN(val) && val.trim() !== '') {
                input.value = parseFloat(val).toLocaleString('en-IN');
            }
        }

        // 🔁 Listen for changes and blur events
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('numeric-cell')) {
                calculateTotals();
            }
        });

        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('numeric-cell')) {
                formatInputValue(e.target);
                calculateTotals();
            }
        }, true);

        // 🚀 Run once when page loads
        window.addEventListener('DOMContentLoaded', calculateTotals);

        //save 
        // 💾 Save Salary Slip Data to Database
function saveFormData() {
    // Create a FormData object to send all inputs easily
    const formData = new FormData();

    // Collect all input values (text, date, month)
    document.querySelectorAll('input').forEach(input => {
        const nameAttr = input.getAttribute('data-field') || input.getAttribute('name');
        if (nameAttr) {
            formData.append(nameAttr, input.value);
        }
    });

    // Add totals separately
    const totalEarnings = document.querySelector('.summary-row td:nth-child(2) input').value.replace(/,/g, '');
    const totalDeductions = document.querySelector('.summary-row td:nth-child(4) input').value.replace(/,/g, '');
    const netSalary = document.querySelector('.total-value').value.replace(/[₹,]/g, '');

    formData.append('total_earnings', totalEarnings || 0);
    formData.append('total_deductions', totalDeductions || 0);
    formData.append('net_salary', netSalary || 0);

    // CSRF token for Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // 🔥 Send data to Laravel controller
    fetch('{{ route("salaryslip.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('✅ Salary Slip saved successfully!');
            console.log('Saved:', data);
        } else {
            alert('❌ Error saving data. Check console.');
            console.error(data);
        }
    })
    .catch(err => {
        alert('⚠️ Something went wrong while saving.');
        console.error('Save error:', err);
    });
}

    </script>
</body>

</html>
