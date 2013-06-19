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

            {{Former::horizontal_open( route('admin.users.update', array($user->id)), 'PUT' )}}

            <div class="block">
                <p class="block-heading">Edit User &quot;{{ $user->first_name }} {{ $user->last_name }}&quot;</p>
                <div class="block-body">
                    <div class="btn-toolbar">
                        <a href="{{ route('admin.users.destroy', array($user->id)) }}"
                            class="btn btn-danger" rel="tooltip" title="Delete User"
                            data-modal-text="delete this user?" data-method="delete">
                            <i class="icon-trash"></i>
                            Delete
                        </a>
                    </div>

                    <legend><small>items mark with * are required.</small></legend>
                    {{ Former::xlarge_text('first_name', 'First Name', $user->first_name)->required() }}
                    {{ Former::xlarge_text('last_name', 'Last Name', $user->last_name)->required() }}
                    {{ Former::xlarge_text('email','Email', $user->email)->required() }}

                    <legend>Groups</legend>
                    <div class="control-group">
                        <label for="groups[]" class="control-label">Groups</label>
                        <div class="controls">
                            <select id="groups" name="groups[]" class="select2" multiple="true">
                            @foreach($groups as $group)
                                @if( in_array( $group->id, Input::old('groups', array())) or in_array($group->id, $userGroupsId) )
                                    <option selected="selected" value="{{ $group->id }}">{{ $group->name }}</option>
                                @else
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <legend>Password <small>leave blank to keep the same password</small></legend>
                    {{ Former::xlarge_password('password', 'Password') }}
                    {{ Former::xlarge_password('password_confirmation', 'Confirm Password') }}

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
