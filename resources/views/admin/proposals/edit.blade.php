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
    
    <!-- Proposal 1 By Admin -->
    
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Proposal 1</h2>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                            <label for="first_price">Price:</label>
                            <input type="text" class="form-control" name="first_price" id="first_price" value="{{ !empty($proposals->first_proposal[0]->first_price) ? $proposals->first_proposal[0]->first_price : '' }}">
                            @if($errors->has('first_price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('first_price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="first_comment">Comments:</label>
                          <textarea class="form-control" name="first_desc" id="first_desc" rows="3">{{ !empty($proposals->first_proposal[0]->first_desc) ? $proposals->first_proposal[0]->first_desc : '' }}</textarea>
                            @if($errors->has('first_desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('first_desc') }}
                                </em>
                            @endif
                        </div>
    					
    					<div class="form-group mb-2">
                            <label for="attachment">Attachment:</label>
                            <input type="file" id="attachment" name="attachment[]" class="frm-field" value="" multiple>
                            @if($errors->has('attachment'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('attachment') }}
                                </em>
                            @endif
                            <p class="helper-block"></p>
                         </div>

                         <!-- <div class="form-group mb-2">
                        	<label>Payment Status:</label>
                            <select class="frm-field " name="payment_status" id="">
                                    <option value="">Pending</option>
                                    <option value="">Completed</option>
                            </select>
                        </div> -->
                         <input type="hidden" name="first_propsal">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">
                         <div>
                            <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                        </div>
					</form>
				</div>
                    
				</div>
			</div>
		</div>
	</div>

    <!-- Proposal 2 By Admin -->

    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Proposal 2</h2>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                            <label for="second_price">Price:</label>
                            <input type="text" class="form-control" name="second_price" id="second_price" value="{{ !empty($proposals->second_proposal[0]->second_price) ? $proposals->second_proposal[0]->second_price : '' }}">
                            @if($errors->has('second_price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('second_price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="second_desc">Comments:</label>
                          <textarea class="form-control" name="second_desc" id="second_desc" rows="3">{{ !empty($proposals->second_proposal[0]->second_desc) ? $proposals->second_proposal[0]->second_desc : '' }}</textarea>
                            @if($errors->has('second_desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('second_desc') }}
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
                         <input type="hidden" name="second_propsal">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">
                         <div>
                            <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                        </div>
					</form>
				</div>
                    
				</div>
			</div>
		</div>
	</div>

    <!-- Proposal 3 By Admin -->

    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Proposal 3</h2>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                            <label for="third_price">Price:</label>
                            <input type="text" class="form-control" name="third_price" id="third_price" value="{{ !empty($proposals->third_proposal[0]->third_price) ? $proposals->third_proposal[0]->third_price : ''}}">
                            @if($errors->has('third_price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('third_price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="third_desc">Comments:</label>
                          <textarea class="form-control" name="third_desc" id="third_desc" rows="3">{{ !empty($proposals->third_proposal[0]->third_desc) ? $proposals->third_proposal[0]->third_desc : ''}}</textarea>
                            @if($errors->has('third_desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('third_desc') }}
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
                         <input type="hidden" name="third_propsal">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">
                         <div>
                            <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                        </div>
					</form>
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
@endsection