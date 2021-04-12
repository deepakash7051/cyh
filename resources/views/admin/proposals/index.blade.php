@extends('layouts.admin')
@section('content')
<?php 
  $languages = config('panel.available_languages');
?>

<div class="dash-main">
   <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
      <h2 class="main-heading m-0">
         Proposals
      </h2>
      <div>
         <!-- <a href="{{ URL::to('admin/designs/create') }}" class="btnn btnn-s">
            Add Portfolio
            </a> -->
      </div>
   </div>
   <div class="search-wrp">
      <div class="d-flex justify-content-between"></div>
   </div>
   <div class="table-responsive table-responsive-md">
      <table class="table table-hover table-custom datatable" id="proposal_table">
         <thead>
            <tr>
               <th>
                  Id
               </th>
               <th>
                  Portfolio
               </th>
               <th>
                  Name
               </th>
               <th>
                  Actions
               </th>
            </tr>
         </thead>
      </table>
   </div>
</div>
@section('scripts')
  <script>
         
           $('#proposal_table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('admin.proposallist') }}",
            columns: [
              { name: 'id' },
              { name: 'portfolio.title', orderable: false, searchable: false },
              { name: 'user.name', orderable: false, searchable: false },
              { name: 'action' ,orderable: false, searchable: false}
            ],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'pageLength'}
            ]
        });
  </script>
@endsection
@endsection
