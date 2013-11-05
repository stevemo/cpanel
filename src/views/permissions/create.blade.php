@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-ban-circle"></i>
        Permissions
    </h3>
@stop

@section('help')
    <p class="lead">Module Permission</p>
    <p>
        Every keywords enter in the <strong>Permissions field</strong> will be prefixed with the
        <strong>Module name Field</strong>.
    </p>
    <br/>
    <p class="lead">Example</p>
    <p>
        <strong>Module name: </strong> blog
    </p>
    <p>
        <strong>Permissions: </strong> view, create, delete and publish
    </p>
    <p>
        <strong>Result:</strong> blog.view, blog.create, blog.delete and blog.publish
    </p>
@stop

@section('content')
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">Create new permissions for a module</p>
                <div class="block-body">
                    {{ Former::horizontal_open(route('cpanel.permissions.store')) }}
                    {{ Former::xlarge_text('name', 'Module Name')->required() }}
                    {{ Former::xlarge_text('permissions')->id('permission-tags')->required() }}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('cpanel.permissions.index') }}" class="btn">Cancel</a>
                    </div>
                    {{ Former::close() }}
                </div>
            </div>
        </div>
    </div>
@stop