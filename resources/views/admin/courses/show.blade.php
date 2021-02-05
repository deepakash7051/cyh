@extends('layouts.admin')
@section('content')

<?php 
  $categoryname = config('app.locale').'_name';  
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.course.title') }}
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
                            {{ $course->category->$categoryname }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.course.fields.ref_code') }}
                        </td>
                        <td>
                            {{ $course->ref_code }}
                        </td>
                    </tr>
                    
                    @if(count($languages) > 0)
                        @foreach($languages as $langKey => $langValue)
                            @php 
                                $fieldname = $langKey.'_title';
                                $fielddescription = $langKey.'_description';
                            @endphp
                    <tr>
                        <td>
                            {{ trans('global.course.fields.title') }} ({{$langValue}})
                        </td>
                        <td>
                            {{ $course->$fieldname }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('global.course.fields.description') }} ({{$langValue}})
                        </td>
                        <td>
                            {{ $course->$fielddescription }}
                        </td>
                    </tr>
                        @endforeach

                    @endif

                    <tr>
                        <td>
                            {{ trans('global.course.fields.price') }}
                        </td>
                        <td>
                            {{ $course->price }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.course.fields.duration') }}
                        </td>
                        <td>
                            {{ $course->duration }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.course.fields.seats') }}
                        </td>
                        <td>
                            {{ $course->seats }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.course.fields.image') }}
                        </td>
                        <td>
                            <img src="{{ $course->course_image_url }}">
                        </td>
                    </tr>

                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection