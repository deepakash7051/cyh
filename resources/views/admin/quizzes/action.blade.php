@can('quiz_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.quizzes.show', $quiz->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('quiz_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.quizzes.edit', $quiz->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('quiz_delete')
    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
