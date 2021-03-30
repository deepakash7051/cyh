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
                          <textarea class="form-control" id="exampleFormControlTextarea4" rows="4" readOnly>@if(!empty($proposals->portfolio->title)){{ ucfirst($proposals->description) }}@endif</textarea>
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
    	
</div>

@section('scripts')
    @parent
    <script>

    </script>
@endsection
<style>
    .bg-proposal-desc{
        backgrounf
    }
</style>
@endsection