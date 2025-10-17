<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recruitment Dashboard</title>
    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #fff;
        color: #111827;
        display: flex;
      } /* Sidebar */
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
      } /* Main content */
      .main-content {
        margin-left: 240px;
        flex: 1;
        padding: 30px;
      } /* Header */
      .header-box {
        text-align: center;
        margin-bottom: 30px;
      }
      .header-box h1 {
        margin: 0 auto;
        font-size: 36px;
        font-weight: 900;
        color: #047edf;
        text-transform: uppercase;
      } /* Dashboard row */
      .dashboard {
        display: flex;
        gap: 25px;
        justify-content: center;
        flex-wrap: wrap;
      }
      .card {
        flex: 1 1 280px;
        padding: 25px;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        text-align: center;
      }
      .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
      }
      .card h2 {
        margin: 0 0 12px;
        font-size: 20px;
        font-weight: bold;
        color: #047edf;
      }
      .link {
        display: inline-block;
        margin-top: 8px;
        font-size: 15px;
        font-weight: bold;
        text-decoration: none;
        color: #2563eb;
      } /* Card base colors */
      .pink {
        background: linear-gradient(to bottom right, #ffe4e6, #fecdd3);
      }
      .blue {
        background: linear-gradient(to bottom right, #e0f2fe, #bae6fd);
      }
      .green {
        background: linear-gradient(to bottom right, #dcfce7, #bbf7d0);
      } /* Hover stronger colors */
      .pink:hover {
        background: linear-gradient(to bottom right, #fda4af, #fb7185);
      }
      .blue:hover {
        background: linear-gradient(to bottom right, #93c5fd, #60a5fa);
      }
      .green:hover {
        background: linear-gradient(to bottom right, #86efac, #4ade80);
      }
    </style>
  </head>
  <body>
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Recruitment</h2>
      <a href="index.html" class="active">Dashboard</a>
      <a href="{{ route('candidate.index') }}">Candidate Details</a>
      <a href="{{ route('interviews.index') }}">Interview Status</a>
      <a href="{{ route('final-selections.index') }}">Selections</a>
    </div>
    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header-box"><h1>Recruitment Process</h1></div>
      <!-- Dashboard -->
      <div class="dashboard">
        <div class="card pink" onclick="location.href='{{ route('candidate.create') }}'">
          <h2>➕ New Candidate</h2>
          <a class="link">Add Candidate</a>
        </div>
        <div class="card blue" onclick="location.href='{{ route('interviews.index') }}'">
          <h2>📄 Interview Status</h2>
          <a class="link">View Status</a>
        </div>
        <div class="card green" onclick="location.href='{{ route('final-selections.index') }}'">
          <h2>✅ Final Selections</h2>
          <a class="link">View Selections</a>
        </div>
         <div class="card green" onclick="window.location.href='{{ route('candidate.index') }}'">
            <h2>📋 All Candidates List</h2>
            <a class="link">View Candidates List</a>
        </div>
      </div>
    </div>
  </body>
</html>
