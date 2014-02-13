<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

    <h1>Password reset request</h1>
    <p>Hello,</p>
    <p>You are receiving this notification because a password reset for your account has been requested.</p>
    <p>If you did not request this notification then please ignore it.</p>
    <p>Use the following link within the next 24 hours to reset your password:</p>
    <p>{{ HTML::linkRoute("cpanel.password.reset", null, array($code)) }}</p>
    <p>Admin</p>

</body>
</html>