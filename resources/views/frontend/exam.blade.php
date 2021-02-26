@extends('layouts.front')
@section('content')
<?php 
    $locale = config('app.locale');
    $title = config('app.locale').'_title';
    $filename = config('app.locale').'_attachment_file_name';
    $attachmenturl = config('app.locale').'_attachment_url';
?>
<div class="fixedbar">
	<ul>
		@if($course->quizzes()->exists())
			@foreach($course->quizzes as $cquiz)
				<li class="{{$cquiz->id==$quiz->id ? 'active' : ''}}"><a href="{{url('/exam/'.$course->id.'/?quiz_id='.$cquiz->id)}}"><i class="fab fa-quinscape"></i> {{$cquiz->$title}}</a></li>
			@endforeach
		@endif
	</ul>
</div>
<div class="dashboard-wrap">
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0 main-font-color">
                {{ $quiz->$title.' > ' }}  {{ trans('global.question.title') }}
            </h2>
        </div>
		<div class="form-wrap">
			<form method="post" action="{{ route('attempts.store') }}">
				@csrf
				<input type="hidden" name="quiz_id" value="{{$quiz->id}}">

				@if($quiz->questions()->exists())
					@php $q=1; @endphp
					@foreach($quiz->questions as $question)
						<div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
							<label>
								<span class="sorting_order mr-2">{{$q}}</span>
								 {{$question->$title}}  

								 @if(!empty($question->$filename))
								 	<a href="javascript:void(0)" style="cursor: pointer;" class="question_img float-right mr-3" data-link="{{$question->$attachmenturl}}" data-title="{{$question->$title}}">{{trans('global.view_file')}}</a>
								 @endif
							</label>
							@if($question->type=='0')
								<textarea class="frm-field" placeholder="{{ trans('global.pages.frontend.exam.enter_answer')}}" name="{{'question_'.$question->id}}"></textarea>
							@else
								<div class="row border p-2 m-1">
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
										<div class="col-md-6 ">
											<span> {{$option_keys[$optkeys]}}</span>
											<input type="radio" class="m-2" value="{{$options[$optkeys]->option}}" name="{{'question_'.$question->id}}"> 
											{{$options[$optkeys]->value}}
										</div>

										@else 
										
										<div class="col-md-6 ">
											<span> {{$option_keys[$optkeys]}}</span>
											<input type="radio" class="m-2" value="{{$options[$optkeys]->option}}" name="{{'question_'.$question->id}}"> 
											<img src="{{$option_a->attachment_url}}" class="optionimg">
										</div>
											@endif
										@endforeach
											<input type="radio" style="display: none;" value="" name="{{'question_'.$question->id}}" checked>
									@endif
								</div>
							@endif
						</div>
					@php $q++; @endphp
					@endforeach
				@endif

				<div>
	                <input class="btnn btnn-s" type="submit" value="{{ trans('global.save') }}">
	            </div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade " id="QuestionAttachment" tabindex="-1" role="dialog" aria-labelledby="QuestionAttachmentTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="QuestionAttachmentTitle">
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
    </div>
  </div>
</div>
@section('scripts')
@parent
<script >
    $(document).ready(function() {

        $(".question_img").click(function(){
            var imglink = $(this).attr('data-link');
            var title = $(this).attr('data-title');
            $('#QuestionAttachment').find('#QuestionAttachmentTitle').html(title);
            $('#QuestionAttachment').find('.modal-body').html('<img src="'+imglink+'">'); 
            $('#QuestionAttachment').modal('show');
        });

    });

</script>
@endsection

@endsection