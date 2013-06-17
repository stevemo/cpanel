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
            {{Former::horizontal_open( route('admin.users.store') )}}

            <div class="block">
                <p class="block-heading">Add User</p>
                <div class="block-body">

                    <legend><small>items mark with * are required.</small></legend>
                    {{ Former::xlarge_text('first_name', 'First Name')->requireds() }}
                    {{ Former::xlarge_text('last_name', 'Last Name')->requireds() }}
                    {{ Former::xlarge_text('email','Email')->requireds() }}

                    <legend>Password</legend>
                    {{ Former::xlarge_password('password', 'Password')->requireds() }}
                    {{ Former::xlarge_password('password_confirmation', 'Confirm Password')->requireds() }}

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{route('admin.users.index')}}" class="btn">Cancel</a>
                    </div>

                </div>
            </div>

            {{Former::close()}}
        </div>
    </div>
@stop
