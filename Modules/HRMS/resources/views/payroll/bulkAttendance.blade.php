<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Bulk Attendance Adjustment</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        .attendance-select:focus {
            background-color: #e3f2fd !important;
            outline: 2px solid #2196f3;
        }
    </style>
</head>
 @include('hrms::partials.sidebar')
<body class="bulk-body">

    <div class="bulk-main-content">
        <div class="bulk-container">

            <div class="bulk-card">
                <h2>Bulk Attendance Adjustments</h2>

                @include('hrms::payroll.markAttendance')

                {{-- ✅ FILTER FORM --}}
                <form action="{{ route('bulk.attendance.filter') }}" method="GET" class="bulk-filters">
                    <div class="bulk-filter-item">
                        <label>Month</label>
                        <select name="month" id="bulk-month">
                            <option value="">Choose Month</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
{{ request('month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bulk-filter-item">
                        <label>Year</label>
                        <select name="year" id="bulk-year">
                            @foreach (range(2023, 2027) as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bulk-filter-item">
                        <label>Day</label>
                        <select name="day" id="bulk-day">
                            <option value="">Choose Day</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}"
                                    {{ request('day') == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endfor
                        </select>
                    </div>


                    <div class="bulk-filter-item">
                        <label>Choose Branch</label>
                        <select id="bulk-branch" name="branch">
                            <option value="">Choose Branch</option>
                            <option value="Branch 1" {{ request('branch') == 'Branch 1' ? 'selected' : '' }}>Branch 1
                            </option>
                            <option value="Branch 2" {{ request('branch') == 'Branch 2' ? 'selected' : '' }}>Branch 2
                            </option>
                        </select>
                    </div>

                    <button type="submit" id="bulk-btnSearch" class="bulk-btn btn-primary">
                        <i class="fa fa-magnifying-glass" style="margin-right:8px"></i>Search
                    </button>

                    <button type="button" id="bulk-btnExport" class="bulk-btn btn-outline">
                        <i class="fa fa-file-export" style="margin-right:8px"></i>Export
                    </button>
                </form>

                {{-- ✅ LEGEND --}}
                <div class="bulk-status-indicator" aria-label="Legend">
                    <div class="bulk-status-item">
                        <span class="bulk-status-color status-present"></span> Present (P)
                    </div>
                    <div class="bulk-status-item">
                        <span class="bulk-status-color status-absent"></span> Absent (A)
                    </div>
                    <div class="bulk-status-item">
                        <span class="bulk-status-color status-leave"></span> Leave (L)
                    </div>
                </div>
            </div>

            {{-- ✅ SAVE FORM --}}
            <form action="{{ route('bulk.attendance.save') }}" method="POST" class="bulk-save-form">
                @csrf

                <table class="bulk-custom-table">
                    <thead>
                        <tr>
                            <th>EMPID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>

                            {{-- Dynamic date headers --}}
                            @if (!empty($weekDays))
                                @foreach ($weekDays as $day)
                                    <th>{{ date('d M', strtotime($day)) }}
                                        <br><small>{{ date('D', strtotime($day)) }}</small>
                                    </th>
                                @endforeach
                            @else
                                @for ($i = 0; $i < 7; $i++)
                                    <th>Day {{ $i + 1 }}</th>
                                @endfor
                            @endif
                        </tr>
                    </thead>

                    <tbody id="bulk-attendanceTableBody">
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td>{{ $employee->job_profile }}</td>
                                <td>{{ $employee->designation }}</td>

                                @if (!empty($weekDays))
                                    @foreach ($weekDays as $day)
                                        {{-- inside the @foreach ($weekDays as $day) loop --}}
                                        <td>
                                            <select name="attendance[{{ $employee->id }}][{{ $day }}]"
                                                class="form-select attendance-select" data-emp-id="{{ $employee->id }}"
                                                data-emp-name="{{ $employee->first_name }} {{ $employee->last_name }}"
                                                data-dept="{{ $employee->job_profile ?? '' }}"
                                                data-date="{{ $day }}"
                                                data-original="{{ $attendance[$employee->id][$day] ?? 'A' }}">
                                                <option value="P"
                                                    {{ ($attendance[$employee->id][$day] ?? 'A') === 'P' ? 'selected' : '' }}>
                                                    P</option>
                                                <option value="A"
                                                    {{ ($attendance[$employee->id][$day] ?? 'A') === 'A' ? 'selected' : '' }}>
                                                    A</option>
                                                <option value="L"
                                                    {{ ($attendance[$employee->id][$day] ?? 'A') === 'L' ? 'selected' : '' }}>
                                                    L</option>
                                            </select>
                                        </td>
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < 7; $i++)
                                        <td>
                                            <select class="form-select">
                                                <option value="P">P</option>
                                                <option value="A" selected>A</option>
                                                <option value="L">L</option>
                                            </select>
                                        </td>
                                    @endfor
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" style="text-align:center;">No employees found for the selected
                                    filters</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- <button type="submit" id="bulk-btnSave" class="bulk-btn btn-outline" style="margin-top:20px;">
                    <i class="fa fa-save" style="margin-right:8px"></i>Save Changes
                </button> --}}
            </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function() {
            // -------------------------------------------------
            // 1. Open modal when a status is changed
            // -------------------------------------------------
            $(document).on('change', '.attendance-select', function() {
                const $sel = $(this);
                const status = $sel.val(); // P / A / L
                const empId = $sel.data('emp-id');
                const name = $sel.data('emp-name');
                const dept = $sel.data('dept');
                const date = $sel.data('date');

                // ---- OPTIONAL: open only when you pick "P" ----
                // if (status !== 'P') return;   // <-- remove this line if you want A/L too

                // ---- OPTIONAL: open only the *first* change (not on every click) ----
                // if ($sel.data('opened')) return;
                // $sel.data('opened', true);

                // ---- Fill the modal fields ---------------------------------
                $('#employee_id').val(empId);
                $('#employee_name').val(name);
                $('#employee_department').val(dept);
                $('#attendance_date').val(date);

                // Map P/A/L → Present/Absent/Leave
                const map = {
                    P: 'Present',
                    A: 'Absent',
                    L: 'Leave'
                };
                $('#status').val(map[status]).trigger(
                'change'); // trigger the disable-logic you already have

                // ---- Show the modal -----------------------------------------
                $('#markAttendanceModal').css('display', 'flex');
            });

            // -------------------------------------------------
            // 2. Keep your existing “disable fields when Absent/Leave”
            // -------------------------------------------------
            $('#status').on('change', function() {
                const status = $(this).val();
                const inactive = (status === 'Absent' || status === 'Leave');

                const $clock = $('#clock_in, #clock_out');
                const $late = $('input[name="is_late"]');
                const $half = $('input[name="is_half_day"]');
                const $wf = $('#working_from');

                if (inactive) {
                    $clock.val('--:--').prop('disabled', true);
                    $late.prop('checked', false).prop('disabled', true);
                    $half.prop('checked', false).prop('disabled', true);
                    $wf.val('').prop('disabled', true);
                } else {
                    $clock.prop('disabled', false).val('');
                    $late.filter('[value="0"]').prop('checked', true).prop('disabled', false);
                    $half.filter('[value="0"]').prop('checked', true).prop('disabled', false);
                    $wf.prop('disabled', false).val('Office');
                }
            });

            // -------------------------------------------------
            // 3. Close / Reset modal (you already have this – just make sure it runs)
            // -------------------------------------------------
            function hideModal() {
                $('#markAttendanceModal').hide();
                $('#markAttendanceForm')[0].reset();
                $('#searchResults').empty();
                $('#employee_id, #employee_name, #employee_department').val('');
                $('#form-errors').empty();
            }
            $('#modal-close, #modal-cancel').on('click', hideModal);
        });
    </script>
</body>

</html>
