@extends('layouts.admin')
@section('content')
<?php 
    $CountryCodesJson = file_get_contents(base_path('uploads/CountryCodes.json'));
    $CountryCodes = json_decode($CountryCodesJson);
    $coursename = config('app.locale').'_title';
    $categoryname = config('app.locale').'_name';
?>
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.edit') }} {{ trans('global.user.title_singular') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<input type="hidden" name="user_id" value="{{$user->id}}">
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
				<div class="form-group mb-2">
                    <div class="row">
                        <div class="col-md-3 {{ $errors->has('isd_code') ? ' is-invalid' : '' }}">
                        	<label>{{ trans('global.user.fields.isd_code') }}*</label>
                            <select class="frm-field select2" name="isd_code" id="isd_code" >
                                @foreach($CountryCodes as $CountryCode)
                                    <option value="{{$CountryCode->dial_code}}" 
                                    	{{ $user->isd_code == $CountryCode->dial_code ? 'selected="selected"' : '' }}>
                                        {{$CountryCode->dial_code.' ('.$CountryCode->code.')'}}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('isd_code'))
		                    <em class="invalid-feedback">
			                        {{ $errors->first('isd_code') }}
			                    </em>
			                @endif
			                <p class="helper-block">
			                    {{ trans('global.user.fields.isd_code_helper') }}
			                </p>
                        </div>
                        <div class="col-md-9 {{ $errors->has('phone') ? ' is-invalid' : '' }}">
                        	<label>{{ trans('global.user.fields.phone') }}*</label>
                            <input class="frm-field onlynumeric" type="text" id="phone" name="phone" value="{{ old('phone', isset($user) ? $user->phone : '') }}" >

                            @if($errors->has('phone'))
		                    <em class="invalid-feedback">
			                        {{ $errors->first('phone') }}
			                    </em>
			                @endif
			                <p class="helper-block">
			                    {{ trans('global.user.fields.phone_helper') }}
			                </p>
                        </div>
                    </div> 
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

				<div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
					<label>{{ trans('global.user.fields.status') }}</label>
					@php 
						$status = ['1' => trans('global.active'), '0' => trans('global.inactive')];
					@endphp
					<select class="frm-field " name="status" id="status" >
                        @foreach($status as $stkey => $stvalue)
                        	<option value="{{$stkey}}" 
                        		{{ $user->status == $stkey ? 'selected="selected"' : '' }}
                        	>{{$stvalue}}</option>
                        @endforeach
                    </select>

					@if($errors->has('status'))
                    <em class="invalid-feedback">
	                        {{ $errors->first('status') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.status_helper') }}
	                </p>
				</div>

				<div class="form-group mb-2 {{ $errors->has('role') ? 'has-error' : '' }}">
	                <label for="role">{{ trans('global.user.fields.role') }}*
	                <select name="role" id="role" class="frm-field select2">
	                    @foreach($roles as $id => $roles)
	                        <option value="{{ $id }}" 
	                        	{{ isset($user) && $user->roles->contains($id) ? 'selected' : '' }}
	                        >
	                            {{ $roles }}
	                        </option>
	                    @endforeach
	                </select>
	                @if($errors->has('role'))
	                    <em class="invalid-feedback">
	                        {{ $errors->first('role') }}
	                    </em>
	                @endif
	                <p class="helper-block">
	                    {{ trans('global.user.fields.role_helper') }}
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

    $('#user_categories').on('change', function() {

        var categories = $(this).val();
            if(categories) {
	            $.ajax({
	                url: "{{url('/admin/users/courses/')}}",
	                type: "GET",
	                data: {'categories':categories},
	                dataType: "json",
	                success:function(data) {
	                	$('#user_courses').empty();
		                $.each(data, function(key, value) {
		                    $('#user_courses').append('<option value="'+ value.id +'">'+ value.{{$coursename}} +'</option>');
		                });
	                }
	            });
	        } else {
	        	$('#courses').empty();
	        }
   });

    
    });
</script>
@endsection

@endsection