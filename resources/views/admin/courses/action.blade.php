@can('course_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.courses.show', $course->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('course_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.courses.edit', $course->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('course_delete')
    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
