@extends('layouts.front')
@section('content')
<?php 
    $locale = config('app.locale');
    $title = config('app.locale').'_title';
    $videoname = config('app.locale').'_video_file_name';
    $videourl = config('app.locale').'_video_url';
    $slideurl = config('app.locale').'_slide_url';
    $videocontenttype = config('app.locale').'_video_content_type';
    $videohtml = config('app.locale').'_video_html';
    $videolink = config('app.locale').'_video_link';
?>
<div class="category-wrap py-5 my-2">
        <!-- Page Content -->
    <div class="container">

      <div class="">
        <h2 class="my-4">{{$module->$title}}</h2>
        @if($module->link_attachment=='video')
          @if(!empty($module->$videolink))
              {!! $module->$videohtml !!}
          @else
          <video width="800" height="500" controls>
            <source src="{{$module->$videourl}}" type="{{$module->$videocontenttype}}">{{trans('global.pages.frontend.home.not_support_video')}}
          </video>
          @endif
        @else
          <div>
            <a href="{{$module->$slideurl}}">{{trans('global.view')}}</a>
          </div>
          
        @endif

        @if(!empty($resume_module))
        <form method="post" action="{{ route('attemptcourse')}}">
            @csrf
            <input type="hidden" name="resume_module" value="{{$resume_module}}">
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <input class="btnn btnn-s mt-3" type="submit" value="{{trans('global.pages.frontend.login.continue')}}">
        </form>
        @else
          @if($course->quiz()->exists() && $course->quiz->questions()->exists())
          <div>
            <a href="{{url('/examrules/'.$course->id)}}" class="btnn btnn-s">
              {{trans('global.pages.frontend.home.take_exam')}}
            </a>
          </div>
          @endif
        @endif

      </div>

      @if($course->modules()->exists() && $course->modules()->count() > 1)
        <h3 class="my-4">{{trans('global.related')}} {{trans('global.module.title')}}</h3>
        
        <div class="course-preview">
            <ul class="course-modules">
            @foreach($course->modules as $cmodule)
                @if($cmodule->id!=$module->id)
                <li> <a href="{{route('modules.show', $cmodule->id)}}">{{$cmodule->$title}} </a></li>
                @endif
            @endforeach
            </ul>
        </div>
        
      @endif

      <!-- /.row -->

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