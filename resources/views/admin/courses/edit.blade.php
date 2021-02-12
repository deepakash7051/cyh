@extends('layouts.admin')
@section('content')
<?php 
	$categoryname = config('app.locale').'_name';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.course.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.courses.update', [$course->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="form-group mb-2 {{ $errors->has('category_id') ? 'has-error' : '' }}">
					<label>{{ trans('global.category.title_singular') }}*</label>

					<select class="frm-field select2" name="category_id" id="category_id" >
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
	                    @if(count($categories) > 0)
	                        @foreach($categories as $category)
	                            <option value="{{$category->id}}" {{ $category->id == $course->category_id ? 'selected="selected"' : '' }}>
	                                {{$category->$categoryname}}
	                            </option>
	                        @endforeach
	                    @endif
                    </select>

					@if($errors->has('category_id'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('category_id') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.category_id_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2 {{ $errors->has('ref_code') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.fields.ref_code') }}*</label>
					<input class="frm-field" type="text" id="ref_code" name="ref_code" value="{{ old('ref_code', isset($course) ? $course->ref_code : '') }}">
					@if($errors->has('ref_code'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('ref_code') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.ref_code_helper') }}
	                </p>
				</div>
				
				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_title';
	                        $fielddescription = $langKey.'_description';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.course.fields.title') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($course) ? $course->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.title_helper') }}
	                </p>
	            </div>

	            <div class="form-group {{ $errors->has($fielddescription) ? 'has-error' : '' }}">
	                <label for="{{$fielddescription}}">{{ trans('global.course.fields.description') }} ({{$langValue}})</label>
	                <textarea id="{{$fielddescription}}" name="{{$fielddescription}}" class="frm-field" >{{ old($fielddescription, isset($course) ? $course->$fielddescription : '') }}</textarea>
	                @if($errors->has($fielddescription))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fielddescription) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.description_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('price') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.fields.price') }}*</label>
					<input class="frm-field decimalp2" type="text" id="price" name="price" value="{{ old('price', isset($course) ? $course->price : '') }}">
					@if($errors->has('price'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('price') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.price_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2">
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('isd_code') ? ' is-invalid' : '' }}">
                        	<label>{{ trans('global.course.fields.duration') }}*</label>
							<input class="frm-field decimalp2" type="text" id="duration" name="duration" value="{{ old('duration', isset($course) ? $course->duration : '') }}">
							@if($errors->has('duration'))
		                    <em class="invalid-feedback">
			                        {{ $errors->first('duration') }}
			                    </em>
			                @endif
			                <p class="helper-block">
			                    {{ trans('global.course.fields.duration_helper') }}
			                </p>
                        </div>
                        <div class="col-md-6 {{ $errors->has('duration_type') ? ' is-invalid' : '' }}">
                        	<label>{{ trans('global.course.fields.duration_type') }}*</label>
                            <select class="frm-field select2" name="duration_type" id="duration_type" >
                            	@php 
									$DurationTypes = ['1' => trans('global.hour'), '2' => trans('global.day'), '3' => trans('global.month'), '4' => trans('global.year')];
								@endphp
                                @foreach($DurationTypes as $DTkey => $DTvalue)
                                    <option value="{{$DTkey}}" 
                                    	{{ $course->duration_type == $DTkey ? 'selected="selected"' : '' }}
                                    >
                                        {{$DTvalue}}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('duration_type'))
		                    <em class="invalid-feedback">
			                        {{ $errors->first('duration_type') }}
			                    </em>
			                @endif
			                <p class="helper-block">
			                    {{ trans('global.course.fields.duration_type_helper') }}
			                </p>
                        </div>
                    </div> 
                </div>

				<div class="form-group mb-2 {{ $errors->has('seats') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.fields.seats') }}</label>
					<input class="frm-field onlynumeric" type="text" id="seats" name="seats" value="{{ old('seats', isset($course) ? $course->seats : '') }}">
					@if($errors->has('seats'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('seats') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.seats_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.course.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive') ];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $course->status == $stkey ? 'selected="selected"' : '' }}
                        	>{{$stvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('status'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('status') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.status_helper') }}
	                </p>
				</div>

				<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
	                <label for="lng">{{ trans('global.course.fields.image') }}</label>
	                <div><input type="file" id="image" name="image" ></div>
	                @if($errors->has('image'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('image') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.course.fields.image_helper') }}
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