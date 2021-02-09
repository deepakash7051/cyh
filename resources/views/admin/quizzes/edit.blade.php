@extends('layouts.admin')
@section('content')
<?php 
	$coursename = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.quiz.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.quizzes.update', [$quiz->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group mb-2 {{ $errors->has('course_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="course_id" id="course_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($courses) > 0)
	                        @foreach($courses as $course)
	                            <option value="{{$course->id}}" 
	                            		{{ $course->id == $quiz->course_id ? 'selected="selected"' : '' }}
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
	                    {{ trans('global.slide.fields.course_id_helper') }}
	                </p>
				</div>

				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_title';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.quiz.fields.title') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($quiz) ? $quiz->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.quiz.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.quiz.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $quiz->status == $stkey ? 'selected="selected"' : '' }}
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