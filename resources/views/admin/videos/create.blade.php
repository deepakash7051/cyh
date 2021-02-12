@extends('layouts.admin')
@section('content')
<?php 
	$coursename = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} {{ trans('global.video.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group mb-2 {{ $errors->has('course_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="course_id" id="course_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($courses) > 0)
	                        @foreach($courses as $course)
	                            <option value="{{$course->id}}" 
	                            		{{ old('course_id') == $course->id ? 'selected="selected"' : '' }}
	                            	>
	                                {{$course->$coursename}}
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
	                    {{ trans('global.video.fields.course_id_helper') }}
	                </p>
				</div>

				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_title';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.video.fields.title') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($video) ? $video->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.video.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.video.fields.status') }}</label>
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
	                    {{ trans('global.video.fields.status_helper') }}
	                </p>
				</div>

				<!-- <div class="form-group {{ $errors->has('attachment') ? 'has-error' : '' }}">
	                <label for="lng">{{ trans('global.video.fields.attachment') }}*</label>
	                <div><input type="file" id="attachment" name="attachment" ></div>
	                @if($errors->has('attachment'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('attachment') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.video.fields.attachment_helper') }}
	                </p>
	            </div> -->

	            @if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldattachment = $langKey.'_attachment';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldattachment) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlang'}} @endif" style="display: @if($langKey!='en' && old('same_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
	                <label for="{{$fieldattachment}}">{{ trans('global.video.fields.attachment') }} ({{$langValue}})*	@if($langKey=='en') 
	                	<span class="pull-right" style="float: right;">
	                		<input type="checkbox" id="same_for_all" name="same_for_all" class="mr-2" value="1" {{ old('same_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same_video')}}
	                	</span>@endif
	                </label>
	                <input type="file" id="{{$fieldattachment}}" name="{{$fieldattachment}}" class="frm-field" value="{{ old($fieldattachment, isset($video) ? $video->$fieldattachment : '') }}">
	                @if($errors->has($fieldattachment))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldattachment) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.video.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

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