@extends('layouts.admin')
@section('content')
<?php 
	$title = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		@if(!empty($quiz->course_id))
		<a href="{{ route('admin.courses.quizzes', $quiz->course_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        @endif
        @if(!empty($quiz->module_id))
		<a href="{{ route('admin.modules.quizzes', $quiz->module_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        @endif
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.quiz.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.quizzes.update', [$quiz->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				@if(!empty($quiz->course_id))
				<div class="form-group mb-2 {{ $errors->has('course_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="course_id" id="course_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($courses) > 0)
	                        @foreach($courses as $course)
	                            <option value="{{$course->id}}" 
	                            		{{ $course->id == $quiz->course_id ? 'selected="selected"' : '' }}
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
	                    {{ trans('global.quiz.fields.course_id_helper') }}
	                </p>
				</div>
				@endif

				@if(!empty($quiz->module_id))
				<div class="form-group mb-2 {{ $errors->has('module_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.title_singular') }}*</label>

					<select class="frm-field select2" name="module_id" id="module_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($modules) > 0)
	                        @foreach($modules as $module)
	                            <option value="{{$module->id}}" 
	                            		{{ $module->id == $quiz->module_id ? 'selected="selected"' : '' }}
	                            	>
	                                {{$module->$title}}
	                            </option>
	                        @endforeach
	                    @endif
                    </select>

					@if($errors->has('module_id'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('module_id') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.quiz.fields.module_id_helper') }}
	                </p>
				</div>
				@endif

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

	            <div class="form-group mb-2 {{ $errors->has('time_limit') ? 'has-error' : '' }}" >
	                <label for="{{$fieldname}}">{{ trans('global.quiz.fields.time_limit') }} ({{ trans('global.hour') }}) *</label>
	                <div class="controls" style="position: relative">
	                <input type="text" id="time_limit" name="time_limit" class="frm-field attempts" value="{{ old('time_limit', isset($quiz) ? $quiz->time_limit : '') }}" placeholder="hh:mm">
	                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
	                @if($errors->has('time_limit'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('time_limit') }}
	                    </em>
	                @endif
	            	</div>
	                <p class="helper-block">
	                    {{ trans('global.quiz.fields.time_limit_helper') }}
	                </p>
	            </div>

	            <div class="form-group mb-2 {{ $errors->has('attempts') ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.quiz.fields.attempts') }}* 
	                	<span class="float-right"> 
	                		<input type="checkbox" class="mr-2" name="unlimited_attempts" value="{{ old('unlimited_attempts', isset($quiz) ? $quiz->unlimited_attempts : '0') }}" id="unlimited_attempts"  {{ old('unlimited_attempts', isset($quiz)) && $quiz->unlimited_attempts== '1' ? 'checked="checked"' : '' }}>{{ trans('global.quiz.fields.unlimited_attempts') }}
	                	</span>
	                </label>
	                <input type="text" id="attempts" name="attempts" class="frm-field " value="{{ old('attempts', isset($quiz) ? $quiz->attempts : '') }}">
	                @if($errors->has('attempts'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('attempts') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.quiz.fields.attempts_helper') }}
	                </p>
	            </div>

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
@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function() {
	$("#unlimited_attempts").click(function() {
	    if (!$(this).is(':checked')) {
	      $(this).val('0');
	    } else {
	    	$(this).val('1');
	    }
    });

});
</script>
@endsection

@endsection