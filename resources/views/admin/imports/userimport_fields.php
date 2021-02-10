@extends('layouts.admin')
@section('content')
<?php 
	$coursename = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.csvImport') }} {{ trans('global.user.title') }}
            </h2>
            <div>
                <a href="{{ asset('imports/importuser.csv') }}" class="btnn btnn-s">
                    {{ trans('global.demo') }} {{ trans('global.downloadFile') }} 
                </a>
            </div>
        </div>
		
		
	</div>

@endsection