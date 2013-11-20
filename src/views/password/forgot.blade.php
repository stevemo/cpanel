@extends(Config::get('cpanel::views.layout'))

@section('header')
<h3>
    <i class="icon-key"></i>
    Password Reset
</h3>
@stop

@section('content')
<div class="row">
    <div class="span12">

        <div class="margin-top-20">
            @if (  Session::has('password_error') )
            <div class="alert-login alert-error">
                {{ Session::get('password_error') }}
            </div>
            @endif
        </div>

        <form action="{{ URL::route('cpanel.password.forgot') }}" class="form-signin" method="POST">
            <h2 class="form-signin-heading">Forgot password?</h2>
            <p class="muted">Please enter your email address so we can send you an email to reset your password.</p>
            <label for="email">Email</label>
            <input class="input-block-level" type="email" name="email" id="email" >

            <hr>
            <button class="btn btn-large btn-primary" type="submit">Reset Password</button>
        </form>

    </div>
</div>
@stop