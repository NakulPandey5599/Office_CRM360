<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Selections</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            color: #fff;
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
            background: linear-gradient(to right, #bbf7d0, #86efac);
            padding: 15px 25px;
            font-size: 22px;
            font-weight: bold;
            color: #065f46;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header .back {
            margin-right: 12px;
            font-size: 26px;
            cursor: pointer;
            color: #059669;
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        thead {
            background: #d1fae5;
            color: #064e3b;
            font-weight: bold;
        }

        th,
        td {
            padding: 14px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        tbody tr:hover {
            background: #f0fdf4;
        }

        .btn-send-email {
            padding: 6px 12px;
            border-radius: 6px;
            background: #059669;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-send-email:hover {
            background: #047857;
        }

        .already-sent {
            background: #9ca3af !important;
            cursor: not-allowed;
        }

        .popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            animation: slideDown 0.5s ease;
        }

        .popup-content {
            background: #fff;
            border-radius: 4px;
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-size: 15px;
            font-weight: 500;
            display: inline-block;
            min-width: 400px;
            text-align: center;
            opacity: 0.95;
        }

        .popup-content.success {
            border-left: 6px solid #22c55e;
            color: #166534;
            background: #dcfce7;
        }

        .popup-content.error {
            border-left: 6px solid #ef4444;
            color: #7f1d1d;
            background: #fee2e2;
        }

        @keyframes slideDown {
            from {
                transform: translate(-50%, -30px);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
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
            <span class="back" onclick="goToDashboard()">&#8592;</span>
            Final Selections
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($finalSelection as $selection)
                        <tr>
                            <td>{{ $selection->full_name }}</td>
                            <td>{{ $selection->job_profile }}</td>
                            <td>{{ $selection->final_selection }}</td>
                            <td>
                                <button class="btn-send-email {{ $selection->email_sent ? 'already-sent' : '' }}"
                                    data-id="{{ $selection->id }}"
                                    {{ $selection->email_sent ? 'disabled' : '' }}>
                                    {{ $selection->email_sent ? 'Already Sent' : 'Send Email' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="color: #9ca3af; font-style: italic;">No final selections yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function goToDashboard() {
            window.location.href = "{{ route('recruitment.index') }}";
        }

        function showPopup(message, type) {
            const popup = $('<div class="popup"><div class="popup-content ' + type + '">' + message + '</div></div>');
            $('body').append(popup);
            setTimeout(() => popup.fadeOut(500, () => popup.remove()), 3000);
        }

        $(document).on('click', '.btn-send-email', function(e) {
            e.preventDefault();
            const button = $(this);
            const candidateId = button.data('id');

            if (button.hasClass('already-sent')) {
                if (!confirm("This email was already sent. Send again?")) return;
            }

            button.prop('disabled', true).text('Sending...');

            $.ajax({
                url: '/hrms/send-email/' + candidateId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        button.text('Already Sent')
                            .addClass('already-sent')
                            .css({
                                background: '#9ca3af',
                                cursor: 'not-allowed'
                            });
                        showPopup('✅ ' + response.message, 'success');
                    } else {
                        showPopup('❌ ' + response.message, 'error');
                        button.prop('disabled', false).text('Send Email');
                    }
                },
                error: function() {
                    showPopup('❌ Something went wrong!', 'error');
                    button.prop('disabled', false).text('Send Email');
                }
            });
        });
    </script>
</body>

</html>
