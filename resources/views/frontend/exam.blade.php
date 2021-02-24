@extends('layouts.front')
@section('content')
<?php 
    $locale = config('app.locale');
    $title = config('app.locale').'_title';
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
			<form>
				@if($quiz->questions()->exists())
					@php $q=1; @endphp
					@foreach($quiz->questions as $question)
						<div class="form-group mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
							<label>
								<span class="sorting_order mr-2">{{$q}}</span>
								 {{ $question->$title}}
							</label>
							@if($question->type=='0')
								<textarea class="frm-field" placeholder="{{ trans('global.pages.frontend.exam.enter_answer')}}"></textarea>
							@else
								<div class="row border p-2 m-1">
									@if($question->mcqoptions()->exists())
										@php 
											$option_a = $question->mcqoptions()->where('language', $locale)->where('option', 'a')->first();
											$option_b = $question->mcqoptions()->where('language', $locale)->where('option', 'b')->first();
											$option_c = $question->mcqoptions()->where('language', $locale)->where('option', 'c')->first();
											$option_d = $question->mcqoptions()->where('language', $locale)->where('option', 'd')->first();
										@endphp
										@if($question->option_label=='text')
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="a" name="{{'answer_'.$question->id}}"> 
											{{$option_a->value}}
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="b" name="{{'answer_'.$question->id}}"> 
											{{$option_b->value}}
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="c" name="{{'answer_'.$question->id}}"> 
											{{$option_c->value}}
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="d" name="{{'answer_'.$question->id}}"> 
											{{$option_d->value}}
										</div>

										@else 

										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="a" name="{{'answer_'.$question->id}}"> 
											<img src="{{$option_a->attachment_url}}" class="optionimg">
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="b" name="{{'answer_'.$question->id}}"> 
											<img src="{{$option_b->attachment_url}}" class="optionimg">
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="c" name="{{'answer_'.$question->id}}"> 
											<img src="{{$option_c->attachment_url}}" class="optionimg">
										</div>
										<div class="col-md-6 ">
											<input type="radio" class="m-2" value="d" name="{{'answer_'.$question->id}}"> 
											<img src="{{$option_d->attachment_url}}" class="optionimg">
										</div>
										@endif
									@endif
								</div>
							@endif
						</div>
					@php $q++; @endphp
					@endforeach
				@endif
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent

@endsection