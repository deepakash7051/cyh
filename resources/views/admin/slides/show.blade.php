@extends('layouts.admin')
@section('content')

<?php 
  $coursetitle = config('app.locale').'_title';
  $videotitle = config('app.locale').'_title';
  $attachment_url = config('app.locale').'_attachment_url';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.slide.title_singular') }}
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
                            {{ $courseslide->course->$coursetitle }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.slide.fields.title') }}
                        </td>
                        <td>
                            {{ $courseslide->$videotitle }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.slide.fields.place') }}
                        </td>
                        <td>
                            {{ $courseslide->place }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            {{ trans('global.video.fields.attachment') }}
                        </td>
                        <td>
                            <a href="{{ $courseslide->$attachment_url }}">
                                {{ trans('global.view_file') }}
                            </a>

                        </td>
                    </tr>

                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection