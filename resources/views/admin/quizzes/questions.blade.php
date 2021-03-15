@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';
  $attachment = config('app.locale').'_attachment_file_name';
  $attachmenturl = config('app.locale').'_attachment_url';   
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        @if(!empty($quiz->course_id))
        <a href="{{ route('admin.courses.quizzes', $quiz->course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        @endif
        @if(!empty($quiz->module_id))
        <a href="{{ route('admin.modules.quizzes', $quiz->module_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        @endif
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ $quiz->$title }} {{ trans('global.question.title') }}
            </h2>
            <div>
                @can('question_create')
                <a href="{{ url('admin/questions/create/?quiz_id='.$quiz->id) }}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.question.title_singular') }}
                </a>
                @endcan
            </div>
        </div>

        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>

        @if(count($questions) > 0)
        <ul id="questionsortable">
            @foreach($questions as $question)
            <li class="ui-state-default" data-val="{{$question->id}}"> 
                <i class="fas fa-arrows-alt"></i> 
                    {{$question->$title}}
                <!-- @if($question->visible=='text')
                    {{$question->$title}} 
                @else
                    <a href="{{$question->$attachmenturl}}" target="_blank">{{$question->$attachment}}</a>
                @endif -->


                <span class="float-right">
                    
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
                </span>
            </li>
            @endforeach
        </ul>
        @else
            <div class="text-center">{{ trans('global.no')}} {{trans('global.question.title_singular')}} {{trans('global.found')}}</div>
        @endif
    </div>

@section('scripts')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@endsection