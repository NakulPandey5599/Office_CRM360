<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Interview Status</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9fafb;
      color: #111827;
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: linear-gradient(to right, #90caf9, #047edf 99%) !important;
      color: #fff;
      min-height: 100vh;
      padding-top: 20px;
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar h2 {
      text-align: center;
      margin: 0 0 20px;
      font-size: 20px;
      font-weight: bold;
      color: #ffffff;
    }

    .sidebar a {
      display: block;
      padding: 14px 20px;
      color: #ffffff;
      text-decoration: none;
      transition: 0.3s;
      font-size: 15px;
      border-radius: 6px;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .sidebar .active {
      background: #ffffff !important;
      font-weight: bold;
      color: #047edf !important;
    }

    /* Main content */
    .main-content {
      margin-left: 240px;
      flex: 1;
      padding: 30px;
    }

    /* Header */
    .header {
      display: flex;
      align-items: center;
      background: linear-gradient(to right, #e9dff0, #f3eafa);
      padding: 15px 25px;
      font-size: 22px;
      font-weight: bold;
      color: #B39EB5;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .header .back {
      margin-right: 12px;
      font-size: 26px;
      cursor: pointer;
      color: #B39EB5;
      transition: transform 0.2s;
    }

    .header .back:hover {
      transform: scale(1.2);
    }

    .table-container {
      max-width: 1000px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 16px;
    }

    thead {
      background: linear-gradient(to right, #f3eafa, #e9dff0);
      color: #B39EB5;
      font-weight: bold;
    }

    th, td {
      padding: 14px;
      text-align: center;
      border: 1px solid #e5e7eb;
    }

    tbody tr:hover {
      background: #f3f4f6;
    }

    select {
      padding: 6px 10px;
      border-radius: 6px;
      border: 1px solid #d1d5db;
      background: #fff;
      color: #374151;
      cursor: pointer;
      font-size: 15px;
    }

    select:focus {
      outline: none;
      border-color: #047edf;
      box-shadow: 0 0 0 2px rgba(4, 126, 223, 0.2);
    }

    .status-msg {
      margin-top: 10px;
      text-align: center;
      color: green;
      font-weight: bold;
    }
    .status-msg {
  position: fixed;
  bottom: 25px;
  left: 50%;
  transform: translateX(-50%);
  background: #10b981; /* default green */
  color: white;
  padding: 12px 28px;
  border-radius: 50px;
  font-weight: 500;
  font-size: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.4s ease, transform 0.4s ease, background 0.3s ease;
  z-index: 9999;
  display: none;
}

.status-msg.show {
  opacity: 1;
  transform: translateX(-50%) translateY(-10px);
}

.status-msg.success {
  background: linear-gradient(135deg, #16a34a, #22c55e);
}

.status-msg.error {
  background: linear-gradient(135deg, #dc2626, #ef4444);
}

  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Recruitment</h2>
    <a href="{{ route('recruitment.index') }}">Dashboard</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <span class="back" onclick="history.back()">&#8592;</span>
      Interview Status
    </div>
<div id="status-msg" class="status-msg"></div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>S. No.</th>
            <th>Candidate</th>
            <th>Job Profile</th>
            <th>Date</th>
            <th>Mode</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($candidates as $index => $candidate)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $candidate->full_name }}</td>
            <td>{{ $candidate->job_profile }}</td>
            <td>{{ $candidate->interview_time }}</td>
            <td>{{ $candidate->interview_mode }}</td>
            <td>
              <select class="status-dropdown" data-id="{{ $candidate->id }}">
                <option value="Scheduled" {{ $candidate->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="In Progress" {{ $candidate->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ $candidate->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Rejected" {{ $candidate->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
              </select>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


<script>
  // Toast styling logic
  const showToast = (message, type = 'success') => {
    const toast = document.getElementById('status-msg');
    toast.textContent = message;

    // Reset state
    toast.className = 'status-msg';
    toast.style.display = 'block';

    // Add color based on type
    if (type === 'success') toast.classList.add('success');
    else toast.classList.add('error');

    // Trigger fade-in animation
    setTimeout(() => toast.classList.add('show'), 50);

    // Hide after 2.5 seconds
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => (toast.style.display = 'none'), 500);
    }, 2500);
  };

  // Attach AJAX handler
  document.querySelectorAll('.status-dropdown').forEach(dropdown => {
    dropdown.addEventListener('change', function () {
      const candidateId = this.getAttribute('data-id');
      const newStatus = this.value;
      const updateUrl = `{{ url('/hrms/interview/update') }}/${candidateId}`;

      fetch(updateUrl, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
      })
      .then(response => response.json())
      .then(data => showToast(data.message, 'success'))
      .catch(() => showToast('Error updating status!', 'error'));
    });
  });
</script>


</body>
</html>
