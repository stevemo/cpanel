@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-user"></i>
        Users
    </h3>
@stop

@section('content')

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">Users</p>

                <div class="block-body">

                    <div class="btn-toolbar">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" rel="tooltip" title="Create New User">
                            <i class="icon-plus"></i>
                            New User
                        </a>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Groups</th>
                                <th>Active</th>
                                <th>Joined</th>
                                <th>Last Visit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ HTML::linkRoute('admin.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->groups as $group)
                                            <span class="label">{{ $group->getName() }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ ($user->activated) ? 'yes' : 'no' }}</td>
                                    <td>{{ $user->activated_at }}</td>
                                    <td>{{ is_null($user->last_login) ? 'Never Visited' : $user->last_login }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', [$user->id]) }}"
                                            class="btn" rel="tooltip" title="Edit User">
                                            <i class="icon-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.users.permissions', [$user->id]) }}"
                                            class="btn" rel="tooltip" title="Edit User Permissions">
                                            Permissions <i class="icon-arrow-right"></i>
                                        </a>
                                        <a href="{{ route('admin.users.destroy', [$user->id]) }}"
                                            class="btn btn-danger" rel="tooltip" title="Delete User" data-method="delete"
                                            data-modal-text="delete this User?">
                                            <i class="icon-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end of body -->

            </div> <!-- end of block -->

        </div>
    </div>

@stop
