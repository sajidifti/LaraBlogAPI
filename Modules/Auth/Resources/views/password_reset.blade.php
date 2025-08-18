<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        .otp { font-size: 24px; font-weight: bold; color: #2c3e50; }
        .footer { margin-top: 20px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Reset Request</h2>
        <p>Hello,</p>
        <p>You requested a password reset. Use the OTP below to reset your password. It expires in 10 minutes.</p>
        <p class="otp">{{ $otp }}</p>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ env('APP_NAME') }}
        </div>
    </div>
</body>
</html>
