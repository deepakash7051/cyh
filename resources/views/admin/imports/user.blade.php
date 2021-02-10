@extends('layouts.admin')
@section('content')
<?php 
	$coursename = config('app.locale').'_title';
    $languages = config('panel.available_languages');
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.csvImport') }} {{ trans('global.user.title') }}
            </h2>
            <div>
                <a href="{{ asset('imports/importuser.csv') }}" class="btnn btnn-s">
                    {{ trans('global.demo') }} {{ trans('global.downloadFile') }} 
                </a>
            </div>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.import.saveusers') }}" method="POST" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group mb-2 {{ $errors->has('attachment') ? 'has-error' : '' }}">
					<label>{{ trans('global.csv_file_to_import') }}*</label>
					<input class="frm-field" type="file" id="attachment" name="attachment" >
					@if($errors->has('attachment'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('attachment') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.import.fields.attachment_helper') }}
	                </p>
				</div>

	            <div>
	                <input class="btnn btnn-s" type="submit" value="{{ trans('global.import_data') }}">
	            </div>
				
			</form>
		</div>
		
	</div>
@endsection
@section('scripts')
@parent

@endsection