@extends('cpanel::layouts')

@section('header')
    <h3>
        <i class="icon-envelope-alt"></i>
        Password reset successfull!
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span8 offset2 margin-top-20">

            <h2> Password reset successfull! </h2>
            <p>Your password had been changed successfully. You can now login with your new password.</p>
            <p>{{ HTML::linkRoute('admin.login', 'Return to sign in') }}</p>

        </div>
    </div>
@stop