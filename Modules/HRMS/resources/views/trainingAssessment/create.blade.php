<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Training Module | HR Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .add-module-btn {
      background: #2563eb;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 15px;
      cursor: pointer;
      margin-bottom: 15px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: background 0.3s;
    }

    .add-module-btn:hover {
      background: #1d4ed8;
    }

    .add-mcq-btn {
      background: #10b981;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 15px;
      cursor: pointer;
      margin-top: 10px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: background 0.3s;
    }

    .add-mcq-btn:hover {
      background: #059669;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      width: 400px;
      max-width: 90%;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    .modal-content h3 {
      margin-top: 0;
      color: #111827;
    }

    .modal-content label {
      font-weight: bold;
      display: block;
      margin: 10px 0 5px;
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .save-btn {
      background: #2563eb;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .close-btn {
      background: #9ca3af;
      color: white;
      position: absolute;
      top: 10px;
      right: 10px;
      border: none;
      padding: 5px 8px;
      border-radius: 4px;
      cursor: pointer;
    }

    .mcq-section {
      background: #f9fafb;
      border-radius: 10px;
      padding: 20px;
      margin-top: 30px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .mcq-section h3 {
      margin-top: 0;
      color: #1f2937;
    }

  .modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;
  }
  .modal-content {
    background: #fff;
    padding: 20px 25px;
    border-radius: 12px;
    width: 95%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .close-btn {
    position: absolute;
    top: 12px;
    right: 15px;
    background: transparent;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
  }
  h2 { margin-bottom: 15px; color: #333; }
  .mcq-block {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    background: #fafafa;
  }
  .mcq-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .remove-btn {
    border: none;
    background: #ffdddd;
    color: #a00;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    cursor: pointer;
  }
  label { display: block; margin-top: 8px; font-weight: 600; }
  textarea, input, select {
    width: 100%;
    padding: 7px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-top: 3px;
  }
  .options-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }
  .btn-group {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
  }
  .add-btn, .save-btn {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
  }
  .add-btn { background: #e0f7ff; color: #0077b6; }
  .save-btn { background: #0077b6; color: white; }



  </style>
</head>

<body>
  @include('hrms::partials.sidebar')

  <div class="main-content2">
    <div class="top-bar">
      <div>Training Module</div>
      <div>Admin <button class="logout-btn">Logout</button></div>
    </div>

    <div class="training-container">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>
          @if($latestModule)
            Training Module: {{ $latestModule->title }}
          @else
            No Training Module Available
          @endif
        </h2>

        <button class="add-module-btn" id="openAddModule">
          <i class="fa fa-plus"></i> Add Module
        </button>
      </div>

      @if($latestModule)
        <video id="trainingVideo" controls>
          <source src="{{ $latestModule->video_path }}" type="video/mp4" />
          Your browser does not support the video tag.
        </video>

        <div class="module-details">
          <div class="module-box">
            <strong>Module Description</strong>
            <p>{{ $latestModule->description }}</p>
          </div>
          <div class="module-box">
            <strong>Duration</strong>
            <p>{{ $latestModule->duration ?? 'N/A' }}</p>
          </div>
          <div class="module-box">
            <strong>Status</strong>
            <p>{{ $latestModule->is_active ? 'Active' : 'Inactive' }}</p>
          </div>
        </div>
      @else
        <p style="margin-top: 20px;">No training module uploaded yet.</p>
      @endif
    </div>

    <!-- ✅ Separate MCQ Section -->
    <div class="mcq-section">
      <h3>MCQ Section</h3>
      <p>Add or manage MCQs related to this training module.</p>
      <button class="add-mcq-btn" id="openAddMcq">
        <i class="fa fa-question-circle"></i> Add MCQ
      </button>
    </div>
  </div>

  <!-- Add Module Modal -->
  <div id="addModuleModal" class="modal">
    <div class="modal-content">
      <button class="close-btn" id="closeModal">X</button>
      <h3>Add New Training Module</h3>
      <form id="addModuleForm" enctype="multipart/form-data">
        @csrf

        <label>Module Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description" rows="3" required></textarea>

        <label>Duration</label>
        <input type="text" name="duration" placeholder="e.g. 10 min">

        <label>Status</label>
        <select name="is_active">
          <option value="1" selected>Active</option>
          <option value="0">Inactive</option>
        </select>

        <label>Upload Video</label>
        <input type="file" name="video_file" accept="video/mp4,video/webm" required>

        <button type="submit" class="save-btn">Save Module</button>
      </form>
    </div>
  </div>

 <!-- ✅ Add Multiple MCQs Modal -->
<!-- ✅ Add Multiple MCQs Modal -->
<div id="addMcqModal" class="modal">
  <div class="modal-content">
    <button class="close-btn" id="closeMcqModal" aria-label="Close">&times;</button>
    <h2>Add Multiple MCQs</h2>

    <form id="addMcqForm">
      @csrf

      <!-- 🆕 Assessment Name Input -->
      
      <div id="mcqGroup" style="
    margin-bottom: 10px;
">
      <label>Assessment Name</label>
      <input type="text" name="assessment_name" placeholder="e.g. Communication Skills Test">
      </div>

      <div id="mcqGroup">
        <!-- Default MCQ Block -->
        <div class="mcq-block">
          <div class="mcq-header">
            <h4>Question <span class="q-index">1</span></h4>
            <button type="button" class="remove-btn" onclick="removeMcq(this)" title="Remove this question">&times;</button>
          </div>

          <label>Question</label>
          <textarea name="questions[0][question]" rows="2" required></textarea>

          <div class="options-grid">
            <div>
              <label>Option A</label>
              <input type="text" name="questions[0][option_a]" required>
            </div>
            <div>
              <label>Option B</label>
              <input type="text" name="questions[0][option_b]" required>
            </div>
            <div>
              <label>Option C</label>
              <input type="text" name="questions[0][option_c]" required>
            </div>
            <div>
              <label>Option D</label>
              <input type="text" name="questions[0][option_d]" required>
            </div>
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
        <button type="submit" class="save-btn">💾 Save All Questions</button>
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
  if(!isOpen){ submenu.classList.add("open"); header.classList.add("active"); }
}
function toggleDropdown(trigger) {
  const container = trigger.nextElementSibling;
  const isOpen = container.classList.contains("open");
  trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
  trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
  if(!isOpen){ container.classList.add("open"); trigger.classList.add("active"); }
}
    const moduleModal = document.getElementById('addModuleModal');
    const mcqModal = document.getElementById('addMcqModal');
    const openModuleBtn = document.getElementById('openAddModule');
    const closeModuleBtn = document.getElementById('closeModal');
    const openMcqBtn = document.getElementById('openAddMcq');
    const closeMcqBtn = document.getElementById('closeMcqModal');

    openModuleBtn.onclick = () => moduleModal.style.display = 'flex';
    closeModuleBtn.onclick = () => moduleModal.style.display = 'none';
    openMcqBtn.onclick = () => mcqModal.style.display = 'flex';
    closeMcqBtn.onclick = () => mcqModal.style.display = 'none';

    window.onclick = (e) => {
      if (e.target === moduleModal) moduleModal.style.display = 'none';
      if (e.target === mcqModal) mcqModal.style.display = 'none';
    }

    // Upload module logic
    document.getElementById('addModuleForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

      const response = await fetch("{{ route('training.addModule') }}", {
        method: "POST",
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
      });
      const result = await response.json();
      if (result.success) {
        alert("Module uploaded successfully!");
        location.reload();
      }
    });

    // Add MCQ logic
    document.getElementById('addMcqForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

      const response = await fetch("{{ route('training.addMcq') }}", {
        method: "POST",
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        alert("MCQ added successfully!");
        mcqModal.style.display = 'none';
        e.target.reset();
      }
    });
     let mcqCount = 1;

  document.getElementById('addMoreMcq').addEventListener('click', () => {
    const mcqGroup = document.getElementById('mcqGroup');
    const newBlock = mcqGroup.firstElementChild.cloneNode(true);

    newBlock.querySelectorAll('textarea, input').forEach(el => el.value = '');
    newBlock.querySelectorAll('select').forEach(el => el.value = '');
    
    newBlock.querySelectorAll('[name]').forEach(el => {
      el.name = el.name.replace(/\[\d+\]/, `[${mcqCount}]`);
    });
    newBlock.querySelector('.q-index').textContent = mcqCount + 1;

    mcqGroup.appendChild(newBlock);
    mcqCount++;
  });

  function removeMcq(btn) {
    const mcqBlocks = document.querySelectorAll('.mcq-block');
    if (mcqBlocks.length > 1) {
      btn.closest('.mcq-block').remove();
    } else {
      alert("At least one question is required.");
    }
  }

  // Modal Logic (Optional)
  const modal = document.getElementById('addMcqModal');
  const closeModal = document.getElementById('closeMcqModal');
  closeModal.onclick = () => modal.style.display = 'none';
  window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };
  </script>
</body>
</html>
