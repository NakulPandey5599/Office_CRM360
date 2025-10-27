<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Offer Letter</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; margin: 40px; }
        h1 { text-align: center; }
        p { margin-bottom: 12px; }
    </style>
</head>
<body>
    <h1>Offer Letter</h1>
    <p>Dear <strong>{{ $candidate_name }}</strong>,</p>

    <p>We are pleased to offer you the position of <strong>{{ $designation }}</strong> in the
    <strong>{{ $department }}</strong> department at our <strong>{{ $location }}</strong> office.</p>

    <p>Your joining date is <strong>{{ $joining_date }}</strong>, with a total CTC of <strong>{{ $ctc }}</strong>.</p>

    <p>We look forward to having you on our team.</p>

    <p><strong>Best regards,</strong><br>HR Department</p>
</body>
</html>
