<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{$cpanel['site_name']}} | Reset Password Successfull</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.1.0 -->
    {{ HTML::style('packages/stevemo/cpanel/adminlte/css/bootstrap.min.css') }}
    <!-- font Awesome -->
    {{ HTML::style('packages/stevemo/cpanel/adminlte/css/font-awesome.min.css') }}
    <!-- Theme style -->
    {{ HTML::style('packages/stevemo/cpanel/adminlte/css/adminlte.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">

<div class="form-box" id="login-box">
    <div class="header">Password reset sent successfully! </div>
    <div class="body bg-gray">
        <p>
            We’ve sent an email to<strong>&nbsp;{{ $email }}&nbsp;</strong>
            containing a temporary link that will allow you to reset your password for the next 24 hours.
        </p>
        <p>Please check your spam folder if the email doesn’t appear within a few minutes.</p>
        <p>{{ link_to_route('cpanel.login', 'Return to sign in') }}</p>
    </div>
</div>


<!-- jQuery 1.10.2 -->
{{ HTML::script('packages/stevemo/cpanel/adminlte/js/jquery-1.10.2.js') }}
<!-- Bootstrap -->
{{ HTML::script('packages/stevemo/cpanel/adminlte/js/bootstrap.min.js') }}

</body>
</html>