@can('video_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.videos.show', $video->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('video_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.videos.edit', $video->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('video_delete')
    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan