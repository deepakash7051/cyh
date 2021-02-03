@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} {{ trans('global.user.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
            	<input type="hidden" name="is_phone_verified" value="1">
				<div class="form-group mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
					<label>{{ trans('global.user.fields.name') }}*</label>
					<input class="frm-field" type="text" id="name" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}">
					@if($errors->has('name'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('name') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.name_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
					<label>{{ trans('global.user.fields.email') }}*</label>
					<input class="frm-field" type="email" id="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}">
					@if($errors->has('email'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('email') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.email_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
					<label>{{ trans('global.user.fields.phone') }}*</label>
					<input class="frm-field" type="text" id="phone" name="phone" value="{{ old('phone', isset($user) ? $user->phone : '') }}">
					@if($errors->has('phone'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('phone') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.phone_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('password') ? 'has-error' : '' }}">
					<label>{{ trans('global.user.fields.password') }}*</label>
					<input class="frm-field" type="password" id="password" name="password" value="{{ old('password', isset($user) ? $user->password : '') }}">
					@if($errors->has('password'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('password') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.password_helper') }}
	                </p>
				</div>
				<div class="form-group mb-2 {{ $errors->has('roles') ? 'has-error' : '' }}">
	                <label for="roles">{{ trans('global.user.fields.roles') }}*
	                    <span class="btn btn-info btn-xs select-all">Select all</span>
	                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
	                <select name="roles[]" id="roles" class="frm-field select2" multiple="multiple">
	                    @foreach($roles as $id => $roles)
	                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
	                            {{ $roles }}
	                        </option>
	                    @endforeach
	                </select>
	                @if($errors->has('roles'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('roles') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.roles_helper') }}
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