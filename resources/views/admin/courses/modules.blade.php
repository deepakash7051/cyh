@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';  
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.courses.index')}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ $course->$title }} {{ trans('global.module.title') }}
            </h2>
            <div>
                @can('module_create')
                <a href="{{ url('admin/modules/create/?course_id='.$course->id) }}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.module.title_singular') }}
                </a>
                @endcan
                
            </div>
        </div>

        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>

        @if(count($modules) > 0)
        <ul id="modulesortable">
            @foreach($modules as $module)
            <li class="ui-state-default" data-val="{{$module->id}}"> 
                <i class="fas fa-arrows-alt"></i> {{$module->$title}}
                <span class="float-right">
                    @can('quiz_access')
                        <a class="btn btn-xs btn-success" href="{{ route('admin.modules.quizzes', $module->id) }}">
                            {{ trans('global.quiz.title_singular') }}
                        </a>
                    @endcan
                    @can('module_show')
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.modules.show', $module->id) }}">
                            {{ trans('global.view') }}
                        </a>
                    @endcan
                    @can('module_edit')
                        <a class="btn btn-xs btn-info" href="{{ route('admin.modules.edit', $module->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan
                    @can('module_delete')
                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
            <div class="text-center">{{ trans('global.no')}} {{trans('global.module.title_singular')}} {{trans('global.found')}}</div>
        @endif
    </div>

@section('scripts')
@parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@endsection