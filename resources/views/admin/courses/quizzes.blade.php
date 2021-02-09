@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';  
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ $course->$title }} {{ trans('global.quiz.title') }}
            </h2>
            <div>
                <a href="{{ route('admin.quizzes.create') }}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.quiz.title_singular') }}
                </a>
            </div>
        </div>

        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>

        <ul id="quizsortable">
            @if(count($quizzes) > 0)
                @foreach($quizzes as $quiz)
            <li class="ui-state-default" data-val="{{$quiz->id}}"> 
                <i class="fas fa-arrows-alt"></i> {{$quiz->$title}} 
                <span class="float-right">
                    @can('question_access')
                        <a class="btn btn-xs btn-success" href="{{ route('admin.quizzes.questions', $quiz->id) }}">
                            {{ trans('global.question.title') }}
                        </a>
                    @endcan
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
                </span>
            </li>
                @endforeach
            @endif
        </ul>
    </div>

@section('scripts')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@endsection