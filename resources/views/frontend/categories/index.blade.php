@extends('layouts.front')

@section('content')

<?php 
    $title = config('app.locale').'_name';
    $description = config('app.locale').'_description';
?>
<div class="category-wrap py-5 my-2">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4 cat-head">
            <h2>{{ trans('global.pages.frontend.category.all_categories') }}</h2>
        </div>
        <div class="d-flex justify-content-center flex-wrap cat-main">
            @if(count($categories) > 0)
                @foreach($categories as $category)
                @php 
                @endphp
            <a href="{{url('/home/?category_id='.$category->id)}}" class="cat-box code-dialog" >
                <div class="cat-icon d-flex align-items-center justify-content-center">
                    <img src="" alt="">
                </div>
                <h3>{{$category->$title}}</h3>
                <p>
                    @if(strlen($category->$description) > 100)
                        {{substr($category->$description, 0 , 100).'...'}}
                    @else
                        {{$category->$description}}
                    @endif
                </p>
            </a>
                @endforeach
            @endif

        </div>
    </div>
</div>

@section('scripts')
@parent
<script >
    $(document).ready(function() {

    });
</script>
@endsection
@endsection
