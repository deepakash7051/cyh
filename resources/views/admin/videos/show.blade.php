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
                {{ trans('global.show') }} {{ trans('global.video.title_singular') }}
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
                            {{ $coursevideo->course->$coursetitle }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.video.fields.title') }}
                        </td>
                        <td>
                            {{ $coursevideo->$videotitle }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.sorting_order') }}
                        </td>
                        <td>
                            {{ $coursevideo->place }}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            {{ trans('global.video.fields.attachment') }}
                        </td>
                        <td>
                            <video width="320" height="240" controls>
                              <source src="{{ $coursevideo->$attachment_url }}" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                        </td>
                    </tr>

                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection