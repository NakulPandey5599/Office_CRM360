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

        .status-select,
        .selection-select {
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            font-size: 14px;
            color: #111827;
            cursor: pointer;
        }

        .update-btn {
            background: #4caf50;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        }

        .update-btn:hover {
            background: #43a047;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
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
                        <th>Update</th>
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
                                <a href="{{ $candidate->linkedin_profile }}" target="_blank"
                                    class="text-blue-600 underline">Url</a>
                            </td>
                            <td>{{ $candidate->job_summary }}</td>
                            <td>{{ $candidate->job_profile }}</td>
                            <td>{{ $candidate->interview_mode }}</td>
                            <td>{{ $candidate->interview_date }}</td>
                            <td>{{ $candidate->interview_time ?? '-' }}</td>

                            {{-- ✅ Status Dropdown (linked to DB interview_mode) --}}
                            <td>
                                <select name="status" class="status-select" data-id="{{ $candidate->id }}">
                                    <option value="" disabled {{ $candidate->status ? '' : 'selected' }}>Select
                                    </option>
                                    <option value="Scheduled"
                                        {{ $candidate->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="In Progress"
                                        {{ $candidate->status == 'In Progress' ? 'selected' : '' }}>In Progress
                                    </option>
                                    <option value="Completed"
                                        {{ $candidate->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Rejected" {{ $candidate->status == 'Rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                            </td>



                            {{-- ✅ Final Selection --}}
                            <td>
                                <select name="final_selection" class="selection-select" data-id="{{ $candidate->id }}">
                                    <option value="">Select</option>
                                    <option value="Selected"
                                        {{ $candidate->final_selection == 'Selected' ? 'selected' : '' }}>Selected
                                    </option>
                                    <option value="Not Selected"
                                        {{ $candidate->final_selection == 'Not Selected' ? 'selected' : '' }}>Not
                                        Selected</option>
                                    <option value="On Hold"
                                        {{ $candidate->final_selection == 'On Hold' ? 'selected' : '' }}>On Hold
                                    </option>
                                </select>
                            </td>

                            <td>{{ $candidate->notes ?? '-' }}</td>

                            <td>
                                @if ($candidate->resume)
                                    <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank"
                                        class="text-blue-600 underline">View Resume</a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <button type="button" class="update-btn"
                                    onclick="updateCandidate({{ $candidate->id }})">Update</button>
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
                            <td colspan="14" class="text-center">No candidates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-links">
            {{ $candidates->links() }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateCandidate(id) {
            const status = $(`select[name='status'][data-id='${id}']`).val();
            const final_selection = $(`select[name='final_selection'][data-id='${id}']`).val();

            if (!status || !final_selection) {
                alert("Please select both Status and Final Selection before updating.");
                return;
            }

            $.ajax({
                url: @json(route('candidate.update', ':id')).replace(':id', id),
                method: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status,
                    final_selection: final_selection
                },
                beforeSend: function() {
                    $(`#row-${id} .update-btn`).text('Updating...').prop('disabled', true);
                },
                success: function(response) {
                    alert('✅ Candidate updated successfully!');
                    $(`#row-${id} .update-btn`).text('Update').prop('disabled', false);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('❌ Something went wrong. Please try again.');
                    $(`#row-${id} .update-btn`).text('Update').prop('disabled', false);
                }
            });
        }
    </script>

</body>

</html>
