@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';
  $attachment_url = config('app.locale').'_attachment_url';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.question.title_singular') }}
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-custom table-bordered table-striped">
                <tbody>

                    <tr>
                        <td>
                            {{ trans('global.course.title_singular') }}
                        </td>
                        <td>
                            {{ $question->course->$title }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.quiz.title_singular') }}
                        </td>
                        <td>
                            {{ $question->quiz->$title }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.question.fields.title') }}
                        </td>
                        <td>
                            {{ $question->$title }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.question.fields.type') }}
                        </td>
                        <td>
                            @if($question->type=='1')
                                {{ trans('global.mcq') }} 
                            @else
                                {{ trans('global.short_question') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.question.fields.place') }}
                        </td>
                        <td>
                            {{ $question->place }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            {{ trans('global.video.fields.attachment') }}
                        </td>
                        <td>
                            <img src="{{ $question->$attachment_url }}">

                        </td>
                    </tr>

                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection