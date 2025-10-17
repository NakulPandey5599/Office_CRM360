<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Candidate</th>
            <th>Job Profile</th>
            <th>Date</th>
            <th>Mode</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach($candidates as $candidate)
            <tr>
            <td>{{ $candidate->full_name }}</td>
            <td>{{ $candidate->job_profile }}</td>
            <td>{{ $candidate->interview_time }}</td>
            <td>{{ $candidate->interview_mode }}</td>
            <td>{{ $candidate->status }}</td>
            </tr>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
