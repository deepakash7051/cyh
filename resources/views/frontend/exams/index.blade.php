@extends('layouts.front')

@section('content')

<?php 
    $locale = config('app.locale');
    $title = config('app.locale').'_title';
    $filename = config('app.locale').'_attachment_file_name';
    $attachmenturl = config('app.locale').'_attachment_url';
    $time_limit = explode(':', $quiz->time_limit);
    $timer =  date('F d, Y H:i:s', strtotime('+'.$time_limit[0].' hour +'.$time_limit[1].' minutes', strtotime(date('F d, Y H:i:s'))));

    $now = date('Y-m-d H:i:s');

?>
<div class="category-wrap py-5 my-2">
    <div class="container">
    	<div class="d-flex justify-content-center row mb-5">
    		<div class="col-md-12 col-lg-12">
    			<div class="border">
					<div class="question bg-white p-3 border-bottom">
	                    <div class="d-flex flex-row justify-content-between align-items-center mcq">
	                        <h4>{{$quiz->$title}} {{ trans('global.quiz.title_singular') }}</h4>
	                        <span id="demo"></span>
	                        <span>
	                        	<button class="btn btn-primary d-flex align-items-center btn-danger" id="exitQuiz">{{ trans('global.exit') }}</button>
	                        </span>
	                    </div>
	                </div>
    			</div>
    		</div>
    	</div>

    	<form method="post" action="{{ route('attempts.store') }}" id="saveQuiz">
    		@csrf
			<input type="hidden" name="quiz_id" value="{{$quiz->id}}">
	    <div class="d-flex justify-content-center row" id="quizQuestions">
	    	@if($quiz->questions()->count() > 0)
	    	@php 
	    	$q = 1; 
	    	$firstQuestion = $quiz->questions()->first();
	    	@endphp
	    	@foreach($quiz->questions as $question)
	        <div class="col-md-12 col-lg-12 questiongroup" id="Question_{{$question->id}}"  f="{{$firstQuestion->id}}" Q="{{$question->id}}" >
	            <div class="border">
	                <div class="question bg-white p-3 border-bottom">
	                    <div class="d-flex flex-row justify-content-between align-items-center mcq">
	                        <h4>@if($question->type==0) {{ trans('global.short_question') }} @else {{ trans('global.mcq') }} @endif</h4>
	                    </div>
	                </div>
	                <div class="question bg-white p-3 border-bottom">
	                    <div class="d-flex flex-row align-items-center question-title">
	                        <h3 class="text-danger">Q.{{$q}}</h3>
	                        <h5 class="mt-1 ml-2">{{$question->$title}}</h5>
	                    </div>
	                    @if($question->type==1)

	                    	@if($question->mcqoptions()->exists())
	                    	@php
								$option_keys = ["(a)","(b)","(c)","(d)"]; 
								$option_a = $question->mcqoptions()->where('language', $locale)->where('option', 'a')->first();
								$option_b = $question->mcqoptions()->where('language', $locale)->where('option', 'b')->first();
								$option_c = $question->mcqoptions()->where('language', $locale)->where('option', 'c')->first();
								$option_d = $question->mcqoptions()->where('language', $locale)->where('option', 'd')->first();

								$options = [$option_a, $option_b, $option_c, $option_d];
								shuffle($options);
							@endphp

							@foreach($options as $optkeys => $optval)
								@if($question->option_label=='text')
			                    <div class="ans ml-2">
			                        <label class="radio"> 
			                        	<input type="radio" value="{{$options[$optkeys]->option}}" name="{{'question_'.$question->id}}"> <span>{{$options[$optkeys]->value}}</span>
			                        </label>
			                    </div>
	                    		@else

		                		<div class="ans ml-2">
			                        <label class="radio"> 
			                        	<input type="radio" value="{{$options[$optkeys]->option}}" name="{{'question_'.$question->id}}"> <span><img src="{{$option_a->attachment_url}}" class="optionimg"></span>
			                        </label>
			                    </div>
	                    		@endif

	                    	@endforeach
	                    	<input type="radio" style="display: none;" value="" name="{{'question_'.$question->id}}" checked="checked">

	                    	@endif
	                    
	                    @else
	                    <div class="ans ml-2">
	                        <input type="text" class="frm-field" name="{{'question_'.$question->id}}" value=""> 
	                    </div>
	                    @endif

	                </div>
	                <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white" >
	                	@if($firstQuestion->id != $question->id)
	                	<button class="btn btn-primary d-flex align-items-center btn-info backQuestion" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;{{ trans('global.back') }}</button>
	                	@endif

	                	@if($quiz->questions()->count() != $q)
	                	<button class="btn btn-primary border-success align-items-center btn-success nextQuestion float-right" type="button">{{ trans('global.next') }}<i class="fa fa-angle-right ml-2"></i></button>
	                	@endif

	                	@if($quiz->questions()->count() == $q)
	                	<button class="btn btn-primary border-success align-items-center btn-success float-right" type="button" id="finishQuiz">{{ trans('global.finish') }}</button>
	                	@endif

	                </div>
	            </div>
	        </div>
	        @php $q++; @endphp
	        @endforeach
	        @endif
	    </div>
		</form>

	</div>
</div>

@section('scripts')
@parent
<script >
$(document).ready(function() {
	$("#quizQuestions .questiongroup").each(function(e) {
        if (e != 0)
            $(this).hide();
    });

	$(".backQuestion").click(function(){
        if ($("#quizQuestions .questiongroup:visible").prev().length != 0)
            $("#quizQuestions .questiongroup:visible").prev().show().next().hide();
        else {
            $("#quizQuestions .questiongroup:visible").hide();
            $("#quizQuestions .questiongroup:last").show();
        }
        return false;
    });

    $(".nextQuestion").click(function(){
        if ($("#quizQuestions .questiongroup:visible").next().length != 0)
            $("#quizQuestions .questiongroup:visible").next().show().prev().hide();
        else {
            $("#quizQuestions .questiongroup:visible").hide();
            $("#quizQuestions .questiongroup:first").show();
        }
        return false;
    });

    $("#exitQuiz").click(function(){
    	if(confirm("{{ trans('global.pages.frontend.exam.exit_confirm') }}")){
    		$("#saveQuiz").submit();
    	} else {
    		return false;
    	}
    });


    $("#finishQuiz").click(function(){
    	if(confirm("{{ trans('global.pages.frontend.exam.finish_confirm') }}")){
    		$("#saveQuiz").submit();
    	} else {
    		return false;
    	}
    	
    });

});
</script>

<script>
// Set the date we're counting down to
var countDownDate = new Date("{{$timer}}").getTime();
var now = new Date("{{$now}}").getTime();
var distance = countDownDate - now;
//alert(countDownDate)
// Update the count down every 1 second
var x = setInterval(function() {
distance = distance - 1000;
  // Get today's date and time

  //alert(now)
  // Find the distance between now and the count down date
 

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    $("#saveQuiz").submit();
  }
}, 1000);
</script>
@endsection
@endsection
