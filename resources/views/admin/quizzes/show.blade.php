@extends('layouts.admin')
@section('content')

<?php 
  $coursetitle = config('app.locale').'_title';
  $quiztitle = config('app.locale').'_title';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.courses.quizzes', $quiz->course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.quiz.title_singular') }}
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
                            {{ $quiz->course->$coursetitle }}
                        </td>
                    </tr>

                    @if(count($languages) > 0)
                        @foreach($languages as $key => $value)
                         @php $fieldtitle = $key.'_title'; @endphp
                    <tr>
                        <td>{{trans('global.quiz.fields.title')}} ({{$value}})</td>
                        <td>{{$quiz->$fieldtitle}}</td>
                    </tr>
                        @endforeach
                    @endif

                    <tr>
                        <td>
                            {{ trans('global.quiz.fields.time_limit') }}
                        </td>
                        <td>
                            {{ $quiz->time_limit }} {{trans('global.hour')}}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.quiz.fields.attempts') }}
                        </td>
                        <td>
                            @if($quiz->unlimited_attempts=='1') {{ trans('global.unlimited') }} @else {{ $quiz->attempts}} @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.sorting_order') }}
                        </td>
                        <td>
                            {{ $quiz->place }}
                        </td>
                    </tr>
                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection