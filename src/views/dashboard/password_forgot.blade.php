@extends('cpanel::layouts')

@section('header')
    <h3>
        <i class="icon-signin"></i>
        Forgot your password?
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span12">

            <div class="margin-top-20">
                @if ( Session::has('forgot_error') )
                    <div class="alert-login alert-error">
                        <strong>{{ Session::get('forgot_error') }}</strong>
                    </div>
                @endif
            </div>

            <form action="{{ URL::route('admin.password.forgot') }}" class="form-signin" method="POST">
                <h2 class="form-signin-heading">Forgot password?</h2>
                <p>An email will be sent with instructions.</p>

                <label for="email">Email</label>
                <input class="input-block-level" type="text" name="email" id="email" value="{{ Input::old('email') }}">

                <hr>
                <button class="btn btn-large btn-primary" type="submit">Submit</button>
            </form>

            <div class="login-extra">
                {{ HTML::linkRoute('admin.login', 'Return to sign in') }}
            </div>

        </div>
    </div>
@stop