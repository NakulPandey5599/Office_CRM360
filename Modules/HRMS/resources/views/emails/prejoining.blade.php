<!DOCTYPE html>
<html>
<head>
    <title>Pre-Joining Form</title>
</head>
<body>
    <h2>Dear {{ $candidate->full_name }},</h2>
    <p>Congratulations! You have been selected for the {{ $candidate->job_profile }} position.</p>
    <p>Please find your pre-joining form link below and fill it out:</p>
    <a href="{{ route('preJoiningProcess.index', $candidate->id) }}" target="_blank">Fill Pre-Joining Form</a>
    <p>Regards,<br>Recruitment Team</p>
</body>
</html>
<!-- End of Pre-Joining Form Email Template -->
