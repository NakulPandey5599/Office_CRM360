<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MCQ Manager | HRMS</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #111827;
            margin: 0;
            display: flex;
        }
        .main-content { flex: 1; margin-left: 250px; padding: 30px; background: #f9fafb; min-height: 100vh; z-index: 1; }
        .page-container { max-width: 900px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .page-container h2 { margin-top: 0; color: #1f2937; display: flex; justify-content: space-between; align-items: center; }
        .add-mcq-btn { background: #10b981; color: #fff; border: none; border-radius: 8px; padding: 10px 16px; font-size: 15px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .3s; }
        .add-mcq-btn:hover { background: #059669; }

        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 999; }
        .modal-content { background: #fff; padding: 25px; border-radius: 12px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; }
        .close-btn { position: absolute; top: 12px; right: 15px; background: transparent; border: none; font-size: 1.5rem; cursor: pointer; }

        label { display: block; margin-top: 8px; font-weight: 600; }
        textarea, input, select { width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; margin-top: 4px; }

        .mcq-block { border: 1px solid #ddd; padding: 15px; border-radius: 10px; margin-bottom: 20px; background: #f9fafb; }
        .mcq-header { display: flex; justify-content: space-between; align-items: center; }
        .remove-btn { border: none; background: #ffdddd; color: #a00; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; }

        .options-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .btn-group { display: flex; justify-content: space-between; margin-top: 15px; }
        .add-btn, .save-btn { padding: 10px 16px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .add-btn { background: #e0f7ff; color: #0077b6; }
        .save-btn { background: #0077b6; color: #fff; }

        .mcq-table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .mcq-table th, .mcq-table td { padding: 12px 14px; border-bottom: 1px solid #eee; text-align: left; vertical-align: top; }
        .mcq-table th { background: #0077b6; color: #fff; font-weight: 600; }
        .mcq-table tr:hover { background: #f9fafb; }

        .edit-btn, .delete-btn { border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .edit-btn { background: #f1f5f9; color: #0077b6; }
        .delete-btn { background: #fee2e2; color: #b91c1c; margin-left: 6px; }
        .edit-btn:hover { background: #e0f2fe; }
        .delete-btn:hover { background: #fecaca; }

        .status-pill { font-weight: 600; }
        .status-pill.active { color: #16a34a; }
        .status-pill.inactive { color: #dc2626; }

        .status-select { width: auto; min-width: 120px; }
    </style>
</head>

<body>
@include('hrms::partials.sidebar')

<div class="main-content">
    <div class="page-container">
        <h2>
            MCQ Manager
            <button class="add-mcq-btn" id="openAddMcq">
                <i class="fa fa-question-circle"></i> Add MCQs
            </button>
        </h2>
        <p>Add or manage MCQs related to any training module here.</p>

        <hr style="margin: 25px 0;">
        <h3>Existing MCQs</h3>

        <table class="mcq-table">
            <thead>
            <tr>
                <th>S.No.</th>
                <th>Assessment Name</th>
                <th>No. of Questions</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody id="mcqList">
@forelse($mcqs as $index => $mcq)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $mcq->assessment_name }}</td>
        <td>{{ count($mcq->questions) }} Questions</td>

        <td id="status-{{ $mcq->id }}">
            <button 
                class="status-toggle-btn" 
                data-id="{{ $mcq->id }}"
                data-status="{{ $mcq->status }}"
                style="
                    padding: 6px 14px;
                    border: none;
                    border-radius: 6px;
                    font-weight: 600;
                    cursor: pointer;
                    background: {{ $mcq->status === 'active' ? '#d1fae5' : '#fee2e2' }};
                    color: {{ $mcq->status === 'active' ? '#047857' : '#b91c1c' }};
                ">
                {{ ucfirst($mcq->status) }}
            </button>
        </td>

        <td>
            <button class="edit-btn"
                    data-id="{{ $mcq->id }}"
                    data-assessment="{{ $mcq->assessment_name }}"
                    onclick="openEditModal(this)">
                <i class="fa fa-edit"></i> Edit
            </button>
            <button class="delete-btn" onclick="deleteMcq({{ $mcq->id }})">
                <i class="fa fa-trash"></i> Delete
            </button>
        </td>
    </tr>
@empty
    <tr><td colspan="5" style="text-align:center;">No Assessments found.</td></tr>
@endforelse
</tbody>

        </table>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="mcqModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" id="closeMcqModal">&times;</button>
        <h2 id="modalTitle">Add MCQs</h2>

        <form id="mcqForm">
            @csrf
            <input type="hidden" name="id" id="mcq_id">

            <div class="form-group">
                <label>Assessment Name</label>
                <input type="text" name="assessment_name" id="assessment_name"
                       placeholder="e.g. Communication Skills Test" required style="margin-bottom:10px;">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" id="status" required style="margin-bottom:10px;">
                    <option value="active">Active</option>
                    <option value="inactive" selected>Inactive</option>
                </select>
            </div>

            <div id="mcqGroup">
                <!-- default block -->
                <div class="mcq-block">
                    <div class="mcq-header">
                        <h4>Question <span class="q-index">1</span></h4>
                        <button type="button" class="remove-btn" title="Remove" data-action="remove">&times;</button>
                    </div>

                    <label>Question</label>
                    <textarea name="questions[0][question]" rows="2" required></textarea>

                    <div class="options-grid">
                        <div><label>Option A</label><input type="text" name="questions[0][option_a]" required></div>
                        <div><label>Option B</label><input type="text" name="questions[0][option_b]" required></div>
                        <div><label>Option C</label><input type="text" name="questions[0][option_c]" required></div>
                        <div><label>Option D</label><input type="text" name="questions[0][option_d]" required></div>
                    </div>

                    <label>Correct Option</label>
                    <select name="questions[0][correct_option]" required>
                        <option value="">Select Correct Option</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" id="addMoreMcq" class="add-btn">+ Add Another Question</button>
                <button type="submit" class="save-btn" id="saveBtn">💾 Save MCQs</button>
            </div>
        </form>
    </div>
</div>
<script>
     // Sidebar toggle
        function toggleMenu(header) {
            const submenu = header.nextElementSibling;
            const isOpen = submenu.classList.contains("open");
            document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
            document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
            if (!isOpen) {
                submenu.classList.add("open");
                header.classList.add("active");
            }
        }

        function toggleDropdown(trigger) {
            const container = trigger.nextElementSibling;
            const isOpen = container.classList.contains("open");
            trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList
                .remove("open"));
            trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove(
                "active"));
            if (!isOpen) {
                container.classList.add("open");
                trigger.classList.add("active");
            }
        }
function openEditModal(button) {
    resetModal();  // Clear old fields

    const id = button.dataset.id;
    const assessment = button.dataset.assessment;

    // Set modal title & button text
    document.getElementById('modalTitle').textContent = "Edit MCQ";
    document.getElementById('saveBtn').textContent = "💾 Update MCQ";

    // Fill basic fields
    document.getElementById('mcq_id').value = id;
    document.getElementById('assessment_name').value = assessment;

    // Fetch existing questions via AJAX
    fetch(`/hrms/training-assessment/mcq/get/${id}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert("Failed to load MCQ data");
                return;
            }

            const questions = data.questions;
            const mcqGroup = document.getElementById('mcqGroup');
            mcqGroup.innerHTML = "";  // Clear blocks

            questions.forEach((q, index) => {
                const block = document.createElement("div");
                block.classList.add("mcq-block");

                block.innerHTML = `
                    <div class="mcq-header">
                        <h4>Question <span class="q-index">${index + 1}</span></h4>
                        <button type="button" class="remove-btn" onclick="removeMcq(this)" title="Remove">&times;</button>
                    </div>

                    <label>Question</label>
                    <textarea name="questions[${index}][question]" rows="2">${q.question}</textarea>

                    <div class="options-grid">
                        <div><label>Option A</label><input type="text" name="questions[${index}][option_a]" value="${q.option_a}"></div>
                        <div><label>Option B</label><input type="text" name="questions[${index}][option_b]" value="${q.option_b}"></div>
                        <div><label>Option C</label><input type="text" name="questions[${index}][option_c]" value="${q.option_c}"></div>
                        <div><label>Option D</label><input type="text" name="questions[${index}][option_d]" value="${q.option_d}"></div>
                    </div>

                    <label>Correct Option</label>
                    <select name="questions[${index}][correct_option]">
                        <option value="A" ${q.correct_option === "A" ? "selected" : ""}>A</option>
                        <option value="B" ${q.correct_option === "B" ? "selected" : ""}>B</option>
                        <option value="C" ${q.correct_option === "C" ? "selected" : ""}>C</option>
                        <option value="D" ${q.correct_option === "D" ? "selected" : ""}>D</option>
                    </select>
                `;

                mcqGroup.appendChild(block);
            });

            // Open modal
            mcqModal.style.display = 'flex';
        })
        .catch(err => console.error(err));
}

    const mcqModal = document.getElementById('mcqModal');
    const openMcqBtn = document.getElementById('openAddMcq');
    const closeMcqBtn = document.getElementById('closeMcqModal');
    const form = document.getElementById('mcqForm');
    let currentMessage = null;

    // ✅ Single alert handler
    function showAlert(message) {
        if (currentMessage) return; // prevent multiple
        currentMessage = true;
        alert(message);
        setTimeout(() => currentMessage = null, 1000);
    }

    function resetModal() {
        form.reset();
        document.getElementById('mcq_id').value = '';
        const mcqGroup = document.getElementById('mcqGroup');
        mcqGroup.innerHTML = `
            <div class="mcq-block">
                <div class="mcq-header">
                    <h4>Question <span class="q-index">1</span></h4>
                    <button type="button" class="remove-btn" onclick="removeMcq(this)" title="Remove">&times;</button>
                </div>
                <label>Question</label>
                <textarea name="questions[0][question]" rows="2" required></textarea>
                <div class="options-grid">
                    <div><label>Option A</label><input type="text" name="questions[0][option_a]" required></div>
                    <div><label>Option B</label><input type="text" name="questions[0][option_b]" required></div>
                    <div><label>Option C</label><input type="text" name="questions[0][option_c]" required></div>
                    <div><label>Option D</label><input type="text" name="questions[0][option_d]" required></div>
                </div>
                <label>Correct Option</label>
                <select name="questions[0][correct_option]" required>
                    <option value="">Select Correct Option</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
        `;
    }

    openMcqBtn.onclick = () => {
        document.getElementById('modalTitle').textContent = "Add MCQs";
        document.getElementById('saveBtn').textContent = "💾 Save MCQs";
        resetModal();
        mcqModal.style.display = 'flex';
    };

    closeMcqBtn.onclick = () => mcqModal.style.display = 'none';
    window.onclick = (e) => { if (e.target === mcqModal) mcqModal.style.display = 'none'; };

    // Add more MCQ
    document.getElementById('addMoreMcq').addEventListener('click', () => {
        const mcqGroup = document.getElementById('mcqGroup');
        const newBlock = mcqGroup.firstElementChild.cloneNode(true);
        newBlock.querySelectorAll('textarea, input').forEach(el => el.value = '');
        newBlock.querySelectorAll('select').forEach(el => el.value = '');
        const count = mcqGroup.querySelectorAll('.mcq-block').length;
        newBlock.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${count}]`);
        });
        newBlock.querySelector('.q-index').textContent = count + 1;
        mcqGroup.appendChild(newBlock);
    });

    function removeMcq(btn) {
        const blocks = document.querySelectorAll('.mcq-block');
        if (blocks.length > 1) btn.closest('.mcq-block').remove();
        else showAlert("At least one question is required.");
    }

    // Save/Add MCQs
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const id = document.getElementById('mcq_id').value;
        const url = id
            ? `/hrms/training-assessment/mcq/update/${id}`
            : `{{ route('training.addMcq') }}`;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                showAlert(id ? "MCQ updated successfully!" : "MCQs added successfully!");
                mcqModal.style.display = 'none';
                resetModal();
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(result.message || "Something went wrong!");
            }
        } catch (error) {
            console.error(error);
            showAlert("Unexpected error. Check console.");
        }
    });

    // Delete MCQ
    async function deleteMcq(id) {
        if (!confirm('Are you sure you want to delete this MCQ?')) return;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        try {
            const response = await fetch(`/hrms/training-assessment/mcq/delete/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const result = await response.json();
            if (result.success) {
                showAlert('MCQ deleted successfully!');
                setTimeout(() => location.reload(), 1000);
            } else showAlert('Failed to delete MCQ.');
        } catch (error) {
            console.error(error);
            showAlert("Error deleting MCQ.");
        }
    }

    // Toggle status (one alert only)
    document.getElementById('mcqList').addEventListener('change', async (e) => {
        const select = e.target.closest('.status-select');
        if (!select) return;
        const id = select.dataset.id;
        const value = select.value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        try {
            const url = value === 'active'
                ? `/hrms/training-assessment/mcq/toggle/${id}`
                : `/hrms/training-assessment/mcq/status/${id}`;

            const response = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ status: value })
            });

            const result = await response.json();
            if (result.success) {
                document.querySelectorAll('.status-pill').forEach(el => {
                    el.textContent = 'Inactive';
                    el.classList.remove('active');
                    el.classList.add('inactive');
                });
                if (value === 'active') {
                    const pill = document.querySelector(`#status-${id} .status-pill`);
                    pill.textContent = 'Active';
                    pill.classList.remove('inactive');
                    pill.classList.add('active');
                }
                showAlert("Status updated successfully!");
            } else showAlert("Failed to update status.");
        } catch (error) {
            console.error(error);
            showAlert("Error updating status.");
        }
    });
    // ✅ Single alert handler (only one alert at a time)
    let alertActive = false;
    function showAlert(msg) {
        if (alertActive) return;
        alertActive = true;
        alert(msg);
        setTimeout(() => alertActive = false, 1000);
    }

    // ✅ Toggle Active/Inactive button click
    document.getElementById('mcqList').addEventListener('click', async (e) => {
        const btn = e.target.closest('.status-toggle-btn');
        if (!btn) return;

        const id = btn.dataset.id;
        const currentStatus = btn.dataset.status;
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        try {
            // If activating — ensure only one active assessment
            const url = newStatus === 'active'
                ? `/hrms/training-assessment/mcq/toggle/${id}`
                : `/hrms/training-assessment/mcq/status/${id}`;

            const response = await fetch(url, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            });

            const result = await response.json();

            if (result.success) {
                // Update all buttons if active chosen
                if (newStatus === 'active') {
                    document.querySelectorAll('.status-toggle-btn').forEach(el => {
                        el.textContent = 'Inactive';
                        el.dataset.status = 'inactive';
                        el.style.background = '#fee2e2';
                        el.style.color = '#b91c1c';
                    });
                }

                // Update this button’s style
                btn.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                btn.dataset.status = newStatus;
                btn.style.background = newStatus === 'active' ? '#d1fae5' : '#fee2e2';
                btn.style.color = newStatus === 'active' ? '#047857' : '#b91c1c';

                showAlert("Status updated successfully!");
            } else {
                showAlert(result.message || "Failed to update status.");
            }

        } catch (error) {
            console.error("Toggle error:", error);
            showAlert("Error updating status.");
        }
    });
</script>

</body>
</html>
