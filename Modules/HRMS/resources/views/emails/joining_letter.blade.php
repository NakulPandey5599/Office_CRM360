<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Joining Letter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <p>Date: {{ $details['joining_date'] }}</p>

    <p>To,<br>
        <strong>{{ $details['candidate_name'] }}</strong><br>
        Department: {{ $details['department'] }}<br>
        Location: {{ $details['location'] }}
    </p>

    <p><strong>Subject:</strong> Joining Letter</p>

    <p>Dear {{ $details['candidate_name'] }},</p>

    <p>We are pleased to confirm your appointment as <strong>{{ $details['designation'] }}</strong>
       in our {{ $details['department'] }} department.
       You are requested to report at our {{ $details['location'] }} office on
       <strong>{{ $details['joining_date'] }}</strong>.
    </p>

    <p>We welcome you to our organization and look forward to your valuable contribution.</p>

    <p style="margin-top:10px;">Click below to access your personalized training portal 👇</p>
     <a href="{{ route('trainingAssessment.index') }}" class="btn" target="_blank">Access Training Modules</a>

    <br><br>
    <p>Regards,<br>
        <strong>HR Department</strong><br>
        HRMS Pvt. Ltd.
    </p>
</body>
</html>
