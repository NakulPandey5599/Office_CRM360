<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pre-Joining Candidates | HRMS</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Inter", sans-serif;
      background: #f9fafb;
    }

    .main-content2 {
      margin-left: 240px;
      padding: 25px 50px 40px 60px;
      min-height: 100vh;
      box-sizing: border-box;
    }

    .top-bar {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      padding: 14px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      color: #047edf;
      margin-bottom: 25px;
      width: 97%;
      margin-left: auto;
      margin-right: auto;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .logout-btn {
      background: #e53935;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
      transition: 0.2s;
    }

    .logout-btn:hover {
      background: #c62828;
    }

    .table-container {
      background: #fff;
      border-radius: 6px;
      border: 1px solid #e5e7eb;
      width: 97%;
      margin-left: auto;
      margin-right: auto;
      overflow-x: auto;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
    }

    thead {
      background: #eef2ff;
      color: #374151;
      font-weight: 600;
    }

    th,
    td {
      padding: 12px;
      border-bottom: 1px solid #e5e7eb;
      text-align: center;
    }

    tbody tr:hover {
      background: #f3f4f6;
    }

    .view-btn {
      background: #047edf;
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
      transition: 0.2s;
    }

    .view-btn:hover {
      background: #035fc7;
    }

    .badge-fresher {
      background: #0d6efd;
      color: #fff;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
    }

    .badge-exp {
      background: #198754;
      color: #fff;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
    }

    .modal-body p {
      margin-bottom: 6px;
      font-size: 14px;
    }

    
  /* --- Professional Modal Styling --- */
  .modal-content {
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  }

  .modal-header {
    background: linear-gradient(135deg, #047edf, #035fc7);
    color: #fff;
    border-bottom: none;
  }

  .modal-title {
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  .info-section {
    background: #f9fafb;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 4px solid #047edf;
  }

  .info-section h6 {
    font-weight: 600;
    color: #035fc7;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .info-section p {
    margin: 3px 0;
    font-size: 14px;
    color: #333;
  }

  .info-section strong {
    color: #111827;
  }

  .info-divider {
    border-top: 1px dashed #ddd;
    margin: 12px 0;
  }

  .text-muted {
    color: #777 !important;
  }

  </style>
</head>

<body>
  @include('hrms::partials.sidebar')

  <div class="main-content2">
    <div class="top-bar">
      <div><i class="fa-solid fa-users"></i> Pre-Joining Candidates</div>
      <div>
        Admin
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>S.NO.</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Job Profile</th>
            <th>Experience Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($employees as $index => $emp)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ e($emp->first_name) }} {{ e($emp->last_name) }}</td>
              <td>{{ e($emp->email) }}</td>
              <td>{{ e($emp->phone) }}</td>
              <td>{{ e($emp->job_profile) }}</td>
              <td>
                @if ($emp->experience_type === 'Experienced')
                  <span class="badge-exp">Experienced</span>
                @else
                  <span class="badge-fresher">Fresher</span>
                @endif
              </td>
              <td>
<button class="view-btn" data-employee='{{ json_encode($emp, JSON_HEX_APOS | JSON_HEX_QUOT) }}'>
  View
</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted fst-italic py-3">No employees found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold" id="employeeModalLabel">Employee Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="modalContent"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

document.addEventListener('DOMContentLoaded', function () {
  const escapeHtml = (unsafe) => {
    if (unsafe === null || unsafe === undefined || unsafe === '') return 'N/A';
    return String(unsafe)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  };

  const safeParseArray = (data) => {
    if (!data || data === 'null' || data === 'undefined') return [];
    try {
      const parsed = JSON.parse(data);
      return Array.isArray(parsed) ? parsed : [];
    } catch {
      return [];
    }
  };

  document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      let emp = {};

      try {
        const decoded = this.dataset.employee
          .replace(/&quot;/g, '"')
          .replace(/&#039;/g, "'")
          .replace(/&lt;/g, "<")
          .replace(/&gt;/g, ">")
          .replace(/&amp;/g, "&");

        emp = JSON.parse(decoded);
      } catch (error) {
        console.error("Error parsing employee data:", error, this.dataset.employee);
        alert("Invalid employee data.");
        return;
      }

      const edu = safeParseArray(emp.highest_qualification);
      const uni = safeParseArray(emp.highest_university);
      const expCompanies = safeParseArray(emp.company_name);
      const designation = safeParseArray(emp.designation);
      const duration = safeParseArray(emp.duration);

      // ✅ Document file path check
      const panProofUrl = emp.pan_proof ? `/storage/${emp.pan_proof}` : null;
      const aadhaarProofUrl = emp.aadhaar_proof ? `/storage/${emp.aadhaar_proof}` : null;

      // Buttons for file view/download
      const docButton = (url, label) => {
        if (!url || url === 'N/A' || url === '') {
          return `<span class="text-muted fst-italic">N/A</span>`;
        }
        return `<a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary">
                  <i class="fa-solid fa-eye"></i> View ${label}
                </a>`;
      };

      const eduHtml = edu.length > 0
        ? edu.map((q, i) => `
          <p><strong>${escapeHtml(q)}</strong> — ${escapeHtml(uni[i] || 'N/A')}</p>
        `).join('')
        : '<p class="text-muted fst-italic">No education details available.</p>';

      const expHtml = expCompanies.length > 0
        ? expCompanies.map((c, i) => `
          <div class="info-divider"></div>
          <p><strong>Company:</strong> ${escapeHtml(c)}</p>
          <p><strong>Designation:</strong> ${escapeHtml(designation[i] || 'N/A')}</p>
          <p><strong>Duration:</strong> ${escapeHtml(duration[i] || 'N/A')}</p>
        `).join('')
        : '<p class="text-muted fst-italic">No experience details available.</p>';

      const html = `
        <div class="container-fluid">

          <div class="info-section">
            <h6><i class="fa-solid fa-user"></i> Personal Information</h6>
            <div class="row">
              <div class="col-md-6"><p><strong>Name:</strong> ${escapeHtml(emp.first_name)} ${escapeHtml(emp.last_name)}</p></div>
              <div class="col-md-6"><p><strong>Email:</strong> ${escapeHtml(emp.email)}</p></div>
              <div class="col-md-6"><p><strong>Phone:</strong> ${escapeHtml(emp.phone)}</p></div>
              <div class="col-md-6"><p><strong>DOB:</strong> ${escapeHtml(emp.dob)}</p></div>
              <div class="col-md-6"><p><strong>Gender:</strong> ${escapeHtml(emp.gender)}</p></div>
              <div class="col-md-6"><p><strong>Experience Type:</strong> ${escapeHtml(emp.experience_type)}</p></div>
              <div class="col-md-6"><p><strong>Job Profile:</strong> ${escapeHtml(emp.job_profile)}</p></div>
            </div>
          </div>

          <div class="info-section">
            <h6><i class="fa-solid fa-location-dot"></i> Address Details</h6>
            <p><strong>Address:</strong> ${escapeHtml(emp.address)}</p>
            <p><strong>Permanent Address:</strong> ${escapeHtml(emp.permanent_address)}</p>
          </div>

          <div class="info-section">
            <h6><i class="fa-solid fa-graduation-cap"></i> Education Details</h6>
            ${eduHtml}
          </div>

          <div class="info-section">
            <h6><i class="fa-solid fa-briefcase"></i> Experience Details</h6>
            ${expHtml}
          </div>

          <div class="info-section">
            <h6><i class="fa-solid fa-users"></i> Family / Emergency Info</h6>
            <div class="row">
              <div class="col-md-6"><p><strong>Father's Name:</strong> ${escapeHtml(emp.father_name)}</p></div>
              <div class="col-md-6"><p><strong>Mother's Name:</strong> ${escapeHtml(emp.mother_name)}</p></div>
              <div class="col-md-6"><p><strong>Emergency Contact:</strong> ${escapeHtml(emp.emergency_contact_name)}</p></div>
              <div class="col-md-6"><p><strong>Contact Number:</strong> ${escapeHtml(emp.emergency_contact_number)}</p></div>
            </div>
          </div>

          <div class="info-section">
            <h6><i class="fa-solid fa-file-lines"></i> Uploaded Documents</h6>
            <div class="row">
              <div class="col-md-6"><p><strong>PAN Proof:</strong> ${docButton(panProofUrl, 'PAN')}</p></div>
              <div class="col-md-6"><p><strong>Aadhaar Proof:</strong> ${docButton(aadhaarProofUrl, 'Aadhaar')}</p></div>
            </div>
          </div>
        </div>
      `;

      document.getElementById('modalContent').innerHTML = html;

      const modal = new bootstrap.Modal(document.getElementById('employeeModal'));
      modal.show();
    });
  });
});
</script>


</body>
</html>