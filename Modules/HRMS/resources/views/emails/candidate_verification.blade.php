<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidate Verification Request</title>
</head>
<body>
    <h2>Data Verification Request</h2>

    <p><strong>Candidate Name:</strong> {{ $candidate['name'] ?? 'N/A' }}</p>
    <p><strong>HR Contact Name:</strong> {{ $hrName ?? 'N/A' }}</p>

    <p>Please verify the candidate's details and respond at your earliest convenience.</p>

    <p>Thank you!</p>
</body>
</html>
