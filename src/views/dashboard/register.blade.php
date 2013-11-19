@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-edit"></i>
        Register
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">Registration</p>
                <div class="block-body">
                    {{ Former::horizontal_open(route('cpanel.register')) }}
                        <fieldset>
                            <legend>Personal Information</legend>
                            {{ Former::xlarge_text('first_name', 'First Name') }}
                            {{ Former::xlarge_text('last_name', 'Last Name') }}
                        </fieldset>
                        <fieldset>
                            <legend>Email</legend>
                            {{ Former::xlarge_text('email','Email') }}
                        </fieldset>
                        <fieldset>
                            <legend>Password</legend>
                            {{ Former::xlarge_password('password', 'Password') }}
                            {{ Former::xlarge_password('password_confirmation', 'Confirm Password') }}
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    {{ Former::close() }}
                </div>
            </div>

        </div>
    </div>
@stop
