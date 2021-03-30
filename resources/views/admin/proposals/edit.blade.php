@extends('layouts.admin')
@section('content')

<?php 
  $languages = config('panel.available_languages');

?>

<div class="dash-main">
    <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
        <h2 class="main-heading m-0">
           Proposal
        </h2>
    </div>
    <div class="search-wrp">
        <div class="d-flex justify-content-between"></div>
    </div>
    <!-- Proposal By User -->
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>@if(!empty($proposals->portfolio->title)){{ ucfirst($proposals->portfolio->title) }}@endif</h2>
					
					By <a href="{{ route('admin.users.show', $proposals->user->id) }}" class="card-link">{{ ucfirst($proposals->user->name) }}</a>
				</div>
				<div class="card-body">
					
					
					<div class="form-group purple-border">
                      <label for="exampleFormControlTextarea4">Description:</label>
                      <textarea class="form-control" id="exampleFormControlTextarea4" rows="3" readOnly>@if(!empty($proposals->portfolio->title)){{ ucfirst($proposals->description) }}@endif</textarea>
                    </div>
					
					
					<label for="exampleFormControlTextarea4">Images:</label>
					<div class="row">
						@if( count($proposals->proposal_images) > 0 )
    						@foreach( $proposals->proposal_images as $proposal_images )
    							<div class="col-sm-12 col-md-3">
                                  <img
                                    class="img-fluid img-center"
                                    src="{{ $proposal_images->attachment->url() }}"
                                  />
                                </div>
                            @endforeach
						@endif
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
    
    <!-- Proposal By Admin -->
    
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Admin</h2>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                          <label for="exampleFormControlTextarea4">Comments:</label>
                          <textarea class="form-control" name="comment" id="exampleFormControlTextarea4" rows="3">@if(!empty($comments->comment)) {{ $comments->comment }} @endif</textarea>
                            @if($errors->has('comment'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('comment') }}
                                </em>
                            @endif
                        </div>
    					
    					<div class="form-group mb-2">
                            <label for="attachment">Attachment</label>
                            <input type="file" id="attachment" name="attachment[]" class="frm-field" value="" multiple>
                            @if($errors->has('attachment'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('attachment') }}
                                </em>
                            @endif
                            <p class="helper-block"></p>
                         </div>
                         
                         <div>
                            <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                        </div>
					</form>
				</div
                    
				</div>
			</div>
		</div>
	</div>
</div>

@section('scripts')
    @parent
    <script>

    </script>
@endsection
@endsection