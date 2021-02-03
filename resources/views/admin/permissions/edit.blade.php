@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} {{ trans('global.permission.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.permissions.update', [$permission->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group mb-2 {{ $errors->has('title') ? 'has-error' : '' }}">
					<label for="title">{{ trans('global.permission.fields.title') }}*</label>
					<input class="frm-field" type="text" id="title" name="title" value="{{ old('title', isset($permission) ? $permission->title : '') }}">
					@if($errors->has('title'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('title') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.permission.fields.title_helper') }}
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