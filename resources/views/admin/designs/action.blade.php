
    <a class="btn btn-xs btn-primary" href="{{ route('admin.designs.show', $design->id) }}">
        {{ trans('global.view') }}
    </a>

    <a class="btn btn-xs btn-info" href="{{ route('admin.designs.edit', $design->id) }}">
        {{ trans('global.edit') }}
    </a>

    <form action="{{ route('admin.designs.destroy', $design->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
