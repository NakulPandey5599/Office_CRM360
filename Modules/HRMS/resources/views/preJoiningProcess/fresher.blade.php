<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pre-Joining Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: -webkit-linear-gradient(135deg, #f6faff, #eef7ff);
            background: linear-gradient(135deg, #f6faff, #eef7ff);
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            background: -webkit-linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd, #60a5fa);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd, #60a5fa);
            background-size: 300% 300%;
            -webkit-animation: gradientShift 10s ease infinite;
            animation: gradientShift 10s ease infinite;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            color: #03396c;
        }

        @-webkit-keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .container h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #03396c;
            margin-bottom: 20px;
        }

        .progress-container {
            margin-bottom: 30px;
        }

        .progressbar {
            display: flex;
            justify-content: space-between;
            list-style: none;
            margin-top: 15px;
            position: relative;
        }

        .progressbar li {
            flex: 1;
            text-align: center;
            position: relative;
            font-size: .9rem;
            font-weight: 500;
            color: #444;
        }

        .progressbar li::before {
            content: attr(data-step);
            display: flex;
            justify-content: center;
            align-items: center;
            width: 35px;
            height: 35px;
            margin: 0 auto 10px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #555;
            font-weight: 600;
            transition: .3s;
        }

        .progressbar li.active::before {
            background: -webkit-linear-gradient(135deg, #3b82f6, #2563eb);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
        }

        .progressbar li.completed::before {
            background: -webkit-linear-gradient(135deg, #3b82f6, #2563eb);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
        }

        .progressbar li::after {
            content: "";
            position: absolute;
            top: 14px;
            left: 50%;
            width: calc(100% - 35px);
            height: 4px;
            background: #ddd;
        }

        .progressbar li.completed::after {
            background: -webkit-linear-gradient(135deg, #3b82f6, #2563eb);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .progressbar li:last-child::after {
            display: none;
        }

        .form-step {
            display: none;
            -webkit-animation: fadeIn .5s ease;
            animation: fadeIn .5s ease;
            padding: 20px;
            border-radius: 15px;
            margin-top: 15px;
        }

        .form-step.active {
            display: block;
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .half-width {
            flex: 1 1 45%;
        }

        .third-width {
            flex: 1 1 30%;
        }

        @media (max-width: 768px) {

            .half-width,
            .third-width {
                flex: 1 1 100%;
            }
        }

        input,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #bfdbfe;
            border-radius: 12px;
            outline: none;
            font-size: .95rem;
            background: #fff;
        }

        input:focus,
        select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, .2);
        }

        .file-upload {
            background: rgba(240, 245, 255, .8);
            border: 2px dashed #93c5fd;
            padding: 25px;
            text-align: center;
            border-radius: 15px;
            margin: 15px 0;
            font-size: .9rem;
            color: #2563eb;
            cursor: pointer;
        }

        .file-upload button {
            margin-top: 10px;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            background: -webkit-linear-gradient(135deg, #3b82f6, #2563eb);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            cursor: pointer;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .btn-prev,
        .btn-next,
        .btn-cancel {
            padding: 12px 22px;
            border: none;
            border-radius: 10px;
            font-size: .95rem;
            cursor: pointer;
        }

        .btn-prev {
            background: -webkit-linear-gradient(135deg, #e5e7eb, #d1d5db);
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        }

        .btn-cancel {
            background: -webkit-linear-gradient(135deg, #f87171, #ef4444);
            background: linear-gradient(135deg, #f87171, #ef4444);
            color: #fff;
        }

        .btn-next {
            background: -webkit-linear-gradient(135deg, #3b82f6, #2563eb);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
        }

        .btn-group-right {
            display: flex;
            gap: 12px;
        }

        hr {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin-top: 10px;
        }

        .add-btn {
            cursor: pointer;
            margin-left: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            background: #bfdbfe;
            border-radius: 50%;
            padding: 2px 8px;
        }

        .delete-btn {
            background: -webkit-linear-gradient(135deg, #f87171, #ef4444);
            background: linear-gradient(135deg, #f87171, #ef4444);
            color: #fff;
            border: none;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            font-size: .8rem;
        }

        .block-title {
            margin: 5px 0 10px 0;
            color: #2563eb;
        }

        .file-name {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #0c4a6e;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Pre-Joining Form</h2>
        <div class="progress-container">
            <ul class="progressbar" id="progressbar">
                <li data-step="1" class="active"><span>Personal Info</span></li>
                <li data-step="2"><span>Education</span></li>
                <li data-step="3"><span>Family/Emergency</span></li>
            </ul>
        </div>
        <!-- Success Message -->
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
        @endif
        <div class="alert alert-success" style="display: none;" id="success-message"></div>
        <div class="alert alert-danger" style="display: none;" id="error-message"></div>
        <ul id="error-list" style="display: none; color: red;"></ul>

        <form id="multiStepForm" action="{{ route('preJoiningProcess.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Step 1 -->
            <input type="hidden" name="experience_type" value="Fresher">
            

            <div class="form-step active">
                <h3>Personal Information</h3>
                <div class="form-group">
                    <div class="half-width"><input name="first_name" type="text" placeholder="Enter first name"
                            required></div>
                    <div class="half-width"><input name="last_name" type="text" placeholder="Enter last name"
                            required></div>
                    <div class="half-width"><input name="email" type="email" placeholder="Enter your email"
                            required></div>
                    <div class="half-width"><input name="phone" type="tel" placeholder="Enter your phone number"
                            required pattern="\d{10}"></div>
                    <div class="third-width"><input name="dob" type="date" required></div>
                    <div class="third-width">
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="third-width">
                        <select name="job_profile" required>
                            <option value="">Select Job Profile</option>
                            <option>Software Developer</option>
                            <option>UI/UX Designer</option>
                            <option>Project Manager</option>
                            <option>HR Executive</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="half-width"><input name="address" type="text" placeholder="Enter Address" required>
                    </div>
                    <div class="half-width"><input name="permanent_address" type="text"
                            placeholder="Enter Permanent Address" required></div>
                    <div class="half-width"><input name="pan_number" type="text" placeholder="Enter PAN" required
                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"></div>
                    <div class="half-width"><input name="aadhaar_number" type="text" placeholder="Enter Aadhaar"
                            required pattern="\d{12}"></div>
                </div>
                <div class="form-group">
                    <div class="half-width">
                        <div class="file-upload">
                            Upload PAN Proof <br />
                            <input type="file" name="pan_proof" id="pan-upload" accept=".pdf,.jpg,.jpeg,.png"
                                required style="display:none;" />
                            <button type="button" aria-label="Upload PAN proof file">Upload PAN</button>
                            <span class="file-name" id="pan-file-name"></span>
                        </div>
                    </div>
                    <div class="half-width">
                        <div class="file-upload">
                            Upload Aadhaar Proof <br />
                            <input type="file" name="aadhaar_proof" id="aadhaar-upload" accept=".pdf,.jpg,.jpeg,.png"
                                required style="display:none;" />
                            <button type="button" aria-label="Upload Aadhaar proof file">Upload Aadhaar</button>
                            <span class="file-name" id="aadhaar-file-name"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 Education -->
            <div class="form-step">
                <h3>Highest Qualification <span class="add-btn" onclick="addQualification()">+</span></h3>
                <div id="qualification-section">
                    <div class="qualification-block" data-initial="true">
                        <h4 class="block-title">Highest Qualification</h4>
                        <div class="form-group">
                            <div class="half-width"><input name="highest_qualification[]" type="text"
                                    placeholder="Qualification" required></div>
                            <div class="half-width"><input name="highest_university[]" type="text"
                                    placeholder="University/College" required></div>
                            <div class="half-width"><input name="year_of_passing[]" type="text"
                                    placeholder="Year of Passing" required pattern="\d{4}"></div>
                            <div class="half-width"><input name="highest_specialization[]" type="text"
                                    placeholder="Specialization" required></div>
                            <div class="half-width"><input name="university_percentage[]" type="text"
                                    placeholder="Percentage / CGPA" required pattern="\d*\.?\d+"></div>
                        </div>
                        <div class="file-upload">
                            <input type="file" id="university_document" name="university_document[]"
                                accept=".pdf,.jpg,.jpeg,.png" required style="display:none;" />
                            Upload Documents <br />
                            <button type="button" aria-label="Upload university documents">Browse Files</button>
                            <span class="file-name" id="university-file-name"></span>
                        </div>
                        <hr />
                    </div>
                </div>
                <h4>12th Grade / PUC</h4>
                <div class="form-group">
                    <div class="half-width"><input name="puc_college" type="text"
                            placeholder="Enter College/Board" required></div>
                    <div class="half-width"><select name="puc_year" required></select></div>
                    <div class="half-width"><input name="puc_percentage" type="text"
                            placeholder="Enter Percentage" required pattern="\d*\.?\d+"></div>
                </div>
                <div class="file-upload">
                    <input type="file" id="puc_document" name="puc_document" accept=".pdf,.jpg,.jpeg,.png"
                        required style="display:none;" />
                    Upload Documents <br />
                    <button type="button" aria-label="Upload PUC documents">Browse Files</button>
                    <span class="file-name" id="puc-file-name"></span>
                </div>
                <h4>10th Grade</h4>
                <div class="form-group">
                    <div class="half-width"><input name="tenth_school" type="text"
                            placeholder="Enter School/Board" required></div>
                    <div class="half-width"><select name="tenth_year" required></select></div>
                    <div class="half-width"><input name="tenth_percentage" type="text"
                            placeholder="Enter Percentage" required pattern="\d*\.?\d+"></div>
                </div>
                <div class="file-upload">
                    <input type="file" id="tenth_document" name="tenth_document" accept=".pdf,.jpg,.jpeg,.png"
                        required style="display:none;" />
                    Upload Documents <br />
                    <button type="button" aria-label="Upload 10th grade documents">Browse Files</button>
                    <span class="file-name" id="tenth-file-name"></span>
                </div>
            </div>

            <!-- Step 3 Family -->
            <div class="form-step">
                <h3>Family/Emergency</h3>
                <div class="form-group">
                    <div class="half-width"><input name="father_name" type="text" placeholder="Father's Name"
                            required></div>
                    <div class="half-width"><input name="mother_name" type="text" placeholder="Mother's Name"
                            required></div>
                    <div class="half-width"><input name="emergency_contact_name" type="text"
                            placeholder="Emergency Contact" required></div>
                    <div class="half-width"><input name="emergency_contact_number" type="text"
                            placeholder="Emergency Number" required pattern="\d{10}"></div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="btn-container">
                <button type="button" class="btn-prev" onclick="prevStep()">Back</button>
                <div class="btn-group-right">
                    <button type="button" class="btn-cancel"
                        onclick="document.getElementById('multiStepForm').reset()">Cancel</button>
                    <button type="button" class="btn-next" onclick="nextStep()">Save & Continue</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll(".form-step");
        const progressbarItems = document.querySelectorAll(".progressbar li");
        let qualificationCounter = 1;

        function showStep(step) {
            steps.forEach((el, i) => el.classList.toggle("active", i === step));
            progressbarItems.forEach((el, i) => {
                el.classList.toggle("active", i === step);
                el.classList.toggle("completed", i < step);
            });
        }

        function validateStep(step) {
    const currentFormStep = steps[step];
    let valid = true;

    // Check all inputs except hidden files
    currentFormStep.querySelectorAll("input[type=text], input[type=email], input[type=tel], select").forEach(field => {
        if (!field.value) valid = false;
    });

    // Check all file inputs in this step
    currentFormStep.querySelectorAll("input[type=file]").forEach(fileInput => {
        if (!fileInput.files || fileInput.files.length === 0) valid = false;
    });

    if (!valid) {
        document.getElementById("error-list").style.display = "block";
        document.getElementById("error-list").innerHTML =
            `<li>Please fill all required fields in step ${step + 1}</li>`;
        return false;
    }

    document.getElementById("error-list").style.display = "none";
    return true;
}


        function nextStep() {
            if (validateStep(currentStep)) {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    document.getElementById("multiStepForm").submit();
                }
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function setupFileUpload(fileInput, button, displaySpan) {
            if (!fileInput || !button || !displaySpan) return;
            button.addEventListener("click", () => fileInput.click());
            fileInput.addEventListener("change", function() {
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (this.files.length > 0) {
                    const files = Array.from(this.files);
                    if (files.every(f => validTypes.includes(f.type) && f.size <= maxSize)) {
                        const names = files.map(f => f.name).join(", ");
                        displaySpan.textContent = names;
                    } else {
                        displaySpan.textContent = "Invalid file type or size (max 5MB, .pdf/.jpg/.png)";
                        this.value = "";
                    }
                }
            });
        }

        function populateYears(selectId, startYear, endYear) {
            const select = document.querySelector(`select[name="${selectId}"]`);
            select.innerHTML = '<option value="">Select year</option>';
            for (let year = endYear; year >= startYear; year--) {
                select.innerHTML += `<option>${year}</option>`;
            }
        }

        // Initialize file uploads
        setupFileUpload(
            document.getElementById("pan-upload"),
            document.querySelector("button[aria-label='Upload PAN proof file']"),
            document.getElementById("pan-file-name")
        );
        setupFileUpload(
            document.getElementById("aadhaar-upload"),
            document.querySelector("button[aria-label='Upload Aadhaar proof file']"),
            document.getElementById("aadhaar-file-name")
        );
        setupFileUpload(
            document.getElementById("university_document"),
            document.querySelector(".qualification-block[data-initial='true'] .file-upload button"),
            document.getElementById("university-file-name")
        );
        setupFileUpload(
            document.getElementById("puc_document"),
            document.querySelector("button[aria-label='Upload PUC documents']"),
            document.getElementById("puc-file-name")
        );
        setupFileUpload(
            document.getElementById("tenth_document"),
            document.querySelector("button[aria-label='Upload 10th grade documents']"),
            document.getElementById("tenth-file-name")
        );

        // Populate year dropdowns
        populateYears("puc_year", 1980, new Date().getFullYear());
        populateYears("tenth_year", 1980, new Date().getFullYear());

        function addQualification() {
            const section = document.getElementById("qualification-section");
            const template = section.querySelector(".qualification-block[data-initial='true']");
            const clone = template.cloneNode(true);
            clone.dataset.initial = "false";

            // Reset input values except files
            clone.querySelectorAll("input").forEach(input => {
                if (input.type !== "file") input.value = "";
            });

            // Set file input name as array
            const fileInput = clone.querySelector("input[type='file']");
            const fileNameSpan = clone.querySelector(".file-name");
            const uploadButton = clone.querySelector(".file-upload button");
            fileInput.value = "";
            fileInput.name = "university_documents[]"; // ✅ Important for Laravel
            fileNameSpan.textContent = "";

            // Initialize file upload for cloned block
            setupFileUpload(fileInput, uploadButton, fileNameSpan);

            // Add delete button for cloned block
            const del = document.createElement("button");
            del.type = "button";
            del.className = "delete-btn";
            del.textContent = "Delete";
            del.addEventListener("click", () => clone.remove());
            clone.appendChild(del);

            section.appendChild(clone);
        }


        // Form submission validation
        document.getElementById("multiStepForm").addEventListener("submit", function(e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                // Simulate successful submission for static HTML
                document.getElementById("success-message").style.display = "block";
                document.getElementById("success-message").textContent = "Form submitted successfully!";
                this.reset();
                currentStep = 0;
                showStep(currentStep);
            }
        });
    </script>
</body>

</html>
