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
        .modal-content textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .modal-content button {
            margin-top: 15px;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .save-btn {
            background: #2563eb;
            color: white;
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

        .module-list {
            margin-top: 25px;
        }

        .module-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .module-card h4 {
            margin: 0 0 6px;
            color: #1f2937;
        }

        .module-card p {
            margin: 0;
            color: #4b5563;
        }
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
    <div class="steps">
      <span class="active-step">Step 1 of 2 (Video)</span>
      <span id="step2" class="disabled-step">Step 2 of 2 (MCQ)</span>
    </div>

    <video id="trainingVideo" controls>
      <source src="{{ $latestModule->video_path }}" type="video/mp4"/>
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

    <div id="congratsBox" class="congrats" style="display:none;">
      ✅ Congratulations! You’ve completed this training video. Now continue with your MCQ assessment.
    </div>
  @else
    <p style="margin-top: 20px;">No training module uploaded yet.</p>
  @endif
</div>

    </div>

    
    <div id="addModuleModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" id="closeModal">X</button>
            <h3>Add New Training Module</h3>
            <form id="addModuleForm" enctype="multipart/form-data">
                @csrf

                <label for="moduleTitle">Module Title</label>
                <input type="text" name="title" id="moduleTitle" required>

                <label for="moduleDesc">Description</label>
                <textarea name="description" id="moduleDesc" rows="3" required></textarea>

                <label for="moduleDuration">Duration</label>
                <input type="text" name="duration" id="moduleDuration" placeholder="e.g. 10 min">

                <label for="moduleStatus">Status</label>
                <select name="is_active" id="moduleStatus">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>

                <label for="moduleVideo">Upload Video</label>
                <input type="file" name="video_file" id="moduleVideo" accept="video/mp4,video/webm" required>

                <button type="submit" class="save-btn">Save Module</button>
            </form>

        </div>
    </div> 

    <script>
      function toggleMenu(header){
        const submenu = header.nextElementSibling;
        const isOpen = submenu.classList.contains("open");
        document.querySelectorAll('.submenu').forEach(menu => menu.classList.remove('open'));
        document.querySelectorAll('.menu-section h3').forEach(menuHeader => menuHeader.classList.remove('active'));
        if(!isOpen){ submenu.classList.add("open"); header.classList.add("active"); }
      }
      function toggleDropdown(trigger){
        const container = trigger.nextElementSibling;
        const isOpen = container.classList.contains("open");
        trigger.parentElement.parentElement.querySelectorAll(".dropdown-container").forEach(drop => drop.classList.remove("open"));
        trigger.parentElement.parentElement.querySelectorAll(".dropdown-btn").forEach(btn => btn.classList.remove("active"));
        if(!isOpen){ container.classList.add("open"); trigger.classList.add("active"); }
      }
      
      const video = document.getElementById('trainingVideo');
      const congrats = document.getElementById('congratsBox');
      const step2 = document.getElementById('step2');

      step2.addEventListener('click', (e) => {
        if (step2.classList.contains('disabled-step')) {
          e.preventDefault();
          alert("Please complete Step 1 (Video) before accessing Step 2 (MCQ).");
        } else {
          window.location.href = "{{ route('trainingAssessment.mcq') }}"; 
        }
      });

      video.addEventListener('ended', () => {
        congrats.style.display = 'block';
        step2.classList.remove('disabled-step');
        step2.classList.add('active-step');
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
      });
        const modal = document.getElementById('addModuleModal');
        const openBtn = document.getElementById('openAddModule');
        const closeBtn = document.getElementById('closeModal');
        const addForm = document.getElementById('addModuleForm');
        const moduleList = document.getElementById('moduleList');

        openBtn.onclick = () => modal.style.display = 'flex';
        closeBtn.onclick = () => modal.style.display = 'none';
        window.onclick = (e) => {
            if (e.target === modal) modal.style.display = 'none';
        }

        // AJAX upload with video file
        addForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(addForm);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const response = await fetch("{{ route('training.addModule') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                const card = document.createElement('div');
                card.classList.add('module-card');
                card.innerHTML = `
    <h4>${result.module.title}</h4>
    <p>${result.module.description}</p>
    <p><strong>Duration:</strong> ${result.module.duration}</p>
    <p><strong>Status:</strong> ${result.module.is_active ? 'Active' : 'Inactive'}</p>
    <video width="100%" controls style="margin-top:10px; border-radius:8px;">
      <source src="${result.module.video_path}" type="video/mp4">
    </video>
  `;
                moduleList.innerHTML = ''; // clear previous module
                moduleList.appendChild(card); // show only the new one

                addForm.reset();
                modal.style.display = 'none';
            }

        });
    </script>
</body>

</html>
