@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-ban-circle"></i>
        Permissions
    </h3>
@stop
@section('help')
    <p class="lead">Permission Inheritance</p>
    <p>
        Just as permissions are defined for groups and individual users,
        the permission inheritance model depends on a user's group.
        An Administrator can assign different permissions to a user that is assigned to a group,
        and if that group has different access permissions, the user's access is always determined by the group access.
    </p>
    <br>
    <p class="text-warning">
        Permission Inheritance only works for users permissions.
    </p>
     <p class="text-info">
        For more info visit <a href="http://docs.cartalyst.com/sentry-2/permissions" target="_blank">Sentry website</a>
    </p>
@stop
@section('content')

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">
                    Modules Permissions
                </p>
                <div class="block-body">
                    <p></p>
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('cpanel.permissions.create') }}" class="btn btn-primary"
                           rel="tooltip" title="Create New Permission">
                            <i class="icon-plus"></i>
                            New Permission
                        </a>
                    </div>

                    @if($permissions->isEmpty())
                        <div class="alert alert-info">
                            {{ Lang::get('cpanel::permissions.no_found') }}
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Roles</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions->all() as $permission)
                                    <tr>
                                        <td>{{{ $permission->name }}}</td>
                                        <td>
                                            <ul class="inline">
                                                @foreach ($permission->permissions as $role)
                                                    <li>{{{ $role }}}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('cpanel.permissions.edit', array($permission->id)) }}"
                                                class="btn" rel="tooltip" title="Edit Permission">
                                                <i class="icon-edit"></i>
                                            </a>
                                            <a href="{{ route('cpanel.permissions.destroy', array($permission->id)) }}"
                                                class="btn btn-danger" rel="tooltip" title="Delete Permission" data-method="delete"
                                                data-modal-text="delete this Permission?">
                                                <i class="icon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop
