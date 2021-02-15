@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';  
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ $course->$title }} {{ trans('global.slide.title') }}
            </h2>
            <div>
                @can('slide_create')
                <a href="{{ url('admin/slides/create/?course_id='.$course->id)}}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.slide.title_singular') }}
                </a>
                @endcan
            </div>
        </div>

        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>

        @if(count($courseslides) > 0)
        <ul id="slidesortable">
            @foreach($courseslides as $courseslide)
            <li class="ui-state-default" data-val="{{$courseslide->id}}"> 
                <i class="fas fa-arrows-alt"></i> {{$courseslide->$title}} 
                <span class="float-right">
                    @can('slide_show')
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.slides.show', $courseslide->id) }}">
                            {{ trans('global.view') }}
                        </a>
                    @endcan
                    @can('slide_edit')
                        <a class="btn btn-xs btn-info" href="{{ route('admin.slides.edit', $courseslide->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan
                    @can('slide_delete')
                        <form action="{{ route('admin.slides.destroy', $courseslide->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            <div class="text-center">{{ trans('global.no')}} {{trans('global.slide.title_singular')}} {{trans('global.found')}}</div>
        @endif
    </div>

@section('scripts')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@endsection