<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Joining Letter</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; line-height: 1.6; }
        h2 { text-align: center; text-decoration: underline; }
        .signature { margin-top: 60px; font-weight: bold; }
    </style>
</head>
<body>
    <p>Date: {{ $joining_date }}</p>
    <p>To,<br><b>{{ $name }}</b><br>Department: {{ $department }}<br>Location: {{ $location }}</p>

    <h2>Joining Letter</h2>

    <p>Dear {{ $name }},</p>
    <p>
        We are pleased to confirm your appointment as <b>{{ $designation }}</b> in our {{ $department }} department. 
        You are requested to report at our {{ $location }} office on <b>{{ $joining_date }}</b>.
    </p>

    <p>We welcome you to our organization and look forward to your valuable contribution.</p>

    <div class="signature">Authorized Signatory<br><br>__________________</div>
</body>
</html>
