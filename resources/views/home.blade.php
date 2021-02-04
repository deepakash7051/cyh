@extends('layouts.front')

@section('content')

<?php 
    $locale = config('app.locale');
?>
<div class="category-wrap py-5 my-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 cat-head">
            <h2>{{ trans('global.pages.frontend.home.title') }}</h2>
            <a href="" class="btnn">{{ trans('global.pages.frontend.home.category_button') }}</a>
        </div>
        <div class="d-flex align-items-center justify-content-center flex-wrap cat-main">
            @if(count($courses) > 0)
                @foreach($courses as $course)
                @php 
                    $fieldtitle = $locale.'_title';
                    $fielddescription = $locale.'_description';
                @endphp
            <a href="" class="cat-box">
                <div class="cat-icon d-flex align-items-center justify-content-center"><img src="images/sicon1.png" alt=""></div>
                <h3>{{$course->$fieldtitle}}</h3>
                <p>{{$course->$fielddescription}}</p>
            </a>
                @endforeach
            @endif

        </div>
    </div>
</div>
@endsection
