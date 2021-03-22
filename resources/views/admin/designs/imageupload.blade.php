@extends('layouts.admin')
@section('content')

@if(Session::has('error'))
<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
@endif

@if(Session::has('sussces'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('sussces') }}</p>
@endif

<div class="container">
    
    <form method="post" action="{{url('admin/designs/store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-2">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="frm-field" value="">
            <p class="helper-block"></p>
        </div>

        <div class="form-group mb-2">
            <label for="title">Title</label>
            <input type="file" id="title" name="file[]" class="frm-field" value="" multiple>
            <p class="helper-block"></p>
        </div>
        <input class="btnn btnn-s mt-2 float-right" id="submit" type="submit" value="{{ trans('global.save') }}">
    </form>  
        
</div> 

<script type="text/javascript">

</script>
@endsection