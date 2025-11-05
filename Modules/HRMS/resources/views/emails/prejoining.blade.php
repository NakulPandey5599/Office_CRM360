<!DOCTYPE html>
<html>
<head>
    <title>Pre-Joining Form</title>
</head>
<body>
    <h2>Dear {{ $candidate->full_name }},</h2>
    <p>Congratulations! You have been selected for the {{ $candidate->job_profile }} position.</p>

    <p>Please use the following credentials to log in to the Pre-Joining Portal:</p>
    <ul>
        <li><strong>Email:</strong> {{ $candidate->email }}</li>
        <li><strong>Password:</strong> {{ $plainPassword }}</li>
    </ul>

    <p>After logging in, you can fill your Pre-Joining Form here:</p>
    <a href="{{ route('candidate.login') }}" target="_blank">Login to Pre-Joining Portal</a>

    <br><br>
    <p>Regards,<br>Recruitment Team</p>
</body>
</html>
