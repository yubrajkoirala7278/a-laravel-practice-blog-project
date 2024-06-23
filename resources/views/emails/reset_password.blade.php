<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 600px;
            margin: 0 auto;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header img {
            width: 150px;
        }
        .email-body {
            margin-bottom: 20px;
        }
        .email-footer {
            text-align: center;
            color: #aaa;
            font-size: 12px;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('images/company-logo.png') }}" alt="Company Logo">
        </div>
        <div class="email-body">
            <p>Hello!</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>
                <a href="{{ url('password/reset', $token) }}?email={{ urlencode($email) }}" class="btn">Reset Password</a>
            </p>
            <p>This password reset link will expire in 60 minutes.</p>
            <p>If you did not request a password reset, no further action is required.</p>
        </div>
        <div class="email-footer">
            Regards, <br>
            Your Company
        </div>
    </div>
</body>
</html>