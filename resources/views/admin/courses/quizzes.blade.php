@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';  
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.courses.index')}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ $course->$title }} {{ trans('global.quiz.title_singular') }}
            </h2>
            @if($course->quiz()->count()==0)
            <div>
                @can('quiz_create')
                <a href="{{ url('admin/quizzes/create/?course_id='.$course->id)}}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.quiz.title_singular') }}
                </a>
                @endcan
            </div>
            @endif
        </div>

        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>

        @if(count($quizzes) > 0)
        <ul id="quizsortable">
            
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
            
        </ul>
        @else
            <div class="text-center">{{ trans('global.no')}} {{trans('global.quiz.title_singular')}} {{trans('global.found')}}</div>
        @endif
    </div>

@section('scripts')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@endsection