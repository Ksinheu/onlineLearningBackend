<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <p>Hello,</p>
    <p>You requested a password reset. Use the token below to reset your password:</p>
    <p><strong>Token:</strong> {{ $token }}</p>

    <p>Or, click the link below (frontend must handle this):</p>
    <p>
        <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}">
            Reset your password
        </a>
    </p>
    <p>If you didn’t request a password reset, you can ignore this email.</p>
</body>
</html>
