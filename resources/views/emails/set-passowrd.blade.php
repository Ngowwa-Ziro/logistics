<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>Your account has been created. Please set your password by clicking the link below:</p>

    <p><strong>Temporary Password:</strong> {{ $password }}</p>

    <p><a href="{{ route('setPasswordForm', ['email' => $user->email]) }}">Set Your Password</a></p>

    <p>Thank you.</p>
</body>
</html>
