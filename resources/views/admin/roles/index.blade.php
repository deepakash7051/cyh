@extends('layouts.admin')
@section('content')
	<div class="dash-main">
		<div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
        <h2 class="main-heading m-0">
            {{ trans('global.role.title_singular') }} {{ trans('global.list') }}
        </h2>
        <div>
            <a href="{{ route('admin.roles.create') }}" class="btnn btnn-s">
                {{ trans('global.add') }} {{ trans('global.role.title_singular') }}
            </a>
        </div>
    </div>
		<div class="search-wrp">
			<div class="d-flex justify-content-between"></div>
		</div>
		<div class="table-responsive table-responsive-md">
			<table class="table table-hover table-custom datatable" id="role_table">
				<thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    {{ trans('global.role.fields.title') }}
                </th>
                <th>
                    {{ trans('global.role.fields.permissions') }}
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $key => $role)
                <tr data-entry-id="{{ $role->id }}">
                    <td>

                    </td>
                    <td>
                        {{ $role->title ?? '' }}
                    </td>
                    <td>
                        @foreach($role->permissions as $key => $item)
                            <span class="badge badge-info">{{ $item->title }}</span>
                        @endforeach
                    </td>
                    <td>
                        @can('role_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                {{ trans('global.view') }}
                            </a>
                        @endcan
                        @can('role_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                        @endcan
                        @can('role_delete')
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        @endcan
                    </td>

                </tr>
            @endforeach
        </tbody>
				
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
    url: "{{ route('admin.roles.massDestroy') }}",
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
@can('role_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection

@endsection