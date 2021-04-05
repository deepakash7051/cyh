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

    <!-- Milestones -->
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Milestones</h2>
				</div>
				<div class="card-body">
									
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
                @else
                    <div class="text-center">
                        Not Available
                    </div>
                @endif	
                
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
                        <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                        @if( count($first_proposals) > 0 )
                            @foreach( $first_proposals as $first_proposal )
                                @if( count($first_proposal->admin_propsal_files) > 0 )
                                    @foreach( $first_proposal->admin_propsal_files as $file )
                                    <div class="col-sm-12 col-md-3">
                                        @if( $file->attachment_content_type !== 'application/pdf' )
                                        <a href="{{ $file->attachment->url() }}" target="_blank">
                                            <img
                                                class="img-fluid img-center"
                                                src="{{ $file->attachment->url() }}"
                                                /></a>
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
                            @endforeach    
                        @endif          
                        </div>

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

                         @if( count($second_proposals) > 0 )                            
                        <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                            @foreach( $second_proposals as $second_proposal )
                                @if( count($second_proposal->admin_propsal_files) > 0 )
                                    @foreach( $second_proposal->admin_propsal_files as $file )
                                    <div class="col-sm-12 col-md-3">
                                    @if( $file->attachment_content_type !== 'application/pdf' )
                                    <a href="{{ $file->attachment->url() }}" target="_blank">
                                        <img
                                            class="img-fluid img-center"
                                            src="{{ $file->attachment->url() }}"
                                            /></a>
                                            <div class="caption">
                                                <input class="btn btn-link text-danger" id="" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
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
                            @endforeach          
                        </div>
                        @endif 

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
                        
                         @if( count($third_proposals) > 0 )                            
                        <label for="exampleFormControlTextarea4">Files:</label>
                        <div class="row mb-5">
                            @foreach( $third_proposals as $third_proposal )
                                @if( count($third_proposal->admin_propsal_files) > 0 )
                                    @foreach( $third_proposal->admin_propsal_files as $file )
                                    <div class="col-sm-12 col-md-3">
                                        @if( $file->attachment_content_type !== 'application/pdf' )
                                        <a href="{{ $file->attachment->url() }}" target="_blank">
                                            <img class="img-fluid img-center" src="{{ $file->attachment->url() }}"/></a>
                                            <div class="caption">
                                                <input class="btn btn-link text-danger" id="" type="button" value="Remove" onclick="deleteFile(event,{{ $file->id }})">
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
                            @endforeach          
                        </div>
                        @endif

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
    </script>
@endsection
@endsection