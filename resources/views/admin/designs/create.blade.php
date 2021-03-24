@extends('layouts.admin')
@section('content')

@if(Session::has('sussces'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('sussces') }}</p>
@endif

<div class="dash-main">

    <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
        <h2 class="main-heading m-0">
            {{ trans('global.create') }} {{ trans('global.portfolio.title') }}
        </h2>
    </div>
    
    <form method="post" action="{{url('admin/designs')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-2">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="frm-field" value="">
            @if($errors->has('title'))
            <em class="invalid-feedback">
                    {{ $errors->first('title') }}
                </em>
            @endif
            <p class="helper-block"></p>
        </div>

        <div class="form-group mb-2">
            <label for="image">Image</label>
            <input type="file" id="image" name="attachments[]" class="frm-field" value="" multiple>
            @if($errors->has('attachments'))
            <em class="invalid-feedback">
                    {{ $errors->first('attachments') }}
                </em>
            @endif
            <p class="helper-block"></p>
        </div>
        <div>
        <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
        </div>
        
    </form>  
        
</div> 

<script type="text/javascript">

</script>
@endsection