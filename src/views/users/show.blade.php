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
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" rel="tooltip" title="Back">
                            <i class="icon-arrow-left"></i>
                            Back
                        </a>
                    </div>

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
                                    @foreach($user->groups as $group)
                                        <span class="label">{{ $group->getName() }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Activated</strong></td>
                                <td>{{ ($user->activated) ? 'yes' : 'no' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date Activated</strong></td>
                                <td>{{ $user->activated_at }}</td>
                            </tr>
                            <tr>
                                <td><strong>Last Login</strong></td>
                                <td>{{ is_null($user->last_login) ? 'Never Visited' : $user->last_login }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@stop
