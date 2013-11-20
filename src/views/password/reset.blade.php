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
        <div class="block">
            <p class="block-heading">Reset your password</p>
            <div class="block-body">
                {{ Former::horizontal_open( route('cpanel.password.update') )}}
                {{ Former::hidden('code')->value($code) }}

                <legend>New Password</legend>
                {{ Former::xlarge_password('password', 'Password') }}
                {{ Former::xlarge_password('password_confirmation', 'Confirm Password') }}

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create new password</button>
                    <a href="{{route('cpanel.login')}}" class="btn">Cancel</a>
                </div>
                {{ Former::close() }}
            </div>
        </div>
    </div>
</div>
@stop