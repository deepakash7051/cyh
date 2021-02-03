@extends('layouts.admin')
@section('content')

<?php 
  $languages = config('panel.available_languages');

?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.category.title') }}
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-custom table-bordered table-striped">
                <tbody>
                
                    
                    @if(count($languages) > 0)
                        @foreach($languages as $langKey => $langValue)
                            @php 
                                $fieldname = $langKey.'_name';
                                $fielddescription = $langKey.'_description';
                            @endphp
                    <tr>
                        <td>
                            {{ trans('global.category.fields.name') }} ({{$langValue}})
                        </td>
                        <td>
                            {{ $category->$fieldname }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('global.category.fields.description') }} ({{$langValue}})
                        </td>
                        <td>
                            {{ $category->$fielddescription }}
                        </td>
                    </tr>
                        @endforeach

                    @endif
                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection