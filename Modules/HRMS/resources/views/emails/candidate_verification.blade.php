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



<a href="{{ url('/hrms/verify-response?id=' . $candidate['id'] . '&status=verified') }}"
   style="background: green; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Verified</a>

<a href="{{ url('/hrms/verify-response?id=' . $candidate['id'] . '&status=not_verified') }}"
   style="background: red; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Rejected</a>
 

    <p>Thank you!</p>
    
</body>
</html>
