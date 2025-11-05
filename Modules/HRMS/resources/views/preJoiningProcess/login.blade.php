<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Candidate Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    display:flex; 
    min-height:100vh; 
    background:#fff; 
    color:#03396c; 
}

/* Main content container */
.main-content { 
    margin:auto; 
    display:flex; 
    flex-direction:column; 
    align-items:center; 
    justify-content:center;
    width:100%; 
    padding:20px;
}

/* Top bar */
.top-bar { 
    display:flex; 
    justify-content:space-between; 
    align-items:center; 
    background:linear-gradient(to right,#90caf9,#047edf 99%); 
    padding:12px 20px; 
    border-radius:10px; 
    font-size:18px; 
    color:#fff; 
    font-weight:bold; 
    width:100%; 
    max-width:700px; 
    margin-bottom:30px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}

/* Login Card */
.login-card {
  background: linear-gradient(-45deg, #e3f2fd, #bbdefb, #90caf9, #64b5f6);
  background-size: 400% 400%;
  animation: gradientBG 12s ease infinite;
  padding: 35px; 
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
  width:100%; 
  max-width:420px;
  color:#03396c;
  text-align:center;
}
@keyframes gradientBG { 
  0%{background-position:0% 50%;} 
  50%{background-position:100% 50%;} 
  100%{background-position:0% 50%;} 
}

.login-card h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.login-card p {
    font-size: 15px;
    margin-bottom: 25px;
}

/* Input fields */
form {
  display:flex;
  flex-direction:column;
  text-align:left;
}

label {
  font-weight:600;
  margin-bottom:6px;
}

input[type="email"],
input[type="password"] {
  padding:12px;
  border-radius:8px;
  border:1px solid rgba(3,57,108,0.3);
  outline:none;
  font-size:15px;
  margin-bottom:18px;
  transition:0.3s;
}

input:focus {
  border-color:#047edf;
  box-shadow:0 0 6px rgba(4,126,223,0.4);
}

/* Button */
button {
  background:#047edf;
  color:#fff;
  font-weight:bold;
  border:none;
  border-radius:6px;
  padding:12px;
  cursor:pointer;
  font-size:15px;
  transition:0.3s;
}
button:hover { background:#0356b6; }

/* Message styles */
.error-message {
  color:#b91c1c;
  background:#fee2e2;
  border:1px solid #fecaca;
  padding:10px;
  border-radius:6px;
  margin-bottom:15px;
  text-align:center;
  font-size:14px;
}
.success-message {
  color:#166534;
  background:#dcfce7;
  border:1px solid #bbf7d0;
  padding:10px;
  border-radius:6px;
  margin-bottom:15px;
  text-align:center;
  font-size:14px;
}

/* Footer link */
.footer-text {
  margin-top:20px;
  font-size:14px;
  color:#03396c;
}
.footer-text a {
  color:#047edf;
  text-decoration:none;
  font-weight:600;
}
.footer-text a:hover { text-decoration:underline; }
</style>
</head>
<body>

<div class="main-content">

  <div class="top-bar">
    <div><i class="fa-solid fa-user"></i> Candidate Login</div>
  </div>

  <div class="login-card">
    <h1>Welcome Back!</h1>
    <p>Please login to continue your pre-joining process.</p>

    @if($errors->any())
        <p class="error-message">{{ $errors->first() }}</p>
    @endif

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('candidate.login.submit') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>

    {{-- <div class="footer-text">
        Don’t have an account? <a href="#">Register here</a>
    </div> --}}
  </div>

</div>

</body>
</html>
