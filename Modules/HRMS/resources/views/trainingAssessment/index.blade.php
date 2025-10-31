<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Training Module | HR Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <!-- Sidebar (same as joining.html) -->
     @include('hrms::partials.sidebar')


  <!-- Main Content (Training Module) -->
  <div class="main-content2">
    <div class="top-bar">
      <div>Training Module</div>
      <div>Admin <button class="logout-btn">Logout</button></div>
    </div>

    <div class="training-container">
      <h2>Training Module: Introduction to Company Culture</h2>
      <div class="steps">
        <span class="active-step">Step 1 of 2 (Video)</span>
        <span id="step2" class="disabled-step">Step 2 of 2 (MCQ)</span>
      </div>

      <video id="trainingVideo" controls>
        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"/>
        <source src="https://www.w3schools.com/html/movie.mp4" type="video/mp4"/>
        Your browser does not support the video tag.
      </video>

      <div class="module-details">
        <div class="module-box">
          <strong>Module Description</strong>
          <p>This module provides an overview of our company’s values, mission, and work environment.</p>
        </div>
        <div class="module-box">
          <strong>Duration</strong>
          <p>12 min</p>
        </div>
      </div>

      <div id="congratsBox" class="congrats">
        ✅ Congratulations! You’ve completed this training video. Now continue with your MCQ assessment.
      </div>
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
  </script>
</body>
</html>
