@extends('layouts.admin')
@section('content')
<?php 
  $locale = config('app.locale');
  $languages = config('panel.available_languages');
?>

	<div class="dash-main">
        <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
            <h2 class="main-heading m-0">
                {{ trans('global.quiz.title_singular') }} {{ trans('global.list') }}
            </h2>
            <div>
                <a href="{{ route('admin.quizzes.create') }}" class="btnn btnn-s">
                    {{ trans('global.add') }} {{ trans('global.quiz.title_singular') }}
                </a>
            </div>
        </div>
		<div class="search-wrp">
			<div class="d-flex justify-content-between"></div>
		</div>
		<div class="table-responsive table-responsive-md">
			<table class="table table-hover table-custom datatable" id="slide_table">
				<thead>
                    <tr>
                        <th>
                            {{ trans('global.quiz.fields.id') }}
                        </th>
                        <th>
                            {{ trans('global.quiz.fields.title') }}
                        </th>
                        <th>
                            {{ trans('global.course.title_singular') }}
                        </th>  
                        <th>
                            {{ trans('global.quiz.fields.place') }}
                        </th>
                        <th>
                            {{ trans('global.slide.fields.status') }}
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
    url: "{{ route('admin.users.massDestroy') }}",
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
@can('user_delete')
  dtButtons.push(deleteButton)
@endcan

  //$('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
<script>

        $('#slide_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.quizzes.list') }}",
            columns: [
              { name: 'id' },
              { name: '{{$locale."_title"}}' },
              { name: 'course.{{$locale."_title"}}', orderable : false },
              { name: 'place' },
              { name: 'status' },
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