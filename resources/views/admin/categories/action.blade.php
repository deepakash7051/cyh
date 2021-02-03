@can('category_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.categories.show', $category->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('category_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.categories.edit', $category->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('category_delete')
    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
