<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pre-Joining Form</title>
    {{-- <link rel="stylesheet" href="{{ asset('Modules/HRMS/css/app.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>.alert {
    padding: 12px 20px;
    margin: 15px 0;
    border-radius: 8px;
    font-weight: 500;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 5px solid #dc3545;
}
</style>
</head>

<body>

    <div class="prejoin-container">
        @if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" id="error-message">
        <ul id="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <h2>Pre-Joining Form</h2>
        <div class="prejoin-progress-container">
            <ul class="prejoin-progressbar" id="prejoin-progressbar">
                <li data-step="1" class="active"><span>Personal Info</span></li>
                <li data-step="2"><span>Education</span></li>
                <li data-step="3"><span>Family/Emergency</span></li>
                <li data-step="4"><span>Previous Emp</span></li>
            </ul>
        </div>

        <div class="alert alert-success" style="display: none;" id="success-message"></div>
        <div class="alert alert-danger" style="display: none;" id="error-message"></div>
        <ul id="error-list" style="display: none; color: red;"></ul>

        <form id="prejoin-multiStepForm" action="{{ route('preJoiningProcess.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="experience_type" value="Experienced">

            <!-- Step 1: Personal Info -->
            <div class="prejoin-form-step active">
                <h3>Personal Information</h3>
                <div class="prejoin-form-group">
                    <div class="prejoin-half"><input name="first_name" type="text" class="prejoin-input"
                            placeholder="Enter first name"></div>
                    <div class="prejoin-half"><input name="last_name" type="text" class="prejoin-input"
                            placeholder="Enter last name"></div>
                    <div class="prejoin-half"><input name="email" type="email" class="prejoin-input"
                            placeholder="Enter your email"></div>
                    <div class="prejoin-half"><input name="phone" type="tel" class="prejoin-input"
                            placeholder="Enter your phone number"></div>
                    <div class="prejoin-third"><input name="dob" type="text" class="prejoin-input"
                            placeholder="DD/MM/YYYY"></div>
                    <div class="prejoin-third">
                        <select name="gender" class="prejoin-select">
                            <option>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="prejoin-third">
                        <select name="job_profile" class="prejoin-select">
                            <option>Select Job Profile</option>
                            <option>Software Developer</option>
                            <option>UI/UX Designer</option>
                            <option>Project Manager</option>
                            <option>HR Executive</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="prejoin-half"><input name="address" type="text" class="prejoin-input"
                            placeholder="Enter Address"></div>
                    <div class="prejoin-half"><input name="permanent_address" type="text" class="prejoin-input"
                            placeholder="Enter Permanent Address"></div>
                </div>

                <!-- Address Proof -->
                <div class="prejoin-form-group">
                    <div class="prejoin-half">
                        <div class="prejoin-file">
                            Upload PAN Proof <br />
                            <input type="file" name="pan_proof" class="prejoin-input-file"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <button type="button" class="prejoin-upload-btn">Upload PAN</button>
                            <span class="file-name"></span>
                        </div>
                    </div>
                    <div class="prejoin-half">
                        <div class="prejoin-file">
                            Upload Aadhaar Proof <br />
                            <input type="file" name="aadhaar_proof" class="prejoin-input-file"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <button type="button" class="prejoin-upload-btn">Upload Aadhaar</button>
                            <span class="file-name"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Education -->
            <div class="prejoin-form-step">
                <h3>Highest Qualification <span class="prejoin-add-btn" onclick="addQualification()">+</span></h3>
                <div id="prejoin-qualification-section">
                    <div class="prejoin-qualification-block" data-initial="true">
                        <h4 class="prejoin-block-title">Highest Qualification</h4>
                        <div class="prejoin-form-group">
                            <div class="prejoin-half"><input name="highest_qualification[]" type="text"
                                    class="prejoin-input" placeholder="Qualification"></div>
                            <div class="prejoin-half"><input name="highest_university[]" type="text"
                                    class="prejoin-input" placeholder="University/College"></div>
                            <div class="prejoin-half"><input name="year_of_passing[]" type="text"
                                    class="prejoin-input" placeholder="Year of Passing"></div>
                            <div class="prejoin-half"><input name="highest_specialization[]" type="text"
                                    class="prejoin-input" placeholder="Specialization"></div>
                            <div class="prejoin-half"><input name="university_percentage[]" type="text"
                                    class="prejoin-input" placeholder="Percentage / CGPA"></div>
                        </div>
                        <div class="prejoin-file">
                            Upload Documents <br />
                            <input type="file" name="university_documents[]" class="prejoin-input-file" multiple
                                accept=".pdf,.jpg,.jpeg,.png">
                            <button type="button" class="prejoin-upload-btn">Browse Files</button>
                            <span class="file-name"></span>
                        </div>
                        <hr />
                    </div>
                </div>

                <h4>12th Grade / PUC</h4>
                <div class="prejoin-form-group">
                    <div class="prejoin-half"><input name="puc_college" type="text" class="prejoin-input"
                            placeholder="Enter College/Board"></div>
                    <div class="prejoin-half">
                        <select class="prejoin-select" name="puc_year">
                            <option>Select year</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="prejoin-half"><input name="puc_percentage" type="text" class="prejoin-input"
                            placeholder="Enter Percentage"></div>
                </div>
                <div class="prejoin-file">
                    Upload Documents <br />
                    <input type="file" name="puc_document" class="prejoin-input-file"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <button type="button" class="prejoin-upload-btn">Browse Files</button>
                    <span class="file-name"></span>
                </div>

                <h4>10th Grade</h4>
                <div class="prejoin-form-group">
                    <div class="prejoin-half"><input name="tenth_school" type="text" class="prejoin-input"
                            placeholder="Enter School/Board"></div>
                    <div class="prejoin-half">
                        <select class="prejoin-select" name="tenth_year">
                            <option>Select year</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="prejoin-half"><input name="tenth_percentage" type="text" class="prejoin-input"
                            placeholder="Enter Percentage"></div>
                </div>
                <div class="prejoin-file">
                    Upload Documents <br />
                    <input type="file" name="tenth_document" class="prejoin-input-file"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <button type="button" class="prejoin-upload-btn">Browse Files</button>
                    <span class="file-name"></span>
                </div>
            </div>

            <!-- Step 3: Family/Emergency -->
            <div class="prejoin-form-step">
                <h3>Family/Emergency</h3>
                <div class="prejoin-form-group">
                    <div class="prejoin-half"><input name="father_name" type="text" class="prejoin-input"
                            placeholder="Father's Name"></div>
                    <div class="prejoin-half"><input name="mother_name" type="text" class="prejoin-input"
                            placeholder="Mother's Name"></div>
                    <div class="prejoin-half"><input name="emergency_contact_name" type="text"
                            class="prejoin-input" placeholder="Emergency Contact"></div>
                    <div class="prejoin-half"><input name="emergency_contact_number" type="text"
                            class="prejoin-input" placeholder="Emergency Number"></div>
                </div>
            </div>

            <!-- Step 4: Previous Employment -->
            <div class="prejoin-form-step">
                <h3>Previous Employment <span class="prejoin-add-btn" onclick="addEmployment()">+</span></h3>

                <div id="prejoin-employment-section">
                    <div class="prejoin-employment-block" data-initial="true">
                        <div class="prejoin-form-group">
                            <div class="prejoin-half">
                                <input type="text" name="company_name[]" class="prejoin-input"
                                    placeholder="Company Name">
                            </div>
                            <div class="prejoin-half">
                                <input type="text" name="designation[]" class="prejoin-input"
                                    placeholder="Designation">
                            </div>
                            <div class="prejoin-half">
                                <input type="text" name="duration[]" class="prejoin-input"
                                    placeholder="Duration">
                            </div>
                            <div class="prejoin-half">
                                <input type="text" name="reason_for_leaving[]" class="prejoin-input"
                                    placeholder="Reason for Leaving">
                            </div>
                        </div>

                        <!-- Upload Salary Slip & Experience Certificate -->
                        <div class="prejoin-form-group">
                            <div class="prejoin-half">
                                <div class="prejoin-file">
                                    Upload Salary Slip <br />
                                    <input type="file" name="salary_slip" class="prejoin-input-file" />
                                    <button type="button" class="prejoin-upload-btn">Upload Salary Slip</button>
                                    <span class="file-name"></span>
                                </div>
                            </div>

                            <div class="prejoin-half">
                                <div class="prejoin-file">
                                    Upload Experience Certificate <br />
                                    <input type="file" name="experience_certificate[]"
                                        class="prejoin-input-file" />
                                    <button type="button" class="prejoin-upload-btn">Upload Certificate</button>
                                    <span class="file-name"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment Table -->
                <table class="prejoin-table">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Designation</th>
                            <th>Duration</th>
                            <th>Receiving Letter</th>
                        </tr>
                    </thead>
                    <tbody id="employment-table-body"></tbody>
                </table>
            </div>

            <!-- Navigation Buttons -->
            <div class="prejoin-btn-container">
                <button type="button" class="prejoin-btn prejoin-btn-prev" onclick="prevStep()">Back</button>
                <div class="prejoin-btn-group">
                    <button type="button" class="prejoin-btn prejoin-btn-cancel">Cancel</button>
                    <!-- Change your button in the last step -->
                    <button type="button" class="prejoin-btn prejoin-btn-next" id="saveContinueBtn"
                        onclick="nextStep()">Save & Continue</button>
                </div>
            </div>
        </form>
    </div>
<script>

document.addEventListener('DOMContentLoaded', () => {
    const successMsg = document.getElementById('success-message');
    if (successMsg) {
        successMsg.style.transition = 'opacity 0.8s ease';
        setTimeout(() => {
            successMsg.style.opacity = '0';
            setTimeout(() => successMsg.remove(), 800);
        }, 4000); // Hide after 4 seconds
    }
});

document.addEventListener('DOMContentLoaded', () => {

    // === Multi-step form core ===
    let currentStep = 0;
    const steps = document.querySelectorAll(".prejoin-form-step");
    const progressbarItems = document.querySelectorAll(".prejoin-progressbar li");
    const form = document.getElementById("prejoin-multiStepForm");
    const saveBtn = document.getElementById("saveContinueBtn");

    // ✅ Show current step initially
    showStep(currentStep);

    // ✅ Handle Save/Submit button
    saveBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (saveBtn.textContent.trim() === "Submit") {
            console.log("✅ Submitting form...");
            form.submit();
        } else {
            nextStep();
        }
    });

    // ✅ Show specific step
    function showStep(stepIndex) {
        steps.forEach((el, i) => el.classList.toggle("active", i === stepIndex));
        progressbarItems.forEach((el, i) => el.classList.toggle("active", i <= stepIndex));
        saveBtn.textContent = (stepIndex === steps.length - 1) ? "Submit" : "Save & Continue";
    }

    // ✅ Go to next step (without resetting)
    function nextStep() {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }

    // ✅ Go to previous step
    window.prevStep = () => {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    };

    // === Upload button handling ===
    function initUploadButtons(container = document) {
        container.querySelectorAll('.prejoin-file').forEach(wrapper => {
            const input = wrapper.querySelector('input[type="file"]');
            const button = wrapper.querySelector('button');
            const fileNameSpan = wrapper.querySelector('.file-name');
            if (!input || !button) return;

            const newBtn = button.cloneNode(true);
            button.replaceWith(newBtn);

            newBtn.addEventListener('click', e => {
                e.preventDefault();
                input.click();
            });

            input.addEventListener('change', () => {
                fileNameSpan.textContent = input.files.length > 0
                    ? Array.from(input.files).map(f => f.name).join(', ')
                    : '';
            });
        });
    }

    // === Delete button for dynamic blocks ===
    function attachDeleteButton(block) {
        if (block.dataset.initial === "true") return;
        if (!block.querySelector('.prejoin-delete-btn')) {
            const del = document.createElement('button');
            del.type = 'button';
            del.className = 'prejoin-delete-btn';
            del.textContent = 'Delete';
            del.addEventListener('click', () => {
                block.remove();
                updateEmploymentTable();
            });
            block.appendChild(del);
        }
    }

    // === Qualification (+ Add) ===
    window.addQualification = () => {
        const section = document.getElementById("prejoin-qualification-section");
        const template = section.querySelector(".prejoin-qualification-block[data-initial='true']");
        const clone = template.cloneNode(true);
        clone.dataset.initial = "false";
        clone.querySelectorAll('input').forEach(i => i.value = '');
        attachDeleteButton(clone);
        section.appendChild(clone);
        initUploadButtons(clone);
    };

    // === Employment Table ===
    const section = document.getElementById("prejoin-employment-section");
    const tableBody = document.getElementById("employment-table-body");

    function updateEmploymentTable() {
        tableBody.innerHTML = '';
        section.querySelectorAll('.prejoin-employment-block').forEach(block => {
            const company = block.querySelector('input[name^="company_name"]').value;
            const designation = block.querySelector('input[name^="designation"]').value;
            const duration = block.querySelector('input[name^="duration"]').value;

            if (company || designation || duration) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${company}</td>
                    <td>${designation}</td>
                    <td>${duration}</td>
                    <td>
                        <div class="prejoin-file">
                            <input type="file" class="receiving-letter-file" hidden />
                            <button type="button" class="prejoin-browse-btn">Upload</button>
                            <span class="file-name"></span>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);

                const input = row.querySelector('.receiving-letter-file');
                const button = row.querySelector('.prejoin-browse-btn');
                const fileNameSpan = row.querySelector('.file-name');

                button.addEventListener('click', e => {
                    e.preventDefault();
                    input.click();
                });

                input.addEventListener('change', () => {
                    fileNameSpan.textContent = input.files.length > 0
                        ? Array.from(input.files).map(f => f.name).join(', ')
                        : '';
                });
            }
        });
    }

    function attachEmploymentListeners(block) {
        block.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('input', updateEmploymentTable);
        });
    }

    // === Initialize employment blocks ===
    section.querySelectorAll('.prejoin-employment-block').forEach(block => {
        attachDeleteButton(block);
        attachEmploymentListeners(block);
    });

    // === Add new employment block ===
    window.addEmployment = () => {
        const template = section.querySelector('.prejoin-employment-block[data-initial="true"]');
        const clone = template.cloneNode(true);
        clone.dataset.initial = "false";
        clone.querySelectorAll('input').forEach(i => i.value = '');
        attachDeleteButton(clone);
        attachEmploymentListeners(clone);
        section.appendChild(clone);
        initUploadButtons(clone);
        updateEmploymentTable();
    };

    // === Initialize ===
    initUploadButtons();
    updateEmploymentTable();
});
</script>


</body>
