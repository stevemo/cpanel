@extends('cpanel::layouts.guest')

@section('content')
    <div class="container register-box">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>{{{ trans('cpanel::registration.create.header') }}}</strong>
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
                                            {{ Form::label('first_name', trans('cpanel::registration.create.label-firstname')) }}
                                            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- last_name Field --->
                                        <div class="form-group">
                                            {{ Form::label('last_name', trans('cpanel::registration.create.label-lastname')) }}
                                            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- email Field --->
                                        <div class="form-group">
                                            {{ Form::label('email', trans('cpanel::registration.create.label-email')) }}
                                            {{ Form::email('email', null, ['class' => 'form-control']) }}
                                        </div>

                                        <!--- password Field --->
                                        <div class="form-group">
                                            {{ Form::label('password', trans('cpanel::registration.create.label-pass')) }}
                                            {{ Form::password('password', ['class' => 'form-control']) }}
                                        </div>

                                        <!--- password_confirmation Field --->
                                        <div class="form-group">
                                            {{ Form::label('password_confirmation', trans('cpanel::registration.create.label-pass-conf')) }}
                                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                        </div>

										<div class="form-group">
											<input type="submit"
											    class="btn btn-lg btn-primary btn-block"
											    value="{{{ trans('cpanel::registration.create.btn-register') }}}"
											    id="register-submit" >
										</div>

									</div>
								</div>
							</fieldset>
						{{ Form::close() }}
					</div>
					<div class="panel-footer ">
						{{{ trans('cpanel::registration.create.footer-text') }}}
						 <a href="" id="btn-register">{{{ trans('cpanel::registration.create.link-register') }}}</a>
					</div>
                </div>
			</div>
		</div>
	</div>
@stop