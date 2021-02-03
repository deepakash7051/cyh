@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
			<h2 class="main-heading m-0">
				{{ trans('global.permission.title_singular') }} {{ trans('global.list') }}
			</h2>
			<div>
				<a href="{{ route('admin.permissions.create') }}" class="btnn btnn-s">
					{{ trans('global.add') }} {{ trans('global.permission.title_singular') }}
				</a>
			</div>
		</div>
		<div class="search-wrp">
			<div class="d-flex justify-content-between"></div>
		</div>
		<div class="table-responsive table-responsive-md">
			<table class="table table-hover table-custom" id="permission_table">
				<thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('global.permission.fields.title') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
				
			</table>
		</div>
	</div>
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.permissions.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('permission_delete')
  dtButtons.push(deleteButton)
@endcan

  //$('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
<script>
        $('#permission_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.permissions.list') }}",
            columns: [
                { name: 'id' },
                { name: 'title' },
                { name: 'action', orderable: false, searchable: false }
            ],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ]
        });
</script>
@endsection

@endsection