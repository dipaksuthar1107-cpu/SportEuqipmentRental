<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { background: #4CAF50; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .button { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SecureAccess Password Recovery</h2>
        </div>
        <div class="content">
            <p>Hi {{ $name }},</p>
            <p>We received a request to reset your password. Use the following 6-digit OTP to verify your identity:</p>
            <p style="text-align: center; font-size: 2.5rem; font-weight: bold; letter-spacing: 10px; color: #4CAF50; background: #f4f4f4; padding: 20px; border-radius: 10px;">
                {{ $otp }}
            </p>
            <p>If you didn't request this, you can safely ignore this email.</p>
            <p>The link will expire in 30 minutes.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sports Equipment Rental Portal</p>
        </div>
    </div>
</body>
</html>
