
    <a class="btn btn-xs btn-primary" href="{{ route('admin.proposals.show', $proposal->id) }}">
        {{ trans('global.view') }}
    </a>
    
    <a class="btn btn-xs btn-info" href="{{ route('admin.proposals.edit', $proposal->id) }}">
        {{ trans('global.edit') }}
    </a>
    
    <form action="{{ route('admin.proposals.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
