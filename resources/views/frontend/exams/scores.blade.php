@extends('layouts.front')
@section('content')

@php 
$scoremsg = trans('global.pages.frontend.exam.score_message');
$scoremsg = str_replace('{score}', $score, $scoremsg);
$scoremsg = str_replace('{total}', $total, $scoremsg);
@endphp 

<div class="category-wrap py-5 my-2">
        <!-- Page Content -->
    <div class="container">

        <div class="d-flex justify-content-center row mb-5">
            <div class="col-md-12 col-lg-12">
                <div class="text-center bg-white p-3">
                    <img src="{{ asset('images/try_again.png') }}">
                    <h4>{{ trans('global.pages.frontend.exam.completed_quiz') }}</h4>
                    <div class="btn-group btn-group-lg border rounded mb-3">
                        <button class="btn btn-success">{{$score}}</button>
                        <button class="btn btn-light ">{{$total}}</button>
                    </div>
                    <h6 class="mb-3">{{$scoremsg}} </h6>
                    <div>
                        <a href="route('courses.show', $quiz->course_id)">
                        <button class="btn btn-info">
                        {{ trans('global.pages.frontend.exam.start_course_again') }}
                        </button>
                        </a>
                    </div>

                </div>
            </div>
        </div>


    </div>
    <!-- /.container -->
</div>
@section('scripts')
@parent
<script >
$(document).ready(function() {

});
</script>
@endsection

@endsection