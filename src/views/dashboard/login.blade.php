@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-signin"></i>
        Sign In
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span12">

            <div class="margin-top-20">
                @if ( Session::has('login_error') )
                    <div class="alert-login alert-error">
                        <strong>{{ Session::get('login_error') }}</strong>
                    </div>
                @endif
            </div>

            <form action="{{ URL::route('admin.login') }}" class="form-signin" method="POST">
                <h2 class="form-signin-heading">Sign In</h2>
                <label for="{{ $login_attribute }}">{{ ucfirst($login_attribute) }}</label>
                <input class="input-block-level" type="text"
                    name="login_attribute" id="login_attribute" value="{{ Input::old('login_attribute') }}">
                <label for="password">Password</label>
                <input class="input-block-level" type="password" name="password" id="password" >

                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox" for="remember_me">
                            <input type="checkbox" name="remember_me" value="true">  Remember me on this computer
                        </label>

                    </div>
                </div>

                <hr>
                <button class="btn btn-large btn-primary" type="submit">Sign in</button>
            </form>

            <div class="login-extra">
                Don't have an account?
                {{ HTML::linkRoute('admin.register', 'Register') }}
                <!--
                    TODO: make link to forget password
                 -->
            </div>

        </div>
    </div>
@stop
