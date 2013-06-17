@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-ban-circle"></i>
        Permissions
    </h3>
@stop

@section('content')

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">
                    Permissions |
                    <em>Generic permissions</em>
                </p>
                <div class="block-body">
                    <ul>
                        @foreach ($roles['inputs'] as $role => $value)
                             <li>{{ ucfirst($role) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">
                    Permissions |
                    <em>Modules Permissions</em>
                </p>
                <div class="block-body">
                    <p></p>
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('admin.permissions.create') }}" class="btn btn-primary" rel="tooltip" title="Create New Permission">
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
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <ul class="inline">
                                                @foreach ($permission->permissions as $role)
                                                    <li>{{ $role }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.permissions.edit', [$permission->id]) }}"
                                                class="btn" rel="tooltip" title="Edit Permission">
                                                <i class="icon-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.permissions.destroy', [$permission->id]) }}"
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
