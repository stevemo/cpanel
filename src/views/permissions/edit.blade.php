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
                <p class="block-heading">Create new permissions for a module</p>
                <div class="block-body">
                    {{ Former::horizontal_open(route('admin.permissions.update', array($permission->id)))->method('PUT') }}
                    {{ Former::xlarge_text('name', 'Module Name',$permission->name) }}


                    <label class="control-label" for="permissions">
                        Permissions
                    </label>
                    <div class="controls">
                        @foreach ($roles['inputs'] as $key => $value)
                            <label class="checkbox">
                                <input type="checkbox" name="permissions[{{$key}}]"
                                    value="{{$key}}" {{ in_array($key, $permission->rules) ? 'checked="checked"' : '' }}>
                                {{ ucfirst($key) }}
                            </label>
                        @endforeach
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn">Cancel</a>
                    </div>
                    {{ Former::close() }}
                </div>
            </div>
        </div>
    </div>
@stop
