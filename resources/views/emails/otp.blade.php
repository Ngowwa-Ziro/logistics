<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 500px;
            background: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #ccc;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #2d89ef;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p>Hello, {{ $email ?? 'User' }}!</p>
        <p>Use the following One-Time Password (OTP) to verify your login:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>This OTP is valid for only 5 minutes. Do not share it with anyone.</p>
        <p>If you didn't request this, please ignore this email.</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AO Technologies. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
