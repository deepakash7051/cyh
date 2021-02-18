@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
        <a href="{{ route('admin.quizzes.questions', $question->quiz_id)}}">
            <i class="fas fa-arrow-left"></i> {{ trans('global.back') }}
        </a>
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.show') }} {{ trans('global.question.title_singular') }}
            </h2>
        </div>
        <div class="search-wrp">
            <div class="d-flex justify-content-between"></div>
        </div>
        <div class="table-responsive table-responsive-md">
            <table class="table table-hover table-bordered table-striped">
                <tbody>

                    <tr>
                        <td>
                            {{ trans('global.course.title_singular') }}
                        </td>
                        <td colspan="4">
                            {{ $question->course->$title }}
                        </td>
                    </tr>
                    

                    <tr>
                        <td>
                            {{ trans('global.quiz.title_singular') }}
                        </td>
                        <td colspan="4">
                            {{ $question->quiz->$title }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.question.fields.type') }}
                        </td>
                        <td colspan="4">
                            @if($question->type=='1')
                                {{ trans('global.mcq') }} 
                            @else
                                {{ trans('global.short_question') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.question.fields.visible') }}
                        </td>
                        <td colspan="4">
                            @if($question->visible=='text')
                                {{ trans('global.text') }} 
                            @else
                                {{ trans('global.image') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ trans('global.sorting_order') }}
                        </td>
                        <td>
                            {{ $question->place }}
                        </td>
                    </tr>

            </tbody>
                
            </table>
            <table class="table table-hover table-bordered table-striped">
                <tbody>
                    <tr>
                        <td></td>
                        @if(count($languages) > 0)
                            @foreach($languages as $key => $value)
                                @php $fieldtitle = $key.'_title'; @endphp
                                    <td class="font-weight-bold">{{$value}}</td>
                            @endforeach
                        @endif
                    </tr>

                    @if($question->visible=='text')
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.title')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $key => $value)
                                    @php $fieldtitle = $key.'_title'; @endphp
                                        <td>{{$question->$fieldtitle}}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                    @if($question->visible=='image')
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.title')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $key => $value)
                                    @php $attachment_url = $key.'_attachment_url'; @endphp
                                        <td><img height="50" src="{{ $question->$attachment_url }}"> </td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                    @if($question->type=='1' && $question->option_label=='text' && $question->mcqoptions()->exists())
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_a')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_a = $question->mcqoptions()->where('language', $langKey)->where('option', 'a')->first()->value;
                                    @endphp
                                        <td>{{$option_a}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_b')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_b = $question->mcqoptions()->where('language', $langKey)->where('option', 'b')->first()->value;
                                    @endphp
                                        <td>{{$option_b}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_c')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_c = $question->mcqoptions()->where('language', $langKey)->where('option', 'c')->first()->value;
                                    @endphp
                                        <td>{{$option_c}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_d')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_d = $question->mcqoptions()->where('language', $langKey)->where('option', 'd')->first()->value;
                                    @endphp
                                        <td>{{$option_d}}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                    @if($question->type=='1' && $question->option_label=='image' && $question->mcqoptions()->exists())
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_a')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_a = $question->mcqoptions()->where('language', $langKey)->where('option', 'a')->first();
                                    @endphp
                                        <td><img height="50" src="{{ $option_a->attachment_url }}"></td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_b')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_b = $question->mcqoptions()->where('language', $langKey)->where('option', 'b')->first();
                                    @endphp
                                        <td><img height="50" src="{{ $option_b->attachment_url }}"></td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_c')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_c = $question->mcqoptions()->where('language', $langKey)->where('option', 'c')->first();
                                    @endphp
                                        <td><img height="50" src="{{ $option_c->attachment_url }}"></td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.option_d')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $option_d = $question->mcqoptions()->where('language', $langKey)->where('option', 'd')->first();
                                    @endphp
                                        <td><img height="50" src="{{ $option_d->attachment_url }}"></td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                        <tr>
                            <td class="font-weight-bold">{{trans('global.question.fields.correct_answer')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $key => $value)
                                    @php $correctanswer = $key.'_correct_answer'; @endphp
                                        <td>
                                            @if($question->type=='1'){{trans('global.option')}} @endif {{ucfirst($question->$correctanswer)}}
                                        </td>
                                @endforeach
                            @endif
                        </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection