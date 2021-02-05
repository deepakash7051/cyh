@extends('layouts.admin')
@section('content')
<?php 
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.category.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.categories.update', [$category->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				@if(count($languages) > 0)
	                @foreach($languages as $langKey => $langValue)
	                    @php 
	                        $fieldname = $langKey.'_name';
	                        $fielddescription = $langKey.'_description';
	                    @endphp
	            <div class="form-group mb-2 {{ $errors->has($fieldname) ? 'has-error' : '' }}">
	                <label for="{{$fieldname}}">{{ trans('global.category.fields.name') }} ({{$langValue}})*</label>
	                <input type="text" id="{{$fieldname}}" name="{{$fieldname}}" class="frm-field" value="{{ old($fieldname, isset($category) ? $category->$fieldname : '') }}">
	                @if($errors->has($fieldname))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fieldname) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.category.fields.name_helper') }}
	                </p>
	            </div>

	            <div class="form-group {{ $errors->has($fielddescription) ? 'has-error' : '' }}">
	                <label for="{{$fielddescription}}">{{ trans('global.category.fields.description') }} ({{$langValue}})</label>
	                <textarea id="{{$fielddescription}}" name="{{$fielddescription}}" class="frm-field" >{{ old($fielddescription, isset($category) ? $category->$fielddescription : '') }}</textarea>
	                @if($errors->has($fielddescription))
	                    <em class="invalid-feedback">
	                        {{ $errors->first($fielddescription) }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.category.fields.description_helper') }}
	                </p>
	            </div>

	                @endforeach
	            @endif

	            <div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.category.fields.status') }}</label>
					@php 
						$status = ['1' => 'Active', '0' => 'Inactive'];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $category->status == $stkey ? 'selected="selected"' : '' }}
                        	>{{$stvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('status'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('status') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.category.fields.status_helper') }}
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