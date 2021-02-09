@extends('layouts.admin')
@section('content')
<?php 
	$title = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.question.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.questions.update', [$question->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group mb-2 {{ $errors->has('quiz_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.quiz.title_singular') }}*</label>

					<select class="frm-field select2" name="quiz_id" id="quiz_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($quizzes) > 0)
	                        @foreach($quizzes as $quiz)
	                            <option value="{{$quiz->id}}" 
	                            		{{ $quiz->id == $question->quiz_id ? 'selected="selected"' : '' }}
	                            	>
	                                {{$quiz->$title}}
	                            </option>
	                        @endforeach
	                    @endif
                    </select>

					@if($errors->has('quiz_id'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('quiz_id') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.quiz_id_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2 {{ $errors->has('type') ? 'has-error' : '' }}">
					<label>{{ trans('global.question.fields.type') }}</label>
					@php 
						$types = ['1' => trans('global.mcq'), '0' => trans('global.short_question') ];
					@endphp
					<select class="frm-field " name="type" id="type" >
                        @foreach($types as $tykey => $tyvalue)
                        	<option value="{{$tykey}}" 
                        		{{ $quiz->type == $tykey ? 'selected="selected"' : '' }}
                        	>{{$tyvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('type'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('type') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.type_helper') }}
	                </p>
				</div>

				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_title';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.question.fields.title') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($question) ? $question->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.question.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $question->status == $stkey ? 'selected="selected"' : '' }}
                        	>{{$stvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('status'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('status') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.status_helper') }}
	                </p>
				</div>

				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldattachment = $langKey.'_attachment';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldattachment) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlang'}} @endif" style="display: @if($langKey!='en' && old('same_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
	                <label for="{{$fieldattachment}}">{{ trans('global.question.fields.attachment') }} ({{$langValue}})*	@if($langKey=='en') 
	                	<span class="pull-right" style="float: right;">
	                		<input type="checkbox" id="same_for_all" name="same_for_all" class="mr-2" value="1" {{ old('same_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same')}}
	                	</span>@endif
	                </label>
	                <input type="file" id="{{$fieldattachment}}" name="{{$fieldattachment}}" class="frm-field" value="{{ $question->$fieldattachment->url() }}">
	                @if($errors->has($fieldattachment))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldattachment) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.title_helper') }}
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