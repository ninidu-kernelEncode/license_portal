<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { background-color: #ffffff; max-width: 600px; margin: 40px auto; padding: 20px; border-radius: 8px; }
        h2 { color: #333333; }
        p { font-size: 16px; color: #555555; }
        .code { display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 20px; font-weight: bold; background-color: #e0f7fa; color: #00796b; border-radius: 5px; }
        .footer { font-size: 12px; color: #999999; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Hello {{ $name }},</h2>
    <p>You requested a password reset for your Tara Account.</p>
    <p>Your password reset code is:</p>
    <div class="code">{{ $code }}</div>
    <p>If you did not request a password reset, please ignore this email.</p>
    <div class="footer">
        &copy; {{ date('Y') }} Tara - Simplify your finances. All rights reserved.
    </div>
</div>
</body>
</html>
