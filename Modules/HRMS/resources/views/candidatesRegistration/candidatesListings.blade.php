<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidates List</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9fafb;
      color: #111827;
      display: flex;
    }

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
    }

    .sidebar .active {
      background: #ffffff !important;
      font-weight: bold;
      color: #047edf !important;
    }

    .main-content {
      margin-left: 240px;
      flex: 1;
      padding: 30px;
    }

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
      overflow-x: auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

    th,
    td {
      padding: 14px;
      text-align: center;
      border: 1px solid #e5e7eb;
    }

    tbody tr:hover {
      background: #f3f4f6;
    }

    .red-btn {
      background: #e53935;
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 2px 6px rgba(229, 57, 53, 0.3);
    }

    .red-btn:hover {
      background: #c62828;
      transform: translateY(-2px);
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Recruitment</h2>
    <a href="{{ route('recruitment.index') }}">Dashboard</a>
  </div>

  <div class="main-content">
    <div class="header">
      <span class="back" onclick="history.back()">&#8592;</span>
      Candidates List
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>S.NO</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>LinkedIn</th>
            <th>Job Summary</th>
            <th>Job Profile</th>
            <th>Interview Mode</th>
            <th>Interview Date</th>
            <th>Interview Time</th>
            <th>Interview Status</th>
            <th>Final Selection</th>
            <th>Notes</th>
            <th>Resume</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @forelse($candidates as $candidate)
          <tr id="row-{{ $candidate->id }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $candidate->full_name }}</td>
            <td>{{ $candidate->email }}</td>
            <td>{{ $candidate->phone }}</td>
            <td>
              @if ($candidate->linkedin_profile)
              <a href="{{ $candidate->linkedin_profile }}" target="_blank" class="text-blue-600 underline">View</a>
              @else
              -
              @endif
            </td>
            <td>{{ $candidate->job_summary }}</td>
            <td>{{ $candidate->job_profile }}</td>
            <td>{{ $candidate->interview_mode ?? '-' }}</td>
            <td>{{ $candidate->interview_date ?? '-' }}</td>
            <td>{{ $candidate->interview_time ?? '-' }}</td>

            <!-- ✅ Display status as text -->
            <td>
              {{ $candidate->status ?? 'On Hold' }}
            </td>

            <!-- ✅ Display final selection as text -->
            <td>
              {{ $candidate->final_selection ?? 'On Hold' }}
            </td>

            <td>{{ $candidate->notes ?? '-' }}</td>

            <td>
              @if ($candidate->resume)
              <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank" class="text-blue-600 underline">View Resume</a>
              @else
              -
              @endif
            </td>

            <td>
              <form action="{{ route('candidate.destroy', $candidate->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="red-btn">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="15" class="text-center text-gray-500 italic">No candidates found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="pagination-links">
      {{ $candidates->links() }}
    </div>
  </div>
</body>

</html>
