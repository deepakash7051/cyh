@extends('layouts.admin')
@section('content')
<?php 
	$title = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<a href="{{ route('admin.quizzes.questions', $quiz_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} {{ trans('global.question.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group mb-2 {{ $errors->has('quiz_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.quiz.title_singular') }}*</label>

					<select class="frm-field select2" name="quiz_id" id="quiz_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($quizzes) > 0)
	                        @foreach($quizzes as $quiz)
	                            <option value="{{$quiz->id}}" 
	                            		{{ old('quiz_id', isset($question)) || $quiz_id == $quiz->id ? 'selected="selected"' : '' }}
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
					<label>{{ trans('global.question.fields.type') }}*</label>
					@php 
						$types = ['1' => trans('global.mcq'), '0' => trans('global.short_question') ];
					@endphp
					<select class="frm-field " name="type" id="type" >
						<option value="">{{trans('global.pleaseSelect')}}</option>
                        @foreach($types as $tykey => $tyvalue)
                        	<option value="{{$tykey}}" 
                        		{{ old('type')==$tykey  ? 'selected="selected"' : '' }}
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

				<!-- <div class="form-group mb-2 {{ $errors->has('visible') ? 'has-error' : '' }}" id="visiblesec">
					<label>{{ trans('global.question.fields.visible') }}*</label>
					@php 
						$visiblity = ['text' => trans('global.text'), 'image' => trans('global.image') ];
					@endphp
					<select class="frm-field " name="visible" id="visible" >
                        @foreach($visiblity as $vbkey => $vbvalue)
                        	<option value="{{$vbkey}}"
                        		{{ old('visible') ==$vbkey ? 'selected="selected"' : '' }}
                        	>{{$vbvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('visible'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('visible') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.visible_helper') }}
	                </p>
				</div> -->

				<div id="questitles">
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
	        	</div>

				<div id="quesattachments">
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
	                <input type="file" id="{{$fieldattachment}}" name="{{$fieldattachment}}" class="frm-field" value="{{ old($fieldattachment, isset($question) ? $question->$fieldattachment : '') }}">
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
	        	</div>

	        	<div id="mcqoptlbl" style="display:{{old('type')=='1' ? 'block' : 'none'}};">
		        	<div class="form-group mb-2 {{ $errors->has('option_label') ? 'has-error' : '' }}" >
						<label>{{ trans('global.question.fields.option_label') }}*</label>
						@php 
							$visiblity = ['image' => trans('global.image'), 'text' => trans('global.text') ];
						@endphp
						<select class="frm-field " name="option_label" id="option_label" >
							<option value="">{{trans('global.pleaseSelect')}}</option>
	                        @foreach($visiblity as $vbkey => $vbvalue)
	                        	<option value="{{$vbkey}}"
	                        		{{ old('option_label') ==$vbkey ? 'selected="selected"' : '' }}
	                        	>{{$vbvalue}}</option>
	                        @endforeach
	                    </select>

						@if($errors->has('option_label'))
	                    <em class="invalid-feedback">
		                        {{ $errors->first('option_label') }}
		                    </em>
		                @endif
		                <p class="helper-block">
		                    {{ trans('global.question.fields.option_label_helper') }}
		                </p>
					</div>
				</div>


	        	<div id="ques_textoptions" style="display:{{old('type')=='1' && old('option_label')=='text' ? 'block' : 'none'}};">

	        		<div class="form-group mb-4 mt-4 border border-secondary border-left-0 border-right-0 border-top-0">
		                <label for="">{{ trans('global.mcq_options') }}
		                	<span class="float-right">
		                		<input type="checkbox" id="sametextoption_for_all" name="sametextoption_for_all" class="mr-2" value="1" {{ old('sametextoption_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same')}}
		                	</span>
		                	
		                </label>
		            </div>
        		@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldoption_a = $langKey.'_option_a';
	                        $fieldoption_b = $langKey.'_option_b';
	                        $fieldoption_c = $langKey.'_option_c';
	                        $fieldoption_d = $langKey.'_option_d';
	                    @endphp
	            
                    	<div class="form-group mb-2 @if($langKey!='en') {{'otherlangtextoption'}} @endif" style="display: @if($langKey!='en' && old('sametextoption_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">

		                    <div class="row" >
		                        <div class="col-md-3 {{ $errors->has($fieldoption_a) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_a') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="text" id="{{$fieldoption_a}}" name="{{$fieldoption_a}}" value="{{ old($fieldoption_a, isset($question) ? $question->$fieldoption_a : '') }}" >

		                            @if($errors->has($fieldoption_a))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_a) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_a_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_b) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_b') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="text" id="{{$fieldoption_b}}" name="{{$fieldoption_b}}" value="{{ old($fieldoption_b, isset($question) ? $question->$fieldoption_b : '') }}" >

		                            @if($errors->has($fieldoption_b))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_b) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_b_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_c) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_c') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="text" id="{{$fieldoption_c}}" name="{{$fieldoption_c}}" value="{{ old($fieldoption_c, isset($question) ? $question->$fieldoption_c : '') }}" >

		                            @if($errors->has($fieldoption_c))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_c) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_c_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_d) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_d') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="text" id="{{$fieldoption_d}}" name="{{$fieldoption_d}}" value="{{ old($fieldoption_d, isset($question) ? $question->$fieldoption_d : '') }}" >

		                            @if($errors->has($fieldoption_d))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_d) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_d_helper') }}
					                </p>
		                        </div>
		                    </div> 
		                </div>

	                @endforeach
	            @endif
	        	</div>

	        	<div id="ques_imageoptions" style="display:{{old('type')=='1' && old('option_label')=='image' ? 'block' : 'none'}};">

	        		<div class="form-group mb-4 mt-4 border border-secondary border-left-0 border-right-0 border-top-0">
		                <label for="">{{ trans('global.mcq_options') }}
		                	<span class="float-right">
		                		<input type="checkbox" id="sameimgoption_for_all" name="sameimgoption_for_all" class="mr-2" value="1" {{ old('sameimgoption_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same')}}
		                	</span>
		                	
		                </label>
		            </div>
        		@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldoption_a = $langKey.'_option_attachment_a';
	                        $fieldoption_b = $langKey.'_option_attachment_b';
	                        $fieldoption_c = $langKey.'_option_attachment_c';
	                        $fieldoption_d = $langKey.'_option_attachment_d';
	                    @endphp
	            
                    	<div class="form-group mb-2 @if($langKey!='en') {{'otherlangimgoption'}} @endif" style="display: @if($langKey!='en' && old('sameimgoption_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">

		                    <div class="row" >
		                        <div class="col-md-3 {{ $errors->has($fieldoption_a) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_a') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="file" id="{{$fieldoption_a}}" name="{{$fieldoption_a}}" value="{{ old($fieldoption_a, isset($question) ? $question->$fieldoption_a : '') }}" >

		                            @if($errors->has($fieldoption_a))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_a) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_a_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_b) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_b') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="file" id="{{$fieldoption_b}}" name="{{$fieldoption_b}}" value="{{ old($fieldoption_b, isset($question) ? $question->$fieldoption_b : '') }}" >

		                            @if($errors->has($fieldoption_b))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_b) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_b_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_c) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_c') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="file" id="{{$fieldoption_c}}" name="{{$fieldoption_c}}" value="{{ old($fieldoption_c, isset($question) ? $question->$fieldoption_c : '') }}" >

		                            @if($errors->has($fieldoption_c))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_c) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_c_helper') }}
					                </p>
		                        </div>

		                        <div class="col-md-3 {{ $errors->has($fieldoption_d) ? ' is-invalid' : '' }}">
		                        	<label>{{ trans('global.question.fields.option_d') }} ({{$langValue}})*</label>
		                            <input class="frm-field" type="file" id="{{$fieldoption_d}}" name="{{$fieldoption_d}}" value="{{ old($fieldoption_d, isset($question) ? $question->$fieldoption_d : '') }}" >

		                            @if($errors->has($fieldoption_d))
				                    <em class="invalid-feedback">
					                        {{ $errors->first($fieldoption_d) }}
					                    </em>
					                @endif
					                <p class="helper-block">
					                    {{ trans('global.question.fields.option_d_helper') }}
					                </p>
		                        </div>
		                    </div> 
		                </div>

	                @endforeach
	            @endif
	        	</div>


	        	<div id="shtcrctans" style="display:{{old('type')=='1' ? 'none' : 'block'}};">

		            @if(count($languages) > 0)
		                @foreach($languages as $langKey => $langValue)
		                    @php 
		                        $fieldcorrectanswer = $langKey.'_correct_answer';
		                    @endphp
		            <div class="form-group mb-2 {{ $errors->has($fieldcorrectanswer) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlangtextans'}} @endif" style="display: @if($langKey!='en' && old('sametextans_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
		                <label for="{{$fieldcorrectanswer}}">{{ trans('global.question.fields.correct_answer') }} ({{$langValue}})*	@if($langKey=='en') 
		                	<span class="pull-right" style="float: right;">
		                		<input type="checkbox" id="sametextans_for_all" name="sametextans_for_all" class="mr-2" value="1" {{ old('sametextans_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same')}}
		                	</span>@endif
		                </label>
		                <input type="text" id="{{$fieldcorrectanswer}}" name="{{$fieldcorrectanswer}}" class="frm-field" value="{{ old($fieldcorrectanswer, isset($question) ? $question->$fieldcorrectanswer : '') }}">
		                @if($errors->has($fieldcorrectanswer))
		                    <em class="invalid-feedback">
		                        {{ $errors->first($fieldcorrectanswer) }}
		                    </em>
		                @endif
		                <p class="helper-block">
		                    {{ trans('global.question.fields.title_helper') }}
		                </p>
		            </div>

		                @endforeach
		            @endif
	        	</div>

	        	<div id="mcqcrctans" style="display:{{old('type')=='1' ? 'block' : 'none'}};">

        		@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldcorrectanswer = $langKey.'_mcqcorrect_answer';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldcorrectanswer) ? 'has-error' : '' }}  @if($langKey!='en') {{'otherlangmcqans'}} @endif" style="display: @if($langKey!='en' && old('samemcqans_for_all')=='1') {{'none'}} @else {{'block'}} @endif;">
	                <label for="{{$fieldcorrectanswer}}">{{ trans('global.question.fields.correct_answer') }} ({{$langValue}})*	@if($langKey=='en') 
	                	<span class="pull-right" style="float: right;">
	                		<input type="checkbox" id="samemcqans_for_all" name="samemcqans_for_all" class="mr-2" value="1" {{ old('samemcqans_for_all') == '1' ? 'checked="checked"' : '' }}>{{trans('global.use_same')}}
	                	</span>@endif
	                </label>
	                <select id="{{$fieldcorrectanswer}}" name="{{$fieldcorrectanswer}}" class="frm-field" >
	                	<option value="">{{trans('global.pleaseSelect')}}</option> 
	                	<option value="a" {{ old($fieldcorrectanswer, isset($question))=='a' ? 'selected="selected"' : '' }} >{{trans('global.question.fields.option_a')}}</option>
	                	<option value="b" {{ old($fieldcorrectanswer, isset($question))=='b' ? 'selected="selected"' : '' }} >{{trans('global.question.fields.option_b')}}</option>
	                	<option value="c" {{ old($fieldcorrectanswer, isset($question))=='c' ? 'selected="selected"' : '' }} >{{trans('global.question.fields.option_c')}}</option>
	                	<option value="d" {{ old($fieldcorrectanswer, isset($question))=='d' ? 'selected="selected"' : '' }} >{{trans('global.question.fields.option_d')}}</option>
	                </select>
	                
	                @if($errors->has($fieldcorrectanswer))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldcorrectanswer) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.question.fields.title_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif
	        		
	        	</div>



	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.question.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}">{{$stvalue}}</option>
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