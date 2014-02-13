@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-user"></i>
        Users
    </h3>
@stop

@section('help')
    <p class="lead">Users</p>
    <p>
        From here you can create, edit or delete users. Also you can assign custom permissions to a single user.
    </p>
@stop

@section('content')

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">Users</p>

                <div class="block-body">

                    <div class="btn-toolbar">
                        <a href="{{ route('cpanel.users.create') }}" class="btn btn-primary" rel="tooltip" title="Create New User">
                            <i class="icon-plus"></i>
                            New User
                        </a>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Active</th>
                                <th>Joined</th>
                                <th>Last Visit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ HTML::linkRoute('cpanel.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}</td>
                                    <td>{{{ $user->email }}}</td>
                                    <td>{{{ ($user->activated) ? 'yes' : 'no' }}}</td>
                                    <td>{{{ $user->activated_at }}}</td>
                                    <td>{{{ is_null($user->last_login) ? 'Never Visited' : $user->last_login }}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                                Action
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('cpanel.users.show', array($user->id)) }}">
                                                        <i class="icon-info-sign"></i>&nbsp;View User
                                                    </a>
                                                </li>
                                               <li>
                                                   <a href="{{ route('cpanel.users.edit', array($user->id)) }}">
                                                       <i class="icon-edit"></i>&nbsp;Edit User
                                                   </a>
                                               </li>
                                                <li>
                                                    <a href="{{ route('cpanel.users.permissions', array($user->id)) }}">
                                                        <i class="icon-ban-circle"></i>&nbsp;Permissions
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('cpanel.users.destroy', array($user->id)) }}"
                                                       data-method="delete"
                                                       data-modal-text="delete this User?">
                                                       <i class="icon-trash"></i>&nbsp;Delete User
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    @if ($user->isActivated())
                                                        <a href="{{ route('cpanel.users.deactivate', array($user->id)) }}"
                                                           data-method="put"
                                                           data-modal-text="Deactivate this User?">
                                                            <i class="icon-remove"></i>&nbsp;Deactivate
                                                        </a>
                                                    @else
                                                        <a href="{{ route('cpanel.users.activate', array($user->id)) }}"
                                                           data-method="put"
                                                           data-modal-text="Activate this User?">
                                                            <i class="icon-check"></i>&nbsp;Activate
                                                        </a>
                                                    @endif
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('cpanel.users.throttling', array($user->id)) }}">
                                                        <i class="icon-key"></i>&nbsp;Throttling
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
