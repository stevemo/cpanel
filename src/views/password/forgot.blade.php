<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{$cpanel['site_name']}} | Register</title>
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
    <div class="header">Forgot your password?</div>
    {{Form::open(array('route'=>'cpanel.password.forgot'))}}
    <div class="body bg-gray">
        @if (  Session::has('password_error') )
        <div class="alert alert-danger">
            {{ Session::get('password_error') }}
        </div>
        @endif
        <p class="">Please enter your email address so we can send you an email to reset your password.</p>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-envelope"></i>
            </span>
            {{ Form::email('email',null,array('class'=>'form-control','placeholder'=>'Email')) }}
        </div>
    </div>
    <div class="footer">

        <button type="submit" class="btn bg-olive btn-block">Reset my password</button>

        <a href="{{route('cpanel.login')}}" class="text-center">I already have a membership</a>
    </div>
    {{ Form::close() }}
</div>


<!-- jQuery 1.10.2 -->
{{ HTML::script('packages/stevemo/cpanel/adminlte/js/jquery-1.10.2.js') }}
<!-- Bootstrap -->
{{ HTML::script('packages/stevemo/cpanel/adminlte/js/bootstrap.min.js') }}

</body>
</html>