@extends('layouts.admin')
@section('content')

<?php 
  $title = config('app.locale').'_title';
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
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
                                    <td>{{$value}}</td>
                            @endforeach
                        @endif
                    </tr>

                    @if($question->visible=='text')
                        <tr>
                            <td>{{trans('global.question.fields.title')}}</td>
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
                            <td>{{trans('global.question.fields.title')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $key => $value)
                                    @php $attachment_url = $key.'_attachment_url'; @endphp
                                        <td><img height="50" src="{{ $question->$attachment_url }}"> </td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                    @if($question->type=='1' && $question->visible=='text' && $question->mcqoption()->exists())
                        <tr>
                            <td>{{trans('global.question.fields.option_a')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $fieldoption_a = $langKey.'_option_a';
                                    @endphp
                                        <td>{{$question->mcqoption->$fieldoption_a}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>{{trans('global.question.fields.option_b')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $fieldoption_b = $langKey.'_option_b';
                                    @endphp
                                        <td>{{$question->mcqoption->$fieldoption_b}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>{{trans('global.question.fields.option_c')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $fieldoption_c = $langKey.'_option_c';
                                    @endphp
                                        <td>{{$question->mcqoption->$fieldoption_c}}</td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>{{trans('global.question.fields.option_d')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $langKey => $value)
                                    @php 
                                        $fieldoption_d = $langKey.'_option_d';
                                    @endphp
                                        <td>{{$question->mcqoption->$fieldoption_d}}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endif

                        <tr>
                            <td>{{trans('global.question.fields.correct_answer')}}</td>
                            @if(count($languages) > 0)
                                @foreach($languages as $key => $value)
                                    @php $correctanswer = $key.'_correct_answer'; @endphp
                                        <td>{{$question->$correctanswer}}</td>
                                @endforeach
                            @endif
                        </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection