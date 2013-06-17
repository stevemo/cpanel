@extends(Config::get('cpanel::views.layout'))

@section('header')
    <h3>
        <i class="icon-group"></i>
        Groups
    </h3>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            {{ Former::horizontal_open(route('admin.groups.update', array($group->id)))->method('PUT') }}
            <div class="block">
                <p class="block-heading">Edit "{{ $group->name }}" Group</p>
                <div class="block-body">


                    {{ Former::xlarge_text('name','Name')->value($group->name)->required() }}

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{route('admin.groups.index')}}" class="btn">Cancel</a>
                    </div>
                </div>
            </div>
            {{ Former::close() }}
        </div>
    </div>
@stop
