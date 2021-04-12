@extends('layouts.admin')
@section('content')

<div class="dash-main">
    <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
        <h2 class="main-heading m-0">
           Milestone
        </h2>
    </div>
    <div class="search-wrp">
        <div class="d-flex justify-content-between"></div>
    </div>

    <!-- Milestones -->
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>Milestones</h2>
				</div>
				<div class="card-body">
                    <div class="table-responsive table-responsive-md">
                        <table class="table" id="milestone_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Payment Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                @if( count($proposals->milestone_payment) > 0 )
                                    @foreach($proposals->milestone_payment as $milestone )
                                    <tr>
                                        <td>{{ $milestone->milestone->order }}</td>
                                        <td>{{ $milestone->milestone->title }}</td>
                                        <td>{{ $milestone->amount }}</td>
                                        <td>{{ $milestone->status }}</td>
                                        <td>
                                        
                                        @if( $milestone->task == 'completed' )
                                            <select disabled class="form-select" aria-label="Default select example">
                                                <option value="pending">Pending</option>
                                                <option selected value="completed">Completed</option>
                                            </select>
                                                @else
                                            <select class="form-select milestone-status" aria-label="Default select example" onchange="milestonePaymentStatus(this,'{{ $milestone->id }}')">
                                                <option selected value="pending">Pending</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        @endif
                                        
                                        </td>
                                        <td>
                                        @if( $milestone->status == 'paid' )
                                        <button class="btn btn-info p-1" disabled>Request</button>
                                        @else
                                        <button class="btn btn-info p-1">Request</button>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>

    <!-- Payment Status -->
    @if( count($proposals->milestone_payment) )
        @foreach( $proposals->milestone_payment as $milestone_payment )
    <div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					<h2>{{$milestone_payment->milestone->title}}</h2>
				</div>
				<div class="card-body">
                <form action="{{ route('admin.milestones-payment.update', [$milestone_payment->id]) }}" method="POST">
                        @csrf
						@method('PUT')
                        <input type="hidden" name="m_p_id" value="{{$milestone_payment->id}}">
                    <div class="form-group">
                        <label for="payment_status">Status</label>
                        <select class="form-control" name="status" id="payment_status" onchange="paystatus(this,'{{ $milestone_payment->id }}')">
                        
                        @if( $milestone_payment->status == 'paid' )
                            <option value="{{ $milestone_payment->status }}">{{ ucfirst($milestone_payment->status) }}</option>
                            <option value="unpaid">Unpaid</option>
                        @endif
                        @if( $milestone_payment->status == 'unpaid' )
                            <option  value="{{ $milestone_payment->status }}">{{ ucfirst($milestone_payment->status) }}</option>
                            <option value="paid">Paid</option>
                        @endif
                        </select>
                    </div>

                    <label for="exampleFormControlTextarea4">Receipt Image:</label>
                    @if( $milestone_payment->manual_payment )
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <a href="{{ $milestone_payment->manual_payment->attachment->url() }}" target="_blank"><img
                            class="img-fluid img-center"
                            src="{{ $milestone_payment->manual_payment->attachment->url() }}"
                            /></a>
                        </div>
                    </div>
                    @endif

                    <!-- <div class="m-2">
                        <input class="btnn btnn-s" id="" type="submit" value="{{ trans('global.save') }}">
                    </div> -->

                <form>
                </div>
			</div>
		</div>
	</div>
        @endforeach
    @endif


</div>

@section('scripts')
    @parent
    <script>
        function milestonePaymentStatus(task,id){  
            var task = (task.value || task.options[a.selectedIndex].value);  //crossbrowser solution =)
            
                var hr = new XMLHttpRequest();
                var url = "../../../admin/milestonesTaskStatus/"+id+"/"+task;
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

        function paystatus(task,id){  
          var status = (task.value || task.options[a.selectedIndex].value);  //crossbrowser solution =)
          var hr = new XMLHttpRequest();
          var url = "../../../admin/milestonesPaymentStatus/"+id+"/"+status;
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
    </script>
@endsection
@endsection