@extends('layouts.admin')
@section('content')

<?php 
    $coursename = config('app.locale').'_title';
    $categoryname = config('app.locale').'_name';
?>
<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.user.title_singular') }}
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-custom table-bordered table-striped">
                <tbody>
                <tr>
                    <td>
                        {{ trans('global.user.fields.name') }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('global.user.fields.email') }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('global.user.fields.phone') }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                </tr>
                
                <!-- <tr>
                    <td>
                        {{ trans('global.user.fields.email_verified_at') }}
                    </td>
                    <td>
                        {{ $user->email_verified_at }}
                    </td>
                </tr> -->
                <tr>
                    <td>
                        {{ trans('global.user.fields.roles') }}
                    </td>
                    <td>
                        @foreach($user->roles as $id => $roles)
                            <span class="badge badge-info">{{ $roles->title }}</span>
                        @endforeach
                    </td>
                </tr>
            </tbody>
                
            </table>
        </div>
    </div>

@endsection