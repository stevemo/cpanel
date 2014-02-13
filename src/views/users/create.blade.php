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
            {{Former::horizontal_open( route('cpanel.users.store') )}}

            <div class="block">
                <p class="block-heading">Create a new user</p>
                <div class="block-body">

                    <div class="tabbable">

                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active">
                                <a href="#credentials" data-toggle="tab">User Credentials</a>
                            </li>
                            <li>
                                <a href="#permissions" data-toggle="tab">User Permissions</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="credentials">
                                <legend>User Informations</legend>
                                {{ Former::xlarge_text('first_name', 'First Name')->required() }}
                                {{ Former::xlarge_text('last_name', 'Last Name')->required() }}
                                {{ Former::xlarge_text('email','Email')->required() }}

                                <legend>Password</legend>
                                {{ Former::xlarge_password('password', 'Password')->required() }}
                                {{ Former::xlarge_password('password_confirmation', 'Confirm Password')->required() }}

                                <legend>Groups</legend>
                                <div class="control-group">
                                    <label for="groups[]" class="control-label">Groups</label>
                                    <div class="controls">
                                        <select id="groups" name="groups[]" class="select2" multiple="true">
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <legend>Options</legend>
                                {{
                                    Former::select('activate')
                                        ->options(array('0' => 'No','1' => 'Yes'))
                                        ->class('select2')
                                }}

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <a href="{{route('cpanel.users.index')}}" class="btn">Cancel</a>
                                </div>
                            </div>

                            <div class="tab-pane" id="permissions">
                                <p class="lead">Permissions set here will override groups permissions</p>
                                @include('cpanel::users.permissions_form')
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            {{Former::close()}}
        </div>
    </div>
@stop
