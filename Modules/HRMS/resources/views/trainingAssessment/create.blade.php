<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Training Module | HR Management</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --success: #d1fae5;
            --success-text: #047857;
            --danger: #fee2e2;
            --danger-text: #b91c1c;
            --warning: #fbbf24;
            --gray-100: #f9fafb;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #666;
            --text: #111827;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--gray-100);
            margin: 0;
            color: var(--text);
        }

        .main-content2 {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-module-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .add-module-btn:hover {
            background: var(--primary-dark);
        }

        .video-container {
            margin: 15px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .video-container video {
            width: 100%;
            display: block;
        }

        .module-details p {
            margin: 8px 0;
            font-size: 15px;
        }

        .status-btn {
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: 600;
            cursor: pointer;
            min-width: 80px;
        }

        .status-active {
            background: var(--success);
            color: var(--success-text);
        }

        .status-inactive {
            background: var(--danger);
            color: var(--danger-text);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--gray-200);
            text-align: left;
        }

        th {
            background: var(--primary);
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background: var(--gray-100);
        }

        .action-btn {
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            font-weight: 600;
            margin: 0 3px;
        }

        .edit-btn {
            background: var(--warning);
            color: white;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modern-modal {
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 95%;
            max-width: 600px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            position: relative;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray-600);
        }

        .close-btn:hover {
            color: #000;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 16px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 14px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .cancel-btn,
        .save-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .cancel-btn {
            background: var(--gray-200);
            color: #374151;
        }

        .save-btn {
            background: var(--primary);
            color: white;
        }
    </style>
</head>

<body>

    @include('hrms::partials.sidebar')

    <div class="main-content2">
        <div class="page-header">
            <h2>Training Module</h2>
            <button class="add-module-btn" id="openAddModule">
                <i class="fa fa-plus"></i> Add Module
            </button>
        </div>

        @if ($latestModule)
            <div class="video-container">
                <video id="trainingVideo" controls>
                    <source src="{{ $latestModule->video_path }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <div class="module-details">
                <p><strong>Module Description:</strong> {{ $latestModule->description }}</p>
                <p><strong>Duration:</strong> {{ $latestModule->duration ?? 'N/A' }}</p>
                <p><strong>Status:</strong>
                    <button
                        class="status-btn status-toggle-btn {{ $latestModule->is_active ? 'status-active' : 'status-inactive' }}"
                        data-id="{{ $latestModule->id }}"
                        data-status="{{ $latestModule->is_active ? 'active' : 'inactive' }}">
                        {{ $latestModule->is_active ? 'Active' : 'Inactive' }}
                    </button>
                </p>
            </div>
        @else
            <p style="margin-top:20px; color: #6b7280;">No training module uploaded yet.</p>
        @endif

        <!-- All Modules Table -->
        <h3 style="margin-top: 40px;">All Training Modules</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="moduleList">
                @forelse($allModules as $index => $module)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $module->title }}</td>
                        <td>{{ Str::limit($module->description, 40) }}</td>
                        <td>{{ $module->duration ?? 'N/A' }}</td>
                        <td>
                            <button
                                class="status-btn status-toggle-btn {{ $module->is_active ? 'status-active' : 'status-inactive' }}"
                                data-id="{{ $module->id }}"
                                data-status="{{ $module->is_active ? 'active' : 'inactive' }}">
                                {{ $module->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn edit-btn" onclick="editModule({{ $module->id }})"
                                title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" onclick="deleteModule({{ $module->id }})"
                                title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#6b7280; padding:20px;">No modules found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Modal -->
    <div id="addModuleModal" class="modal">
        <div class="modern-modal">
            <button type="button" class="close-btn" id="closeModal">×</button>
            <h2 id="modalTitle">Add Training Module</h2>

            <form id="addModuleForm" enctype="multipart/form-data" class="modal-form">
                @csrf
                <input type="hidden" name="module_id" id="module_id">

                <div class="form-group">
                    <label for="module_title">Title <span style="color:red;">*</span></label>
                    <input type="text" name="title" id="module_title" required placeholder="Enter module title">
                </div>

                <div class="form-group">
                    <label for="module_description">Description <span style="color:red;">*</span></label>
                    <textarea name="description" id="module_description" rows="3" required placeholder="Describe the module"></textarea>
                </div>

                <div class="form-group">
                    <label for="module_duration">Duration</label>
                    <input type="text" name="duration" id="module_duration" placeholder="e.g. 10 min">
                </div>

                <div class="form-group">
                    <label for="module_video">Video (MP4/WebM)</label>
                    <input type="file" name="video_file" id="module_video" accept="video/mp4,video/webm">
                </div>
                <div class="form-group">
    <label for="module_status">Status <span style="color:red;">*</span></label>
    <select name="is_active" id="module_status" required>
        <option value="0">Inactive</option>
        <option value="1">Active</option>
    </select>
</div>

                <div class="modal-actions">
                    <button type="button" id="cancelModal" class="cancel-btn">Cancel</button>
                    <button type="submit" class="save-btn">Save Module</button>
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

        /* ==============================================================
           1. GLOBAL ELEMENTS & HELPERS
           ============================================================== */
        const modal = document.getElementById('addModuleModal');
        const openBtn = document.getElementById('openAddModule');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelModal');
        const form = document.getElementById('addModuleForm');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let alertActive = false;
        const showAlert = (msg) => {
            if (alertActive) return;
            alertActive = true;
            alert(msg);
            setTimeout(() => alertActive = false, 800);
        };

        /* ==============================================================
           2. MODAL – OPEN / CLOSE
           ============================================================== */
        openBtn.addEventListener('click', () => {
            document.getElementById('modalTitle').textContent = 'Add Training Module';
            form.reset();
            document.getElementById('module_id').value = '';
            modal.style.display = 'flex';
        });

        const closeModal = () => {
            modal.style.display = 'none';
            form.reset();
        };
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        window.addEventListener('click', e => {
            if (e.target === modal) closeModal();
        });

        /* ==============================================================
           3. EDIT MODULE
           ============================================================== */
        window.editModule = async (id) => {
            try {
                const res = await fetch(`/hrms/training/get/${id}`);
                const data = await res.json();

                document.getElementById('modalTitle').textContent = 'Edit Training Module';
                document.getElementById('module_id').value = data.id;
                document.getElementById('module_title').value = data.title;
                document.getElementById('module_description').value = data.description;
                document.getElementById('module_duration').value = data.duration || '';
                document.getElementById('module_status').value = data.is_active ? 1 : 0;

                modal.style.display = 'flex';
            } catch {
                showAlert('Failed to load module data.');
            }
        };

        /* ==============================================================
           4. DELETE MODULE
           ============================================================== */
        window.deleteModule = async (id) => {
            if (!confirm('Are you sure you want to delete this module?')) return;

            try {
                const res = await fetch(`/hrms/training/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const result = await res.json();

                showAlert(result.success ? 'Module deleted!' : 'Delete failed.');
                if (result.success) setTimeout(() => location.reload(), 1000);
            } catch {
                showAlert('Error deleting module.');
            }
        };

        /* ==============================================================
           5. ADD / EDIT FORM SUBMIT
           ============================================================== */
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const fd = new FormData(form);
            const isEdit = !!fd.get('module_id');
            const url = isEdit ?
                `/hrms/training/update/${fd.get('module_id')}` :
                `{{ route('training.addModule') }}`;

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: fd
                });
                const result = await res.json();

                showAlert(result.success ? 'Module saved!' : 'Save failed.');
                if (result.success) setTimeout(() => location.reload(), 1000);
            } catch {
                showAlert('Error saving module.');
            }
        });

        /* ==============================================================
           6. STATUS TOGGLE – ONLY ONE ACTIVE MODULE
               (works for every .status-toggle-btn on the page)
           ============================================================== */
        document.addEventListener('click', async e => {
            const btn = e.target.closest('.status-toggle-btn');
            if (!btn) return;

            // -----------------------------------------------------------------
            // Prevent double-click while request is in progress
            // -----------------------------------------------------------------
            if (btn.disabled) return;
            btn.disabled = true;

            const moduleId = btn.dataset.id; // id of the clicked row
            const curStatus = btn.dataset.status; // "active" | "inactive"
            const willBeActive = curStatus !== 'active'; // true → we want to activate

            try {
                // -------------------------------------------------------------
                // 1. Call the toggle endpoint – it returns the *new* status
                // -------------------------------------------------------------
                const res = await fetch(`/hrms/training-module/toggle/${moduleId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: willBeActive ? 'active' : 'inactive'
                    })
                });

                const result = await res.json();
                if (!result.success) throw new Error(result.message || 'Toggle failed');

                // -------------------------------------------------------------
                // 2. UI UPDATE – ONLY ONE ACTIVE BUTTON
                // -------------------------------------------------------------
                const allButtons = document.querySelectorAll('.status-toggle-btn');

                // If we are activating a module → turn **all** others off
                if (willBeActive) {
                    allButtons.forEach(b => {
                        b.textContent = 'Inactive';
                        b.dataset.status = 'inactive';
                        b.classList.remove('status-active');
                        b.classList.add('status-inactive');
                    });
                }

                // Set the clicked button to the new state
                btn.textContent = willBeActive ? 'Active' : 'Inactive';
                btn.dataset.status = willBeActive ? 'active' : 'inactive';
                btn.classList.toggle('status-active', willBeActive);
                btn.classList.toggle('status-inactive', !willBeActive);

                // -------------------------------------------------------------
                // 3. Sync the “latest-module” block (video area) – it also has a button
                // -------------------------------------------------------------
                const latestBtn = document.querySelector('.module-details .status-toggle-btn');
                if (latestBtn && latestBtn.dataset.id == moduleId) {
                    latestBtn.textContent = btn.textContent;
                    latestBtn.dataset.status = btn.dataset.status;
                    latestBtn.classList.remove('status-active', 'status-inactive');
                    latestBtn.classList.add(willBeActive ? 'status-active' : 'status-inactive');
                }

                showAlert('Status updated!');

            } catch (err) {
                console.error(err);
                showAlert(err.message || 'Error updating status.');
            } finally {
                btn.disabled = false;
            }
        });
    </script>

</body>

</html>
