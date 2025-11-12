<div id="leaveModal" class="modal" style="display:none; justify-content:center; align-items:center; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:9999;">
    <div class="modal-content" style="background:#fff; padding:20px; border-radius:8px; width:420px;">
        <h3 style="margin-top:0;">Apply Leave</h3>
        <form id="leaveForm">
            @csrf
            <input type="hidden" id="leave_employee_id">
            <input type="hidden" id="leave_date">

            <div style="margin-bottom:12px;">
                <label>Employee</label>
                <input type="text" id="leave_employee_name" class="form-control" disabled>
            </div>

            <div style="margin-bottom:12px;">
                <label>Department</label>
                <input type="text" id="leave_department" class="form-control" disabled>
            </div>

            <div style="margin-bottom:12px;">
                <label>Leave Type <span style="color:red;">*</span></label>
                <select id="leave_type" class="form-control" required>
    <option value="">-- Select --</option>
    <option value="paid leave">Paid Leave</option>
    <option value="unpaid leave">Unpaid Leave</option>
</select>

            </div>

            <div style="margin-bottom:12px;">
                <label>Reason (optional)</label>
                <textarea id="leave_reason" class="form-control" rows="2"></textarea>
            </div>

            <div style="text-align:right;">
                <button type="submit" class="btn btn-primary">Submit Leave</button>
                <button type="button" id="leave-modal-cancel" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>