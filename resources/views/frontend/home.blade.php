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
            <a href="" class="btnn">{{ trans('global.pages.frontend.home.category_button') }}</a>
        </div>
        <div class="d-flex align-items-center justify-content-center flex-wrap cat-main">
            @if(count($courses) > 0)
                @foreach($courses as $course)
                @php 
                    $fieldtitle = $locale.'_title';
                    $fielddescription = $locale.'_description';
                @endphp
            <a href="{{ route('courses.show', $course->id)}}" class="cat-box code-dialog" data-value="{{$course->id}}">
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
