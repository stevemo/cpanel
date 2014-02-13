@extends(Config::get('cpanel::views.layout'))

@section('header')
<h3>
    <i class="icon-ban-circle"></i>
    Users Permissions
</h3>
@stop

@section('content')
<div class="row">
    <div class="span12">
        <div class="block">
            <p class="block-heading">Edit {{ $user->first_name }}&nbsp;{{ $user->last_name }}&nbsp;permissions</p>
            <div class="block-body">
                <p class="lead">Permissions set here will override groups permissions</p>
                {{ Former::horizontal_open( route('cpanel.users.permissions',array($user->id) ))->method('PUT') }}
                @include('cpanel::users.permissions_form')
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{route('cpanel.users.index')}}" class="btn">Cancel</a>
                </div>
                {{ Former::close() }}
            </div>
        </div>
    </div>
</div>
@endsection