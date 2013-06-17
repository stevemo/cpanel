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
                    {{ Former::horizontal_open(route('admin.permissions.store')) }}
                    {{ Former::xlarge_text('name', 'Module Name') }}
                    {{ Former::checkboxes('permissions')->checkboxes($roles['inputs'])->label('Permissions')}}
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
