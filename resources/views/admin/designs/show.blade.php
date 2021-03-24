@extends('layouts.admin')
@section('content')

<?php 
  $languages = config('panel.available_languages');

?>

<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
               Portfolio Images
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="row">
        @if( count($designs) > 0 )

            @foreach( $designs as $design )
                <div class="col-md-4 p-4">
                    <div class="thumbnail">
                        <img src="{{ $design->attachment->url() }}" alt="Lights" style="width:100%">
                        <div class="caption">
                            <form action="{{ route('admin.deleteDesign', [$design->id]) }}" method="GET">
                                @csrf
                                <input class="btn btn-link text-danger" id="submit" type="submit" value="Remove">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        @endif
  

</div>
    </div>

@section('scripts')
    @parent
    <script>

    </script>
@endsection

@endsection