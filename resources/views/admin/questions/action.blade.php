@can('question_show')
    <a class="btn btn-xs btn-primary" href="{{ route('admin.questions.show', $question->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can('question_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.questions.edit', $question->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@can('question_delete')
    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
