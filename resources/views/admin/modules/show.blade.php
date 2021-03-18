@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.courses.modules', $module->course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.module.title_singular') }}
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-custom table-bordered table-striped">
                <tbody>

                    <tr>
                        <td class="font-weight-bold">
                            {{ trans('global.course.title_singular') }}
                        </td>
                        <td>
                            {{ $module->course->$title }}
                        </td>
                    </tr>


                    <tr>
                        <td class="font-weight-bold">
                            {{ trans('global.sorting_order') }}
                        </td>
                        <td>
                            {{ $module->place }}
                        </td>
                    </tr>

                    <tr>
                        <td class="font-weight-bold">
                            {{ trans('global.module.fields.link_attachment') }}
                        </td>
                        <td>
                            {{ $module->link_attachment }}
                        </td>
                    </tr>
                    
                    @if(count($languages) > 0)
                        @foreach($languages as $key => $value)
                            @php 
                                $video_url = $key.'_video_url';
                                $slide_url = $key.'_slide_url';
                                $videocontenttype = $key.'_video_content_type'; 
                                $title = $key.'_title'; 
                                $videohtml = $key.'_video_html';
                                $videolink = $key.'_video_link';
                            @endphp
                            
                            @if($module->link_attachment=='video')
                            <tr>
                                <td class="font-weight-bold">
                                    {{ trans('global.module.fields.video')}} ({{$value}})
                                </td>
                                <td>
                                    @if(!empty($module->$videolink))
                                        {!! $module->$videohtml !!}
                                    @else
                                        <video width="320" height="240" controls>
                                          <source src="{{ $module->$video_url }}" type="{{$module->$videocontenttype}}">
                                          Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td class="font-weight-bold">
                                    {{ trans('global.module.fields.slide')}} ({{$value}})
                                </td>
                                <td>
                                    <a href="{{$module->$slide_url}}">{{ trans('global.view_file') }}</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endif

                
            </tbody>
                
            </table>

        </div>
    </div>

@endsection