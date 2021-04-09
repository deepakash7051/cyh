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
                    <div class="row">
                        <div class="col-md-10">
                            <h2>@if(!empty($proposals->portfolio->title)){{ ucfirst($proposals->portfolio->title) }}@endif</h2>
                        </div>
                        <div class="col-md-2 mt-2">
                            <strong>By <a href="{{ route('admin.users.show', $proposals->user->id) }}" class="card-link">{{ ucfirst($proposals->user->name) }}</a></strong>
                        </div>
                    </div>
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

    <!-- Payment Status -->
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Payment Status</h2>
				</div>
				<div class="card-body">

                @if( !empty($proposals->single_manual_payment) && !empty($proposals->payment_status))
                <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                    <div class="form-group purple-border">
                      <label for="paymane_type">Type:</label>
                      <input type="text" class="form-control" value="{{ $proposals->payment_status->type }}" id="paymane_type"readOnly>
                    </div>

                    <div class="form-group purple-border">
                      <label for="paymane_amount">Amount:</label>
                      <input type="text" class="form-control" value="{{ $proposals->single_manual_payment->amount }}" id="paymane_amount"readOnly>
                    </div>
					
                    <div class="form-group">
                        <label for="payment_status">Status</label>
                        <select class="form-control" id="payment_status" onchange="getPaymentStatus(this)">
                        
                        @if( $proposals->payment_status->status == 'pending' )
                         <option  value="{{ $proposals->payment_status->status }}">{{ ucfirst($proposals->payment_status->status) }}</option>
                         <option value="completed">Completed</option>
                        @endif
                        @if( $proposals->payment_status->status == 'completed' )
                         <option  value="{{ $proposals->payment_status->status }}">{{ ucfirst($proposals->payment_status->status) }}</option>
                         <option value="Pending">Pending</option>
                        @endif
                        </select>
                    </div>

					<label for="exampleFormControlTextarea4">Receipt Image:</label>
					<div class="row">
                        <div class="col-sm-12 col-md-3">
                            <a href="{{ $proposals->single_manual_payment->attachment->url() }}" target="_blank"><img
                            class="img-fluid img-center"
                            src="{{ $proposals->single_manual_payment->attachment->url() }}"
                            /></a>
                        </div>
					</div>

                    <div>
                        <input class="btnn btnn-s" id="payment_status" onclick="updatePaymentStatus(event,{{ $proposals->payment_status->id }})" type="button" value="{{ trans('global.save') }}">
                    </div>
                </form>
                @elseif( !empty($proposals->stripe_payment) && !empty($proposals->payment_status) )
                <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                    <div class="form-group purple-border">
                      <label for="paymane_type">Type:</label>
                      <input type="text" class="form-control" value="{{ $proposals->payment_status->type }}" id="paymane_type"readOnly>
                    </div>

                    <div class="form-group purple-border">
                      <label for="paymane_amount">Amount:</label>
                      <input type="text" class="form-control" value="{{ $proposals->stripe_payment->amount }}" id="paymane_amount"readOnly>
                    </div>
					
                    <div class="form-group">
                        <label for="payment_status">Status</label>
                        <select class="form-control" id="payment_status" onchange="getPaymentStatus(this)" disabled>
                        
                        @if( $proposals->payment_status->status == 'pending' )
                         <option  value="{{ $proposals->payment_status->status }}">{{ ucfirst($proposals->payment_status->status) }}</option>
                         <option value="completed">Completed</option>
                        @endif
                        @if( $proposals->payment_status->status == 'completed' )
                         <option  value="{{ $proposals->payment_status->status }}">{{ ucfirst($proposals->payment_status->status) }}</option>
                         <option value="Pending">Pending</option>
                        @endif
                        </select>
                    </div>

                    <div>
                        <input class="btnn btnn-s" id="payment_status" onclick="updatePaymentStatus(event,{{ $proposals->payment_status->id }})" type="button" value="{{ trans('global.save') }}" disabled>
                    </div>
                </form>
                @else
                    <div class="text-center">
                        Not Available
                    </div>
                @endif	
                
				</div>
			</div>
		</div>
	</div>
    
    @if( $proposals->payment_status->status == 'completed' )
    <!-- Proposal 1 By Admin -->
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <h2>Proposal 1</h2>
                        </div>
                        <div class="col-md-2">

                        @if(!empty($proposals->admin_proposals[0]))
                            @if($proposals->admin_proposals[0]->accept == '0')
                            <strong class="text-danger">Declined</strong>
                            @elseif($proposals->admin_proposals[0]->accept == '1')        
                            <strong class="text-success">Accepted</strong>
                            @else     
                            @endif
                        @endif
                        </div>
                    </div>
					
				</div>
				<div class="card-body">
					<div class="form-wrap">

                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                            <label for="first_price">Price:</label>
                            <input type="text" class="form-control" name="price" id="first_price" value="{{ !empty($proposals->admin_proposals[0]) ? $proposals->admin_proposals[0]->price : '' }}">
                            @if($errors->has('price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="first_comment">Comments:</label>
                          <textarea class="form-control" name="desc" id="desc" rows="3">{{ !empty($proposals->admin_proposals[0]) ? $proposals->admin_proposals[0]->desc : '' }}</textarea>
                            @if($errors->has('desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('desc') }}
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
                        <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                        @if( !empty( $proposals->admin_proposals[0]->admin_proposal_files ) )

                        @foreach( $proposals->admin_proposals[0]->admin_proposal_files as $file )
                                <div class="col-sm-12 col-md-3">
                                @if( $file->attachment_content_type !== 'application/pdf' )
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                        <img class="img-fluid img-center" src="{{ $file->attachment->url() }}"/>
                                    </a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                    @else
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                    <img src="{{ asset('images/pdf.png') }}" alt="" width="100"></a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                @endif
                                </div>
                            @endforeach
                        @endif
                        </div>

                         <input type="hidden" name="proposal_type" value="one">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">
                        
                         @if(!empty($proposals->admin_proposals[0]))
                            @if($proposals->admin_proposals[0]->accept == '0')
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                            @elseif($proposals->admin_proposals[0]->accept == '1')        
                            <a href="{{ route('admin.proposals.milestone', [$proposals->id]) }}" class="">
                                <div>
                                    <input class="btnn btnn-s" id="submit" type="button" value="Milestone">
                                </div>
                            </a>
                            @else
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>     
                            @endif
                            @else
                            @if(
                                !empty($proposals->admin_proposals[0]) &&
                                !empty($proposals->admin_proposals[1]) && 
                                !empty($proposals->admin_proposals[2]) && 
                                $proposals->admin_proposals[0]->accept !== '1'
                                && $proposals->admin_proposals[1]->accept !== '1' 
                                && $proposals->admin_proposals[2]->accept !== '1' )
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                                @endif
                        @endif
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
                <div class="row">
                        <div class="col-md-10">
                            <h2>Proposal 2</h2>
                        </div>
                        <div class="col-md-2">
                            @if(!empty($proposals->admin_proposals[1]))
                                @if($proposals->admin_proposals[1]->accept == '0')
                                <strong class="text-danger">Declined</strong>
                                @elseif($proposals->admin_proposals[1]->accept == '1')        
                                <strong class="text-success">Accepted</strong>
                                @else     
                                @endif
                            @endif
                        </div>
                    </div>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        <div class="form-group purple-border">
                            <label for="second_price">Price:</label>
                            <input type="text" class="form-control" name="price" id="second_price" value="{{ !empty($proposals->admin_proposals[1]) ? $proposals->admin_proposals[1]->price : '' }}">
                            @if($errors->has('price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="second_desc">Comments:</label>
                          <textarea class="form-control" name="desc" id="second_desc" rows="3">{{ !empty($proposals->admin_proposals[1]) ? $proposals->admin_proposals[1]->desc : '' }}</textarea>
                            @if($errors->has('desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('desc') }}
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

                        <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                        @if( !empty( $proposals->admin_proposals[1]->admin_proposal_files ) )

                        @foreach( $proposals->admin_proposals[1]->admin_proposal_files as $file )
                                <div class="col-sm-12 col-md-3">
                                @if( $file->attachment_content_type !== 'application/pdf' )
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                        <img class="img-fluid img-center" src="{{ $file->attachment->url() }}"/>
                                    </a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                    @else
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                    <img src="{{ asset('images/pdf.png') }}" alt="" width="100"></a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                @endif
                                </div>
                            @endforeach
                        @endif
                        </div>

                         <input type="hidden" name="proposal_type" value="two">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">

                         @if(!empty($proposals->admin_proposals[1]))
                            @if($proposals->admin_proposals[1]->accept == '0')
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                            @elseif($proposals->admin_proposals[1]->accept == '1')        
                                <a href="{{ route('admin.proposals.milestone', [$proposals->id]) }}" class="">
                                <div>
                                    <input class="btnn btnn-s" id="submit" type="button" value="Milestone">
                                </div>
                                </a>
                            @else
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>     
                            @endif
                            @else
                                @if(
                                    !empty($proposals->admin_proposals[0]) &&
                                    !empty($proposals->admin_proposals[1]) && 
                                    !empty($proposals->admin_proposals[2]) && 
                                    $proposals->admin_proposals[0]->accept !== '1'
                                 && $proposals->admin_proposals[1]->accept !== '1' 
                                 && $proposals->admin_proposals[2]->accept !== '1' )
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                                @endif
                        @endif
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
                <div class="row">
                        <div class="col-md-10">
                            <h2>Proposal 3</h2>
                        </div>
                        <div class="col-md-2">
                            @if(!empty($proposals->admin_proposals[2]))
                                @if($proposals->admin_proposals[2]->accept == '0')
                                <strong class="text-danger">Declined</strong>
                                @elseif($proposals->admin_proposals[2]->accept == '1')        
                                <strong class="text-success">Accepted</strong>
                                @else     
                                @endif
                            @endif
                        </div>
                    </div>
				</div>
				<div class="card-body">
					<div class="form-wrap">
					
                    <form action="{{ route('admin.proposals.update', [$proposals->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
						@method('PUT')
                        
                        <div class="form-group purple-border">
                            <label for="third_price">Price:</label>
                            <input type="text" class="form-control" name="price" id="third_price" value="{{ !empty($proposals->admin_proposals[2]) ? $proposals->admin_proposals[2]->price : '' }}">
                            @if($errors->has('price'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </em>
                            @endif
                        </div>

                        <div class="form-group purple-border">
                          <label for="third_desc">Comments:</label>
                          <textarea class="form-control" name="desc" id="third_desc" rows="3">{{ !empty($proposals->admin_proposals[2]) ? $proposals->admin_proposals[2]->desc : '' }}</textarea>
                            @if($errors->has('desc'))
                            <em class="invalid-feedback">
                                    {{ $errors->first('desc') }}
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
                        
                         <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                        @if( !empty( $proposals->admin_proposals[2]->admin_proposal_files ) )

                        @foreach( $proposals->admin_proposals[2]->admin_proposal_files as $file )
                                <div class="col-sm-12 col-md-3">
                                @if( $file->attachment_content_type !== 'application/pdf' )
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                        <img class="img-fluid img-center" src="{{ $file->attachment->url() }}"/>
                                    </a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                    @else
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                    <img src="{{ asset('images/pdf.png') }}" alt="" width="100"></a>
                                    <div class="caption">
                                        <input class="btn btn-link text-danger" id="delete" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
                                    </div>
                                @endif
                                </div>
                            @endforeach
                        @endif
                        </div>

                         <input type="hidden" name="proposal_type" value="three">
                         <input type="hidden" name="proposal_id" value="{{ $proposals->id }}">

                         @if(!empty($proposals->admin_proposals[2]))
                            @if($proposals->admin_proposals[2]->accept == '0')
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                            @elseif($proposals->admin_proposals[2]->accept == '1')
                            <a href="{{ route('admin.proposals.milestone', [$proposals->id]) }}" class="">
                                <div>
                                    <input class="btnn btnn-s" id="submit" type="button" value="Milestone">
                                </div>
                            </a> 
                            @else
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>     
                            @endif
                            @if(
                                !empty($proposals->admin_proposals[0]) &&
                                !empty($proposals->admin_proposals[1]) && 
                                !empty($proposals->admin_proposals[2]) && 
                                $proposals->admin_proposals[0]->accept !== '1'
                                && $proposals->admin_proposals[1]->accept !== '1' 
                                && $proposals->admin_proposals[2]->accept !== '1' )
                            <div>
                                <input class="btnn btnn-s" id="submit" type="submit" value="{{ trans('global.save') }}">
                            </div>
                                @endif
                        @endif
                         
                         
					</form>
				</div>
                    
				</div>
			</div>
		</div>
	</div>
    @endif
</div>

@section('scripts')
    @parent
    <script>

        function deleteFile(event,id) {
            
            let token = "{{ csrf_token() }}";

            let url = "../../../admin/deleteFile/"+id;

            if( typeof(id) !== 'undefined' ){
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText){
                        location.reload();
                    }
                }
                };
                xhttp.send();    
            }
        }

        function getPaymentStatus(selectObject){
            var value = selectObject.value;  
            console.log(value);
        }

        function updatePaymentStatus(event,id) {
            
            let token = "{{ csrf_token() }}";

            var x = document.getElementById("payment_status").selectedIndex;
            let paymentStatus = document.getElementsByTagName("option")[x].value;

            let url = "../../../admin/updatePaymentStatus/"+id+"/"+paymentStatus;

            if( typeof(id) !== 'undefined' ){
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText){
                        location.reload();
                    }
                }
                };
                xhttp.send();    
            }
        }

        function milestonePaymentStatus(task,id){  
            var task = (task.value || task.options[a.selectedIndex].value);  //crossbrowser solution =)
            
                var hr = new XMLHttpRequest();
                var url = "../../../admin/milestonesPaymentStatus/"+id+"/"+task;
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText){
                        //location.reload();
                    }
                }
                };
                xhttp.send();
        }
    </script>
@endsection
@endsection