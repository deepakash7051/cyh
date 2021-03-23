@extends('layouts.admin')
@section('content')
<?php 
  $languages = config('panel.available_languages');
  
  /*$columns = [['name' => 'id']];
  if(count($languages) > 0){
    foreach($languages as $langKey => $langValue){
      array_push($columns, ['name' => $langKey.'_name']);
    }
  }
  array_push($columns, ['name' => 'action', 'orderable' => false, 'searchable' => false]);*/
?>
    
	<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                List
            </h2>
            <div>
                <a href="{{ URL::to('admin/designs/create') }}" class="btnn btnn-s">
                    Add Designs
                </a>
            </div>
        </div>
		<div class="search-wrp">
			<div class="d-flex justify-content-between"></div>
		</div>
		<div class="table-responsive table-responsive-md">
    
			<table class="table table-hover table-custom datatable" id="design_table">
				<thead>
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Image
                        </th>
                        <th>
                            
                        </th>
                    </tr>
                </thead>
				
			</table>
		</div>
	</div>

@section('scripts')
@parent

<script>


        $('#design_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.designlist') }}",
            columns: [
              { name: 'id' },
              { name: 'title' },
              { name: 'filename' },
              { name: 'action', orderable: false, searchable: false }
            ],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'pageLength'},
                { extend: 'copyHtml5', text: "{{ trans('global.datatables.copy') }}" },
                { extend: 'excelHtml5', text: "{{ trans('global.datatables.excel') }}" },
                { extend: 'csvHtml5', text: "{{ trans('global.datatables.csv') }}" },
                { extend: 'pdfHtml5', text: "{{ trans('global.datatables.pdf') }}" },
                { extend: 'print', text: "{{ trans('global.datatables.print') }}" }
            ]
        });
</script>
@endsection

@endsection

