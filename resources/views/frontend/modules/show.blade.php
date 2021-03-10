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
<div class="category-wrap pb-5 mb-2 pt-2">
        <!-- Page Content -->
    <div class="container">

      <div class="px-xl-2 px-md-3" id="current-module">
        <h2 class="mb-3 text-center">{{$module->$title}}</h2>
        <div class="module attchment text-center">
        @if($module->link_attachment=='video')
          @if(!empty($module->$videolink))

          @if(strpos($module->$videolink, 'youtube') !== false)
            <div class="youtube-iframe">
                {!! $module->$videohtml !!}
            </div>
          @else
            <div class="vimeo-iframe">
                {!! $module->$videohtml !!}
            </div>
          @endif
              
          @else
          <video controls>
            <source src="{{$module->$videourl}}" type="{{$module->$videocontenttype}}">{{trans('global.pages.frontend.home.not_support_video')}}
          </video>
          @endif
        @else

        <div style="overflow: hidden;" class="mb-3">
          <div id="resolte-contaniner" style="overflow: auto;"></div>
        </div>
          <!-- <div>
            <a href="{{$module->$slideurl}}"><img src="{{ asset('images/Powerpoint.png') }}"></a>
          </div> -->
          
        @endif
        </div>

        @if(!empty($resume_module))
        <form method="post" action="{{ route('attemptcourse')}}" class="text-right">
            @csrf
            <input type="hidden" name="resume_module" value="{{$resume_module}}">
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <input class="btnn btnn-s mt-3" type="submit" value="{{trans('global.next')}}">
        </form>
        @else
          @if($course->quiz()->exists() && $course->quiz->questions()->exists())
          <div class="text-right">
            <a href="{{url('/examrules/'.$course->id)}}" class="btnn btnn-s">
              {{trans('global.pages.frontend.home.take_exam')}}
            </a>
          </div>
          @endif
        @endif

      </div>

      <!-- @if($course->modules()->exists() && $course->modules()->count() > 1)
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
        
      @endif -->

      @if($course->modules()->exists() && $course->modules()->count() > 0)
      <div class="more-videos px-xl-2 px-md-3 ">
        <h3>{{trans('global.all')}} {{trans('global.module.title')}}</h3>
        <div class="morevideos">
          <div class="mvideo-box" id="course-modules">
            @foreach($course->modules as $cmodule)
            <div class="d-flex vrow" data-course="{{$course->id}}" data-value="{{$cmodule->id}}">
              <div class="vthumb"><img src="{{ asset('images/default_img.jpg') }}" alt=""></div>
              <div class="vcon">
                <h5>{{$cmodule->$title}}</h5>
                <!-- <p>3:50</p> -->
              </div>
              <div class="vbtn d-flex align-items-center justify-content-center">

                @if($cmodule->link_attachment=='video')
                <a href="{{route('modules.show', $cmodule->id)}}" class="playbtn ml-2" type="button" >
                  <img src="{{ asset('images/playbtn.png') }}">
                </a>
                @else
                <!-- <a href="{{$cmodule->$slideurl}}" class="playbtn ml-2" type="button" >
                  <img src="{{ asset('images/download.png') }}">
                </a> -->

                <a href="{{route('modules.show', $cmodule->id)}}" class="playbtn ml-2" data-file="{{$cmodule->$slideurl}}"><img src="{{ asset('images/playbtn.png') }}"></a>
                @endif

                <!-- <button class="playbtn ml-2" type="button">
                  <img src="{{ asset('images/tick2.png') }}">
                </button> -->
                
              </div>
            </div>
            @endforeach
            
          </div>
        </div>
      </div>
      @endif

      <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
@section('styles')
<link href="{{ asset('PPTXjs/css/pptxjs.css') }}" rel="stylesheet" />
<link href="{{ asset('PPTXjs/css/nv.d3.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/officeToHtml.css') }}" rel="stylesheet" />
@parent
@endsection

@section('scripts')
@parent



<script type="text/javascript" src="{{ asset('PPTXjs/js/filereader.js') }}"></script>
<script type="text/javascript" src="{{ asset('PPTXjs/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('PPTXjs/js/nv.d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('PPTXjs/js/pptxjs.js') }}"></script>
<script type="text/javascript" src="{{ asset('PPTXjs/js/divs2slides.js') }}"></script>
<script src="{{ asset('js/officeToHtml.js') }}"></script>

<script>
$(document).ready(function() {

  @if($module->link_attachment=='slide')
  $("#resolte-contaniner").html("");
  $("#resolte-contaniner").show();
  var file_path = $(this).data("file");

  $("#resolte-contaniner").officeToHtml({
    url: "{{$module->$slideurl}}",
    pdfSetting: {
      setLang: "",
      setLangFilesPath: "" /*"include/pdf/lang/locale" - relative to app path*/
    }
  });
  @endif

  /*$(document).on('click', '.playbtn', function() {
      var moduleid = $(this).closest('.vrow').attr('data-value');
      var courseid = $(this).closest('.vrow').attr('data-course');
      getvideos(courseid, moduleid);
  });

  function getvideos(courseid, moduleid){
      $.ajax({
          url: "{{url('/getcourse/')}}",
          type: "GET",
          data: {'course_id':courseid, 'module_id' : moduleid},
          success:function(data) {
              $('#course-modules').html(data); 
          }
      });
  }*/

});
</script>
<script>
  (function ($) {
    $(".module_ppts").on("click", function (e) {
      e.preventDefault();

      

    });
  }(jQuery));
</script>
@endsection

@endsection