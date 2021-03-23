@extends('layouts.admin')
@section('content')

<?php 
  $languages = config('panel.available_languages');

?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
               Show Design
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-custom table-bordered table-striped">
                <tbody>                

                @if($design)
                    <tr>
                        <td>
                            Title
                        </td>
                        <td>
                            {{ $design->title }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Image
                        </td>
                        <td>
                            <img src="{{ URL::to('/') }}/designs/{{$design->filename}}" width="100" alt="">
                        </td>
                    </tr>

                    @endif
                
            </tbody>
                
            </table>
        </div>
    </div>

@endsection