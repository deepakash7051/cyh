@extends('layouts.admin')
@section('content')

<?php 
  $coursetitle = config('app.locale').'_title';
  $attachment_url = config('app.locale').'_attachment_url';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.courses.slides', $courseslide->course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
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
                            {{ trans('global.sorting_order') }}
                        </td>
                        <td>
                            {{ $courseslide->place }}
                        </td>
                    </tr>

                    @if(count($languages) > 0)
                        @foreach($languages as $key => $value)
                            @php 
                                $attachment_url = $key.'_attachment_url'; 
                                $title = $key.'_title'; 
                            @endphp
                            <tr>
                                <td>
                                    {{ trans('global.slide.fields.title')}} ({{$value}})
                                </td>
                                <td>
                                    {{$courseslide->$title}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ trans('global.slide.fields.attachment')}} ({{$value}})
                                </td>
                                <td>
                                        <a href="{{ $courseslide->$attachment_url }}">
                                        {{ trans('global.view_file') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    
            </tbody>
                
            </table>
        </div>
    </div>

@endsection