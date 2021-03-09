@extends('layouts.front')

@section('content')

<?php 
    $locale = config('app.locale');
?>
<div class="category-wrap py-5 my-2">
    <div class="container">
        @if (\Session::has('success'))
            <div class="alert alert-success mb-4">
                {!! \Session::get('success') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-error mb-4">
                {!! \Session::get('error') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="d-flex justify-content-between align-items-center mb-4 cat-head">
            <h2>{{ trans('global.pages.frontend.home.title') }}</h2>
            <a href="{{route('categories.index')}}" class="btnn">{{ trans('global.pages.frontend.home.category_button') }}</a>
        </div>
        <div class="d-flex justify-content-center flex-wrap cat-main">
            @if(count($courses) > 0)
                @foreach($courses as $course)
                @php 
                    $fieldtitle = $locale.'_title';
                    $fielddescription = $locale.'_description';
                    $courseAttempt = $user->course_attempts()->where('course_id', $course->id);

                    $courseurl = ($courseAttempt->count() > 0 && !empty($courseAttempt->first()->completed_at))  ? '#' : url('courses/'.$course->id) ;
                @endphp
            <a href="{{ $courseurl}}" class="cat-box code-dialog" data-value="{{$course->id}}">
                @if($courseAttempt->count() > 0)
                    @if(!empty($courseAttempt->first()->completed_at))
                        <div class="status-wrp status-complete">
                            {{ strtoupper(trans('global.pages.frontend.login.completed')) }}
                        </div>
                    @else
                        <div class="status-wrp status-pending">
                            {{ strtoupper(trans('global.pages.frontend.login.continue')) }}
                        </div>
                    @endif
                @else
                <div class="status-wrp status-start">
                    {{ strtoupper(trans('global.pages.frontend.login.start')) }}
                </div>
                @endif
                <div class="cat-icon d-flex align-items-center justify-content-center">
                    <img src="{{$course->course_image_url}}" alt="">
                </div>
                <h3>{{$course->$fieldtitle}}</h3>
                <p>
                    @if(strlen($course->$fielddescription) > 100)
                        {{substr($course->$fielddescription, 0 , 100).'...'}}
                    @else
                        {{$course->$fielddescription}}
                    @endif
                </p>
            </a>
                @endforeach
            @else
                <h5>{{trans('global.pages.frontend.home.no_course_msg')}}</h5>
            @endif

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade course-preview" id="CoursesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
    </div>
  </div>
</div>

@section('scripts')
@parent
<script >
    $(document).ready(function() {

        /*$(".code-dialog").click(function(){
            var courseid = $(this).attr('data-value');
            var videoid = '';
            getvideos(courseid, videoid);
            
        });

        $(document).on('click', '.playbtn', function() {
            var videoid = $(this).closest('.vrow').attr('data-value');
            var courseid = $(this).closest('.vrow').attr('data-course');
            getvideos(courseid, videoid);
        });

        function getvideos(courseid, videoid){
            $.ajax({
                url: "{{url('/getcourse/')}}",
                type: "GET",
                data: {'course_id':courseid, 'video_id' : videoid},
                success:function(data) {
                    $('#CoursesModal').find('.modal-content').html(data); 
                    $('#CoursesModal').modal('show'); 
                }
            });
        }*/

    });

</script>
@endsection
@endsection
