@extends('layouts.admin')
@section('content')
<?php 
	$title = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<a href="{{ route('admin.courses.modules', $course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} {{ trans('global.module.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group mb-2 {{ $errors->has('course_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="course_id" id="course_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($courses) > 0)
	                        @foreach($courses as $course)
	                            <option value="{{$course->id}}" 
	                            		{{ old('course_id', isset($module)) || $course_id == $course->id ? 'selected="selected"' : '' }}
	                            	>
	                                {{$course->$title}}
	                            </option>
	                        @endforeach
	                    @endif
                    </select>

					@if($errors->has('course_id'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('course_id') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.course_id_helper') }}
	                </p>
				</div>

				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_title';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.module.fields.title') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($module) ? $module->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.module.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" >{{$stvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('status'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('status') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.status_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2 {{ $errors->has('link_attachment') ? 'has-error' : '' }}">
					<label>{{ trans('global.module.fields.link_attachment') }} *</label>
					
					<div class="row border p-1 m-1">
						<div class="col-md-3 p-1">
							<input type="radio" class="m-1" name="link_attachment" value="video" {{ old('link_attachment') != 'slide' ? 'checked="checked"' : '' }}>
							{{ trans('global.module.fields.video') }}
						</div>
						<div class="col-md-3 p-1">
							<input type="radio" class="m-1" name="link_attachment" value="slide" {{ old('link_attachment') == 'slide' ? 'checked="checked"' : '' }}>
							{{ trans('global.module.fields.slide') }}
						</div>
						<div class="col-md-6"></div>
					</div>
					
					@if($errors->has('link_attachment'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('link_attachment') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.link_attachment_helper') }}
	                </p>
				</div>

				<div id="videosection" style="display: @if(old('link_attachment')!='slide') {{'block'}} @else {{'none'}} @endif;">
	            @if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldvideo = $langKey.'_video';
	                        $fieldvideolink = $langKey.'_video_link';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldvideo) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlangvideo'}} @endif" style="display: @if($langKey!='en' && old('same_video_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
	                <label for="{{$fieldvideo}}">{{ trans('global.module.fields.video') }} ({{$langValue}})	@if($langKey=='en') 
	                	<span class="pull-right" style="float: right;">
	                		<input type="checkbox" id="same_video_for_all" name="same_video_for_all" class="mr-2" value="1" {{ old('same_video_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same_video')}}
	                	</span>@endif
	                </label>

	                <div class="row">
		                <div class="col-md-6">
			                <input type="file" id="{{$fieldvideo}}" name="{{$fieldvideo}}" class="frm-field" value="">
			            </div>
			            <div class="col-md-6">
							<input type="text" id="{{$fieldvideolink}}" name="{{$fieldvideolink}}" class="frm-field" value="{{ old($fieldvideolink, isset($module) ? $module->$fieldvideolink : '') }}" placeholder="{{trans('global.vimeo_youtube_video')}}">
						</div>
					</div>

	                @if($errors->has($fieldvideo))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldvideo) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.video_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif
	        	</div>

	        	<div id="slidesection" style="display: @if(old('link_attachment')=='slide') {{'block'}} @else {{'none'}} @endif;">
	            @if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldslide = $langKey.'_slide';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldslide) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlangslide'}} @endif" style="display: @if($langKey!='en' && old('same_slide_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
	                <label for="{{$fieldslide}}">{{ trans('global.module.fields.slide') }} ({{$langValue}})	@if($langKey=='en') 
	                	<span class="pull-right" style="float: right;">
	                		<input type="checkbox" id="same_slide_for_all" name="same_slide_for_all" class="mr-2" value="1" {{ old('same_slide_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same_slide')}}
	                	</span>@endif
	                </label>
	                <input type="file" id="{{$fieldslide}}" name="{{$fieldslide}}" class="frm-field" value="{{ old($fieldslide, isset($module) ? $module->$fieldslide : '') }}">
	                @if($errors->has($fieldslide))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldslide) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.module.fields.slide_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif
	        	</div>

	            <div>
	                <input class="btnn btnn-s" type="submit" value="{{ trans('global.save') }}">
	            </div>
				
			</form>
		</div>
		
	</div>
@endsection
@section('scripts')
@parent

@endsection