@extends('cpanel::layouts')

@section('header')
    <h3>
        <i class="icon-envelope-alt"></i>
        Password reset sent successfully! 
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span8 offset2 margin-top-20">
            
            <h2>Password reset sent successfully! </h2>
            <p>We’ve sent an email to 

                @if ( Session::has('email') )
                    <strong>{{ Session::get('email') }}</strong>
                @else
                    <strong>your email address</strong>
                @endif

             containing a temporary link that will allow you to reset your password for the next 24 hours. 
             Please check your spam folder if the email doesn’t appear within a few minutes.</p>
            <p>{{ HTML::linkRoute('admin.login', 'Return to sign in') }}</p>

        </div>
    </div>
@stop