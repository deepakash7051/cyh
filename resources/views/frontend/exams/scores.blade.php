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
                    @if($total==$score)
                    <img src="{{ asset('images/congrats.png') }}">
                    @else
                    <img src="{{ asset('images/try_again.png') }}">
                    @endif
                    <h4>{{ trans('global.pages.frontend.exam.completed_quiz') }}</h4>
                    <div class="btn-group btn-group-lg border rounded mb-3">
                        <button class="btn btn-success">{{$score}}</button>
                        <button class="btn btn-light ">{{$total}}</button>
                    </div>
                    <h6 class="mb-3">{{$scoremsg}} </h6>
                    <div>
                        @if(!empty($quiz->course_id))

                            @if($total!=$score)
                            <a href="{{route('courses.show', $quiz->course_id)}}">
                                <button class="btnn btnn-s btn-info">
                                {{ trans('global.pages.frontend.exam.learn_course_again') }}
                                </button>
                            </a>
                            @else
                            <a href="{{url('/home')}}">
                                <button class="btnn btnn-s btn-info">
                                {{ trans('global.back_to_home') }}
                                </button>
                            </a>
                            @endif

                        @else

                            @if($total!=$score)
                            <a href="{{route('modules.show', $quiz->module_id)}}">
                                <button class="btnn btnn-s btn-info">
                                {{ trans('global.pages.frontend.exam.learn_module_again') }}
                                </button>
                            </a>
                            @else
                            @if(!empty($resume_module))
                                <a href="{{route('modules.show', $resume_module)}}">
                                    <button class="btnn btnn-s btn-info">
                                    {{ trans('global.next') }} {{ trans('global.module.title_singular') }}
                                    </button>
                                </a>
                            @else
                                <a href="{{ url('/examrules/'.$finalquiz->id)}}">
                                <button class="btnn btnn-s btn-info">
                                {{ trans('global.pages.frontend.exam.final_assessment') }}
                                </button>
                            </a>
                            @endif
                            @endif


                        @endif
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