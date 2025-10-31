<!-- File: resources/views/hrms/attendance/bulk_attendance_mark_form.blade.php -->
<!-- Purpose: Modal form to mark employee attendance (manual entry) -->

<style>
/* 🔍 Search Section (Same as Offer Letter Page) */
.search-section34 {
    background: #fff;
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.search-bar34 {
    display: flex;
    gap: 10px;
    align-items: center;
    position: relative;
}

.search-bar34 input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.search-bar34 input:focus {
    border-color: #007bff;
    outline: none;
}

.search-bar34 button {
    background: #dc3545;
    border: none;
    color: #fff;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.search-bar34 button:hover {
    background: #c82333;
}

/* 🔽 Search results box */
#searchResults {
    position: absolute;
    top: 42px;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    z-index: 999;
    max-height: 250px;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

#searchResults div {
    padding: 10px;
    border-bottom: 1px solid #f1f1f1;
    cursor: pointer;
    transition: background 0.2s;
}

#searchResults div:hover {
    background: #f8f9fa;
}

#searchResults div:last-child {
    border-bottom: none;
}

.search-item strong {
    display: block;
    color: #333;
    font-size: 14px;
}

.search-item small {
    color: #666;
    font-size: 12px;
}
</style>

<!-- + Mark Attendance Button -->
<button id="btn-mark-attendance" class="bulk-btn btn-primary" type="button" style="margin:10px 0;">
    <i class="fa fa-plus" style="margin-right:8px"></i>+ Mark Attendance
</button>

<!-- Modal -->
<div id="markAttendanceModal" class="modal" 
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); 
            align-items:center; justify-content:center; z-index:9999;">
    <div class="modal-content" 
         style="width:720px; max-width:95%; background:#fff; border-radius:8px; 
                padding:20px; box-shadow:0 6px 24px rgba(0,0,0,0.2);">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <h3 style="margin:0;">Mark Attendance</h3>
            <button id="modal-close" type="button" style="background:none; border:none; font-size:18px;">&times;</button>
        </div>

        <form id="markAttendanceForm" method="POST" action="{{ route('attendance.mark.store') }}">
            @csrf

            <!-- Search Employee -->
            <div class="search-bar34">
                <input type="text" id="searchInput" placeholder="Search by name or employee ID...">
                <button type="button" id="clearSearch"><i class="fas fa-times"></i></button>
                <div id="searchResults"></div>
            </div>

            <input type="hidden" name="employee_id" id="employee_id">

            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:12px;">
                <div style="flex:1; min-width:200px;">
                    <label>Name</label>
                    <input id="employee_name" name="employee_name" readonly class="form-input" />
                </div>
                <div style="flex:1; min-width:160px;">
                    <label>Department</label>
                    <input id="employee_department" name="employee_department" readonly class="form-input" />
                </div>
                <div style="flex:1; min-width:160px;">
                    <label>Date</label>
                    <input type="date" id="attendance_date" name="date" 
                           value="{{ date('Y-m-d') }}" class="form-input" required />
                </div>
            </div>

<div style="flex:1; min-width:160px;">
    <label>Status</label>
    <select id="status" name="status" class="form-select" required>
        <option value="">-- Select Status --</option>
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Leave">Leave</option>
        
    </select>
</div>

            <div style="display:flex; gap:12px; margin-top:12px; flex-wrap:wrap;">
                <div style="flex:1; min-width:150px;">
                    <label>Clock In</label>
                    <input type="time" id="clock_in" name="clock_in" class="form-input" required />
                </div>
                <div style="flex:1; min-width:150px;">
                    <label>Clock Out</label>
                    <input type="time" id="clock_out" name="clock_out" class="form-input" required />
                </div>
                <div style="flex:1; min-width:140px;">
                    <label>Late</label>
                    <div>
                        <label><input type="radio" name="is_late" value="1"> Yes</label>
                        <label style="margin-left:8px;"><input type="radio" name="is_late" value="0" checked> No</label>
                    </div>
                </div>
                <div style="flex:1; min-width:140px;">
                    <label>Half Day</label>
                    <div>
                        <label><input type="radio" name="is_half_day" value="1"> Yes</label>
                        <label style="margin-left:8px;"><input type="radio" name="is_half_day" value="0" checked> No</label>
                    </div>
                </div>
                <div style="flex:1; min-width:160px;">
                    <label>Working From</label>
                    <select id="working_from" name="working_from" class="form-select">
                        <option value="Office">Office</option>
                        <option value="Home">Home</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:12px;">
                <label>
                    <input type="checkbox" id="overwrite" name="overwrite" value="1">
                    Attendance Overwrite (delete existing record and create new)
                </label>
            </div>

            <div id="form-errors" style="color:#b00020; margin-top:8px;"></div>

            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:16px;">
                <button type="button" id="modal-cancel" class="bulk-btn btn-outline">Cancel</button>
                <button type="submit" class="bulk-btn btn-primary">Save Attendance</button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
(function () {
    const modal = $('#markAttendanceModal');
    const openBtn = $('#btn-mark-attendance');
    const closeBtn = $('#modal-close');
    const cancelBtn = $('#modal-cancel');
    const errorsDiv = $('#form-errors');
    const form = $('#markAttendanceForm');

    openBtn.on('click', () => modal.css('display', 'flex'));
    closeBtn.on('click', hideModal);    
    cancelBtn.on('click', hideModal);

    function hideModal() {
        modal.hide();
        form[0].reset();
        $('#searchResults').html('');
        $('#employee_id').val('');
        $('#employee_name').val('');
        $('#employee_department').val('');
        errorsDiv.text('');
    }
     
     // 🔄 Auto-disable inputs when status = Absent / Leave
$('#status').on('change', function() {
    const status = $(this).val();
    const isInactive = (status === 'Absent' || status === 'Leave');

    // Target all related fields
    const fields = ['#clock_in', '#clock_out', 'input[name="is_late"]', 'input[name="is_half_day"]', '#working_from'];

    if (isInactive) {
        // Disable and set "N/A"
        $('#clock_in, #clock_out').val('--:--').prop('disabled', true);
        $('input[name="is_late"]').prop('checked', false).prop('disabled', true);
        $('input[name="is_half_day"]').prop('checked', false).prop('disabled', true);
        $('#working_from').val('').prop('disabled', true);
    } else {
        // Enable and reset
        $('#clock_in, #clock_out').prop('disabled', false).val('');
        $('input[name="is_late"][value="0"]').prop('checked', true).prop('disabled', false);
        $('input[name="is_half_day"][value="0"]').prop('checked', true).prop('disabled', false);
        $('#working_from').prop('disabled', false).val('Office');
    }
});

    // 📨 Submit Attendance
    form.on('submit', function (e) {
        e.preventDefault();
        errorsDiv.text('');

        if (!$('#employee_id').val()) {
            errorsDiv.text('Please select an employee.');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (res) {
                alert(res.success || 'Attendance saved successfully!');
                hideModal();
                location.reload();
            },
            error: function (xhr) {
                if (xhr.responseJSON?.errors) {
                    errorsDiv.html(Object.values(xhr.responseJSON.errors).map(e => `<div>${e}</div>`).join(''));
                } else {
                    errorsDiv.text(xhr.responseJSON?.message || 'Error saving attendance.');
                }
            }
        });
    });
})();

// 🔍 Search (Same behavior as Offer Letter page)
$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        let query = $(this).val().trim();

        if (query.length < 2) {
            $('#searchResults').html('');
            return;
        }

        $.ajax({
            url: "{{ route('attendance.search') }}",
            method: 'GET',
            data: { query: query },
            success: function(data) {
                let resultsHtml = '';
                if (data.length > 0) {
                    data.forEach(emp => {
                        let fullName = emp.first_name && emp.last_name ? `${emp.first_name} ${emp.last_name}` : emp.name;
                        resultsHtml += `
                            <div class="search-item"
                                data-id="${emp.id}"
                                data-name="${fullName}"
                                data-dept="${emp.job_profile || 'N/A'}">
                                <strong>${fullName}</strong>
                                <small>${emp.job_profile || ''}</small>
                            </div>
                        `;
                    });
                } else {
                    resultsHtml = '<div>No results found.</div>';
                }
                $('#searchResults').html(resultsHtml);
            }
        });
    });

    // 🧩 Select employee
    $(document).on('click', '.search-item', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const dept = $(this).data('dept');

        $('#employee_id').val(id);
        $('#employee_name').val(name);
        $('#employee_department').val(dept);

        $('#searchInput').val('');
        $('#searchResults').html('');
    });

    // ❌ Clear search
    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        $('#searchResults').html('');
    });
});
</script>
