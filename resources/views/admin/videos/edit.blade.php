@extends('layouts.admin')
@section('content')
<?php 
	$coursename = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.video.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.videos.update', [$coursevideo->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group mb-2 {{ $errors->has('category_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="course_id" id="course_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($courses) > 0)
	                        @foreach($courses as $course)
	                            <option value="{{$course->id}}" 
	                            		{{ $course->id == $coursevideo->course_id ? 'selected="selected"' : '' }}
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

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.video.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $coursevideo->status == $stkey ? 'selected="selected"' : '' }}
                        	>{{$stvalue}}</option>
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

				<div class="form-group {{ $errors->has('attachment') ? 'has-error' : '' }}">
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