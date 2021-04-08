@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.create') }} Milestone
            </h2>
        </div>
		<div class="form-wrap">
			<form action="{{ route('admin.milestones.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
                    <div class="form-group purple-border">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" value="" id="title">
                        @if($errors->has('title'))
                        <em class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group purple-border">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" name="price" value="" id="price">
                        @if($errors->has('price'))
                        <em class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type">
                            <option  value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="form-group purple-border">
                        <label for="order">Order:</label>
                        <input type="number" class="form-control" name="order" value="" id="order">
                        @if($errors->has('order'))
                        <em class="invalid-feedback">
                            {{ $errors->first('order') }}
                        </em>
                        @endif
                    </div>
                    

                    <div>
                        <input class="btnn btnn-s" id="payment_status"  type="submit" value="{{ trans('global.save') }}">
                    </div>				
			</form>
		</div>
		
	</div>

@section('scripts')
@parent
<script type="text/javascript">

</script>
@endsection

@endsection