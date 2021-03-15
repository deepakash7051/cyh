@extends('layouts.front')
@section('content')

<div class="category-wrap py-5 my-2">
        <!-- Page Content -->
    <div class="container">

      <div class="text-center">
        <h2 class="font-weight-bold "> {{trans('global.pages.frontend.exam.instructions')}}</h2>
        <p class="">
            {{trans('global.pages.frontend.exam.small_quiz_topic_understanding')}}
        </p>
        <p class="">
            {{trans('global.pages.frontend.exam.choose_carefully_chosen_not_change')}}
        </p>
        <div class="">
            <a href="{{url('/exam/'.$module->id)}}" class="btnn btnn-s">
              {{trans('global.pages.frontend.home.start_exam')}}
            </a>
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