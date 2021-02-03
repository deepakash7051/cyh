@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.role.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.roles.update', [$role->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="form-group mb-2 {{ $errors->has('slug') ? 'has-error' : '' }}">
					<label for="title">{{ trans('global.role.fields.slug') }}*</label>
					<input class="frm-field" type="text" id="slug" name="slug" value="{{ old('slug', isset($role) ? $role->slug : '') }}">
					@if($errors->has('slug'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('slug') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.role.fields.slug_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('title') ? 'has-error' : '' }}">
					<label for="title">{{ trans('global.role.fields.title') }}*</label>
					<input class="frm-field" type="text" id="title" name="title" value="{{ old('title', isset($role) ? $role->title : '') }}">
					@if($errors->has('title'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('title') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.role.fields.title_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('permissions') ? 'has-error' : '' }}">
					<label for="permissions">{{ trans('global.role.fields.permissions') }}*
	                    <span class="btn btn-info btn-xs select-all">Select all</span>
	                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span>
	                </label>
	                <select name="permissions[]" id="permissions" class="frm-field select2" multiple="multiple">
	                    @foreach($permissions as $id => $permissions)
	                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
	                            {{ $permissions }}
	                        </option>
	                    @endforeach
	                </select>
					@if($errors->has('permissions'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('permissions') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.role.fields.permissions_helper') }}
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