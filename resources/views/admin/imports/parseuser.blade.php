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
                {{ trans('global.datatables.csv') }} {{ trans('global.user.title_singular') }} {{ trans('global.list') }}
            </h2>
        </div>
		<div class="search-wrp">
			<div class="d-flex justify-content-between"></div>
		</div>
		<div class="table-responsive table-responsive-md">
      <form action="{{ route('admin.import.saveusers') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="attachment" value="{{$file}}" style="display: none;"> 
  			<table class="table table-hover table-custom datatable">
  				@foreach ($data as $datakey => $row)
              <tr style="font-weight:@if($datakey=='0') {{ 'bold'}};@endif">
              @foreach ($row as $key => $value)
                  <td>{{ $value }}</td>
              @endforeach
              </tr>
          @endforeach
  				
  			</table>
        <div>
            <input class="btnn btnn-s" type="submit" value="{{ trans('global.import_data') }}">
        </div>
      </form>
		</div>
	</div>

@endsection