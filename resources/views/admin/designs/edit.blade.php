@extends('layouts.admin')
@section('content')
<?php 
    $languages = config('panel.available_languages');
?>
@if(Session::has('error'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
@endif

@if(Session::has('sussces'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('sussces') }}</p>
@endif
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ $design->title }}
            </h2>
        </div>
		<div class="form-wrap">

        <form action="{{ route('admin.designs.update', [$design->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-2">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="frm-field" value="{{ $design->title }}">
                @if($errors->has('title'))
                <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
                <p class="helper-block"></p>
            </div>

            <div class="form-group mb-2">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="frm-field" value="">
                @if($errors->has('image'))
                <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
                <p class="helper-block"></p>
            </div>
            <div>
                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
            </div>

        </form>

		</div>
		
	</div>
@endsection
@section('scripts')
@parent

@endsection