@extends('layouts.admin')
@section('content')

<?php 
  $coursetitle = config('app.locale').'_title';
  $quiztitle = config('app.locale').'_title';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
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

                    <tr>
                        <td>
                            {{ trans('global.video.fields.title') }}
                        </td>
                        <td>
                            {{ $quiz->$quiztitle }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.video.fields.place') }}
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