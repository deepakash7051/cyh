@extends('layouts.admin')
@section('content')


<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.role.title_singular') }}
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
                       {{ trans('global.role.fields.title') }}
                    </td>
                    <td>
                        {{ $role->title }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ trans('global.role.fields.permissions') }}
                    </td>
                    <td>
                         @foreach($role->permissions as $id => $permissions)
                            <span class="badge badge-info">{{ $permissions->title }}</span>
                        @endforeach
                    </td>
                </tr>
                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection