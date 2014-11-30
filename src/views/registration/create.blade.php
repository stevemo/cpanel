@extends('cpanel::layouts.guest')

@section('content')
    <div class="container" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Sign up</strong>
					</div>
					<div class="panel-body">
						{{ Form::open(['route' => 'cpanel.register', 'method' => 'post']) }}
							<fieldset>
								<div class="row">
									<div class="center-block">
										<img class="profile-img" src="{{ asset('packages/stevemo/cpanel/AdminLTE/img/user-login.jpg') }}" alt="">
									</div>
								</div>

								@include('cpanel::partials.errors')
								@include('flash::message')

								<div class="row">
									<div class="col-sm-12 col-md-10 col-md-offset-1 ">

                                        <!--- first_name Field --->
                                        <div class="form-group">
                                            {{ Form::label('first_name', 'First Name:') }}
                                            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- last_name Field --->
                                        <div class="form-group">
                                            {{ Form::label('last_name', 'Last Name:') }}
                                            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- email Field --->
                                        <div class="form-group">
                                            {{ Form::label('email', 'Email:') }}
                                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- password Field --->
                                        <div class="form-group">
                                            {{ Form::label('password', 'Password:') }}
                                            {{ Form::password('password', ['class' => 'form-control']) }}
                                        </div>

                                        <!--- password_confirmation Field --->
                                        <div class="form-group">
                                            {{ Form::label('password_confirmation', 'Confirm Password:') }}
                                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                        </div>

										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Register" id="register-submit">
										</div>

									</div>
								</div>
							</fieldset>
						{{ Form::close() }}
					</div>
					<div class="panel-footer ">
						Already have an account! <a href="" id="signup-btn"> Sign In Here </a>
					</div>
                </div>
			</div>
		</div>
	</div>
@stop