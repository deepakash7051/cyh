@can('permission_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('permission_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.permissions.edit', $permission->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('permission_delete')
    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
