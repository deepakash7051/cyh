@can('slide_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.slides.show', $slide->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('slide_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.slides.edit', $slide->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('slide_delete')
    <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
