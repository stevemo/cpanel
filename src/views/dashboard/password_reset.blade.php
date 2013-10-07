@extends('cpanel::layouts')

@section('header')
    <h3>
        <i class="icon-signin"></i>
        Reset your password
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span12">

            <div class="margin-top-20">
                @if ( Session::has('reset_error') )
                    <div class="alert-login alert-error">
                        <strong>{{ Session::get('reset_error') }}</strong>
                    </div>
                @endif
            </div>

            <form action="" class="form-signin" method="POST">
                <h2 class="form-signin-heading">Reset password</h2>
                <p>Update your Password.</p>

                <label for="password">New Password</label>
                <input class="input-block-level" type="password" name="password" id="password" placeholder="Type your new password." required>

                <label for="password_confirmation">Confirm Password</label>
                <input class="input-block-level" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your new password." required>

                <hr>
                <button class="btn btn-large btn-primary" type="submit">Update your password</button>
            </form>

            <div class="login-extra">
                {{ HTML::linkRoute('admin.login', 'Return to sign in') }}
            </div>

        </div>
    </div>
@stop