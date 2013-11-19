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
                <p class="block-heading">{{ $user->first_name }} {{ $user->last_name }} Profile</p>

                <div class="block-body">

                    <div class="btn-toolbar">
                        <a href="{{ route('cpanel.users.index') }}" class="btn btn-primary" rel="tooltip" title="Back">
                            <i class="icon-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <div class="tabbable">

                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active">
                                <a href="#info" data-toggle="tab">User Info</a>
                            </li>
                            <li>
                                <a href="#permissions" data-toggle="tab">User Permissions</a>
                            </li>
                            <li>
                                <a href="#status" data-toggle="tab">User Status</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="info">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <td><strong>First Name</strong></td>
                                        <td>{{ $user->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Name</strong></td>
                                        <td>{{ $user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Groups</strong></td>
                                        <td>
                                            @foreach($groups as $group)
                                            <span class="label">{{ $group->getName() }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="permissions">
                                @if(count($permissions) > 0)
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>This user have access to the following</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($permissions as $name => $value)
                                                @if($value == 1)
                                                    <tr>
                                                        <td>{{ $name }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info">
                                        This user do not have any permission.
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane" id="status">
                                <table class="table-striped table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Banned</strong></td>
                                            <td>
                                                {{ $throttle->isBanned() ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Suspended</strong></td>
                                            <td>
                                                {{ $throttle->isSuspended() ? 'Yes' : 'No' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Activated</strong></td>
                                            <td>{{ ($user->activated) ? 'yes' : 'no' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date Activated</strong></td>

                                            <td>
                                                @if(is_null($user->activated_at))
                                                    Not Activated
                                                @else
                                                    {{ $user->activated_at->diffForHumans() }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Login</strong></td>
                                            <td>
                                                @if(is_null($user->last_login))
                                                    Never Visited
                                                @else
                                                    {{ $user->last_login->diffForHumans() }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
@stop
