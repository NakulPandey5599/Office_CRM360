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

        .bulk-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: end;
        }

        .bulk-filter-item label {
            display: block;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .bulk-filter-item input[type="date"],
        .bulk-filter-item select {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 160px;
        }

        .bulk-custom-table th small {
            font-weight: normal;
            color: #666;
        }
        .bulk-custom-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Poppins', sans-serif;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

.bulk-custom-table thead tr:first-child th {
    background-color: #e2e8f0;
    font-weight: 600;
    font-size: 14px;
    color: #1e293b;
    text-align: center;
    border-bottom: 1px solid #cbd5e1;
    padding: 10px 6px;
}

.bulk-custom-table thead tr:nth-child(2) th {
    background-color: #2563eb;
    color: #fff;
    font-weight: 500;
    text-align: center;
    font-size: 13px;
    padding: 8px 6px;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
}

.bulk-custom-table tbody td {
    text-align: center;
    font-size: 13px;
    padding: 8px;
    border-bottom: 1px solid #f1f5f9;
}

.bulk-custom-table tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

.bulk-custom-table tbody tr:hover {
    background-color: #f1f5ff;
}

.bulk-custom-table select {
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 4px 6px;
    font-size: 13px;
    background: #fff;
    transition: all 0.2s;
}

.bulk-custom-table select:focus {
    border-color: #2563eb;
    background: #eff6ff;
    outline: none;
}

.table-responsive {
    overflow-x: auto;
}
/* ✅ Color-coded dropdowns */
.attendance-select {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 4px 6px;
    font-size: 13px;
    text-align: center;
    transition: all 0.2s ease;
}

.attendance-A {
    background-color: #fde2e2 !important;
    color: #b71c1c !important;
    font-weight: 600;
}

.attendance-P {
    background-color: #d4edda !important;
    color: #155724 !important;
    font-weight: 600;
}

.attendance-L {
    background-color: #fff3cd !important;
    color: #856404 !important;
    font-weight: 600;
}

    </style>
</head>

@include('hrms::partials.sidebar')

<body class="bulk-body">

    <div class="bulk-main-content">
        <div class="bulk-container">
<!-- ✅ Toast Notification -->
<div id="toastMessage" 
     style="position: fixed; 
            bottom: 20px; 
            right: 20px; 
            background: #4CAF50; 
            color: white; 
            padding: 10px 16px; 
            border-radius: 8px; 
            font-size: 14px; 
            display: none; 
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            z-index: 99999;">
</div>

            <div class="bulk-card">
                <h2>Bulk Attendance Adjustments</h2>

                @include('hrms::payroll.markAttendance')
                @include('hrms::payroll.leave_modal')

                {{-- ✅ FILTER FORM (Now From–To Range) --}}
                <form action="{{ route('bulk.attendance.filter') }}" method="GET" class="bulk-filters">
                    <div class="bulk-filter-item">
                        <label>From</label>
                        <input type="date" name="from_date" id="from_date"
                            value="{{ request('from_date') }}">
                    </div>

                    <div class="bulk-filter-item">
                        <label>To</label>
                        <input type="date" name="to_date" id="to_date"
                            value="{{ request('to_date') }}">
                    </div>

                    {{-- <div class="bulk-filter-item">
                        <label>Choose Branch</label>
                        <select id="bulk-branch" name="branch">
                            <option value="">Choose Branch</option>
                            <option value="Branch 1" {{ request('branch') == 'Branch 1' ? 'selected' : '' }}>Branch 1
                            </option>
                            <option value="Branch 2" {{ request('branch') == 'Branch 2' ? 'selected' : '' }}>Branch 2
                            </option>
                        </select>
                    </div> --}}

                    <button type="submit" id="bulk-btnSearch" class="bulk-btn btn-primary">
                        <i class="fa fa-magnifying-glass" style="margin-right:8px"></i>Search
                    </button>

                    <button type="button" id="bulk-btnExport" class="bulk-btn btn-outline">
                        <i class="fa fa-file-export" style="margin-right:8px"></i>Export
                    </button>
                </form>

                {{-- ✅ LEGEND --}}
                <div class="bulk-status-indicator" aria-label="Legend" style="margin-top:10px;">
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

            {{-- ✅ ATTENDANCE TABLE --}}
            <form action="{{ route('bulk.attendance.save') }}" method="POST" class="bulk-save-form">
                @csrf

                <div class="table-responsive mt-4">
    <table class="bulk-custom-table">
        <thead>
            <tr>
                <th colspan="2">Employees</th>
                <th colspan="2">Hierarchy</th>

                {{-- Dynamic date headers (top row) --}}
                @if (!empty($weekDays))
                    @foreach ($weekDays as $day)
                        <th>{{ \Carbon\Carbon::parse($day)->format('d-M') }}</th>
                    @endforeach
                @else
                    <th colspan="7" class="text-center">Select From–To Dates</th>
                @endif
            </tr>

            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Dept</th>
                <th>Designation</th>

                {{-- Dynamic weekday headers (bottom row) --}}
                @if (!empty($weekDays))
                    @foreach ($weekDays as $day)
                        <th>{{ \Carbon\Carbon::parse($day)->format('D') }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>

        <tbody id="bulk-attendanceTableBody">
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->job_profile ?? '-' }}</td>
                    <td>{{ trim($employee->designation, '[]"') }}</td>

                    @if (!empty($weekDays))
                        @foreach ($weekDays as $day)
                            <td>
                              <select name="attendance[{{ $employee->id }}][{{ $day }}]"
        class="attendance-select"
        data-emp-id="{{ $employee->id }}"
        data-emp-name="{{ $employee->first_name }} {{ $employee->last_name }}"
        data-dept="{{ $employee->job_profile ?? '-' }}"
        data-date="{{ $day }}">

    @php
        $val = $attendance[$employee->id][$day] ?? '';
    @endphp

    <option value=""   {{ $val === '' ? 'selected' : '' }}>--</option>
    <option value="A"  {{ $val === 'A' ? 'selected' : '' }}>A</option>
    <option value="P"  {{ $val === 'P' ? 'selected' : '' }}>P</option>
    <option value="L"  {{ $val === 'L' ? 'selected' : '' }}>L</option>
</select>
                            </td>
                        @endforeach
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No employees found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

            </form>

        </div>
    </div>

    {{-- ✅ JAVASCRIPT --}}
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

$(function () {

    /* ---------- Toast ---------- */
    function showToast(message, type = 'success') {
        const $toast = $('#toastMessage');
        $toast.text(message)
              .css('background', type === 'error' ? '#e74c3c' : '#4CAF50')
              .fadeIn(200);
        setTimeout(() => $toast.fadeOut(400), 2000);
    }

    /* ---------- Color helper ---------- */
    function applyStatusColor($select) {
        const val = $select.val();
        $select.removeClass('attendance-A attendance-P attendance-L');
        if (val === 'A') $select.addClass('attendance-A');
        else if (val === 'P') $select.addClass('attendance-P');
        else if (val === 'L') $select.addClass('attendance-L');
    }
    $('.attendance-select').each(function () { applyStatusColor($(this)); });

    /* ---------- 1. Dropdown change ---------- */
    $(document).on('change', '.attendance-select', function () {
        const $sel   = $(this);
        const status = $sel.val();
        const empId  = $sel.data('emp-id');
        const name   = $sel.data('emp-name');
        const dept   = $sel.data('dept');
        const date   = $sel.data('date');

        if (!status) return;

        if (status === 'A') {
            saveAttendanceAjax(empId, date, status, $sel);
        }
        else if (status === 'P') {
            saveAttendanceAjax(empId, date, status, $sel, function () {
                $('#employee_id').val(empId);
                $('#employee_name').val(name);
                $('#employee_department').val(dept);
                $('#attendance_date').val(date);
                $('#status').val('Present').trigger('change');
                $('#markAttendanceModal').css('display', 'flex');
            });
        }
        else if (status === 'L') {
            saveAttendanceAjax(empId, date, status, $sel, function () {
                $('#leave_employee_id').val(empId);
                $('#leave_employee_name').val(name);
                $('#leave_department').val(dept);
                $('#leave_date').val(date);
                $('#leave_type').val('').trigger('change');
                $('#leaveModal').css('display', 'flex');   // <-- same ID as in the view
            });
        }

        applyStatusColor($sel);
    });

    /* ---------- 2. AJAX save (common) ---------- */
    function saveAttendanceAjax(empId, date, status, $sel, callback = null) {
        $.ajax({
            url: "{{ route('attendance.live.save') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                employee_id: empId,
                date: date,
                status: status
            },
            beforeSend: () => $sel.css('opacity', '0.6'),
            success: function (res) {
                $sel.css('opacity', '1');
                if (res.success) {
                    showToast(`Attendance ${status} saved!`);
                    applyStatusColor($sel);
                    if (callback) callback();
                } else {
                    showToast(res.message || 'Failed to save.', 'error');
                }
            },
            error: function (xhr) {
                $sel.css('opacity', '1');
                console.error('AJAX error', xhr);
                showToast('Error saving attendance.', 'error');
            }
        });
    }

    /* ---------- 3. Present modal submit ---------- */
$(document).on('submit', '#markAttendanceForm', function (e) {
    e.preventDefault();
    const empId = $('#employee_id').val();
    const date  = $('#attendance_date').val();

    if (!empId || !date) {
        showToast('Missing data.', 'error');
        return;
    }

    const data = {
        _token: "{{ csrf_token() }}",
        employee_id: empId,
        date: date,
        status: $('#status').val().charAt(0), // Converts "Present" → "P"
        clock_in: $('#clock_in').val(),
        clock_out: $('#clock_out').val(),
        is_late: $('input[name="is_late"]:checked').val() || 0,
        is_half_day: $('input[name="is_half_day"]:checked').val() || 0,
        working_from: $('#working_from').val(),
        overwrite: $('#overwrite').is(':checked') ? 1 : 0
    };

    $.ajax({
        url: "{{ route('attendance.live.save') }}",
        type: "POST",
        data: data,
        beforeSend: () => $('#markAttendanceForm button[type="submit"]').prop('disabled', true).text('Saving...'),
        success: function (res) {
            showToast(res.message || 'Attendance updated!');
            $('#markAttendanceModal').hide();
            $('#markAttendanceForm button[type="submit"]').prop('disabled', false).text('Save Attendance');
            $('#markAttendanceForm')[0].reset();
        },
        error: function (xhr) {
            console.error(xhr);
            showToast('Error saving attendance (modal).', 'error');
            $('#markAttendanceForm button[type="submit"]').prop('disabled', false).text('Save Attendance');
        }
    });
});


    /* ---------- 4. Present modal close ---------- */
    function hidePresentModal() {
        $('#markAttendanceModal').hide();
        $('#markAttendanceForm')[0].reset();
        $('#employee_id, #employee_name, #employee_department, #attendance_date').val('');
    }
    $('#modal-close, #modal-cancel').on('click', hidePresentModal);

    /* ---------- 5. Leave form submit ---------- */
    $(document).on('submit', '#leaveForm', function (e) {
        e.preventDefault();

        const empId    = $('#leave_employee_id').val();
        const date     = $('#leave_date').val();
        const leaveType= $('#leave_type').val();
        const reason   = $('#leave_reason').val();

        if (!leaveType) { showToast('Select leave type.', 'error'); return; }

        $.ajax({
            url: "{{ route('attendance.live.save') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                employee_id: empId,
                date: date,
                status: 'L',
                leave_type: leaveType,
                reason: reason
            },
            beforeSend: () => $('#leaveForm button[type="submit"]').prop('disabled', true).text('Saving...'),
            success: function (res) {
                showToast(res.message || 'Leave applied!');
                $('#leaveModal').hide();
                $('#leaveForm')[0].reset();
                $('#leaveForm button[type="submit"]').prop('disabled', false).text('Submit Leave');
            },
            error: function (xhr) {
                console.error(xhr);
                showToast('Failed to apply leave.', 'error');
                $('#leaveForm button[type="submit"]').prop('disabled', false).text('Submit Leave');
            }
        });
    });

    /* ---------- 6. Close Leave modal ---------- */
    $(document).on('click', '#leave-modal-cancel, #leaveModal', function (e) {
        if (e.target === this || $(e.target).is('#leave-modal-cancel')) {
            $('#leaveModal').hide();
            $('#leaveForm')[0].reset();
        }
    });

    /* ---------- 7. Generic outside-click close ---------- */
    $(document).on('click', function (e) {
        // Present modal
        const $p = $('#markAttendanceModal');
        const $pc = $p.find('.modal-content');
        if ($p.is(':visible') && !$pc.is(e.target) && $pc.has(e.target).length === 0) {
            hidePresentModal();
        }

        // Leave modal
        const $l = $('#leaveModal');
        const $lc = $l.find('.modal-content');
        if ($l.is(':visible') && !$lc.is(e.target) && $lc.has(e.target).length === 0) {
            $l.hide();
            $('#leaveForm')[0].reset();
        }
    });

});   // <--- end of $(function(){ … })

$(document).ready(function () {

    // ---------- Disable Future Dates ----------
    const today = new Date().toISOString().split("T")[0];

    $("#from_date, #to_date").attr("max", today);

    // ---------- Ensure "To Date" is not less than "From Date" ----------
    $("#from_date").on("change", function () {
        const from = $(this).val();
        $("#to_date").attr("min", from);

        // If 'to_date' is already smaller, correct it
        if ($("#to_date").val() < from) {
            $("#to_date").val(from);
        }
    });

    // Optional: Ensure from_date doesn’t cross to_date  
    $("#to_date").on("change", function () {
        const to = $(this).val();
        $("#from_date").attr("max", to);
    });

});

</script>
</body>
</html>
