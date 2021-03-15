@extends('layouts.front')
@section('content')
<?php 
    $locale = config('app.locale');
    $title = config('app.locale').'_title';
    $description = config('app.locale').'_description';
    $filename = config('app.locale').'_attachment_file_name';
    $attachmenturl = config('app.locale').'_attachment_url';
    $content_type = config('app.locale').'_attachment_content_type';
?>
<div class="category-wrap py-5 my-2">
        <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-md-3">
            @if(!empty($course->image_file_name))
                <img class="img-fluid" src="{{ $course->course_image_url }}" alt="">
            @else
                <img class="img-fluid" src="{{ asset('images/default_img.jpg') }}" alt="">
            @endif

        </div>

        <div class="col-md-9">
            <h3 class="my-3">{{$course->$title}}</h3>
            <p class="font-weight-bold">
                {{ $course->duration }} 
                @if($course->duration_type=='1'){{trans('global.hour')}}
                @elseif($course->duration_type=='2'){{trans('global.day')}}
                @elseif($course->duration_type=='3'){{trans('global.month')}}
                @elseif($course->duration_type=='4'){{trans('global.year')}}
                @else
                @endif
            </p>
            <p>{{$course->$description}}</p>

            @if($course->modules()->exists())
                @if($course->modules()->first()->id==$resume_module)
                    <form method="post" action="{{ route('attemptcourse')}}">
                        @csrf
                        <input type="hidden" name="resume_module" value="{{$resume_module}}">
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <input class="btnn btnn-s" type="submit" value="{{trans('global.pages.frontend.login.start')}}">
                    </form>
                @else
                    <form method="post" action="{{ route('attemptcourse')}}">
                        @csrf
                        <input type="hidden" name="resume_module" value="{{$resume_module}}">
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <input class="btnn btnn-s" type="submit" value="{{trans('global.pages.frontend.login.continue')}}">
                    </form>
                @endif
            @endif
        </div>

      </div>

      @if($course->modules()->exists())
        <h3 class="my-4">{{trans('global.course.title_singular')}} {{trans('global.module.title')}}</h3>
        
        <div class="course-preview">
            <ol class="course-modules">
            @foreach($course->modules as $module)
                <li> {{$module->$title}} </li>
            @endforeach
                <li>{{trans('global.pages.frontend.exam.final_assesment')}}</li>
            </ol>
        </div>
        
      @endif

      <!-- /.row -->

      <!-- Related Projects Row -->
      <!-- @if($course->course_videos()->exists())
        <h3 class="my-4">Related Videos</h3>
        
        <div class="row course-preview">
        @foreach($course->course_videos as $video)
            <div class="col-md-3 col-sm-6 mb-4">
                <video width="320" height="240" controls>
                  <source src="{{$video->$attachmenturl}}" type="{{$video->$content_type}}">{{trans('global.pages.frontend.home.not_support_video')}}
                </video>
            </div>
        @endforeach
        </div>
        
      @endif -->

      <!-- @if($course->course_slides()->exists())
        <h3 class="my-4">Related Slides</h3>
        
        <div class="row">
        @foreach($course->course_slides as $slide)
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="#">
                    <object type="{{$slide->$content_type}}" data="{{$slide->$attachmenturl}}" width="400" height="300"></object>
                    <iframe src="{{$slide->$attachmenturl}}" style="width:600px; height:500px;" frameborder="0"></iframe>

                </a>
            </div>
        @endforeach
        </div>
        
      @endif -->
      <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
@section('scripts')
@parent
<script >
$(document).ready(function() {

    /*var videos = document.querySelectorAll('video');
    for(var i=0; i<videos.length; i++)
       videos[i].addEventListener('play', function(){pauseAll(this)}, true);


    function pauseAll(elem){
        for(var i=0; i<videos.length; i++){
            //Is this the one we want to play?
            if(videos[i] == elem) continue;
            //Have we already played it && is it already paused?
            if(videos[i].played.length > 0 && !videos[i].paused){
            // Then pause it now
              videos[i].pause();
            }
        }
      }*/

});
</script>
@endsection

@endsection