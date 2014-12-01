<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('cpanel::registration.email.greeting', ['name' => $fullname]) }}</h2>

		<p>{{ trans('cpanel::registration.email.start') }}</p>

		<p>
		    *************************************
		    <br>
		    <strong>{{ trans('cpanel::registration.email.email') }}:</strong>&nbsp;{{ $email }}
		    <br>
		    <br>
            <strong>{{ trans('cpanel::registration.email.password') }}:</strong>&nbsp;{{ $password }}
            <br>
		    *************************************
		</p>

		<p>
		    {{ trans('cpanel::registration.email.end') }}
		    <a href="{{ route('cpanel.activation', [$code]) }}">{{ trans('cpanel::registration.email.link') }}</a>
		</p>
	</body>
</html>
