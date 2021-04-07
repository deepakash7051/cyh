@extends('layouts.admin')
@section('content')
<div class="dash-main">
    <div class="d-flex align-items-center justify-content-between border-btm pb-3 mb-4">
        <h2 class="main-heading m-0">
            Settings
        </h2>
    </div>
    <div class="search-wrp">
        <div class="d-flex justify-content-between"></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Proposal Request Amount</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bank-details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group purple-border">
                            <label for="proposal_amount">Amount:</label>
                            <input type="text" class="form-control" name="proposal_initial_amount" value="{{ !empty($bank_details->proposal_initial_amount) ? $bank_details->proposal_initial_amount : '' }}" id="proposal_amount">
                            @if($errors->has('proposal_initial_amount'))
                            <em class="invalid-feedback">
                                {{ $errors->first('proposal_initial_amount') }}
                            </em>
                            @endif
                        </div>
                        <div>
                            <input class="btnn btnn-s" id="payment_status"  type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Bank Details</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bank-details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group purple-border">
                            <label for="beneficiary_name">Bank Name:</label>
                            <input type="text" class="form-control" name="bank_name" id="beneficiary_name" value="{{ !empty($bank_details->bank_name) ? $bank_details->bank_name : '' }}">
                            @if($errors->has('bank_name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('bank_name') }}
                            </em>
                            @endif
                        </div>
                        <div class="form-group purple-border">
                            <label for="beneficiary_name">Beneficiary Name:</label>
                            <input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name" value="{{ !empty($bank_details->beneficiary_name) ? $bank_details->beneficiary_name : '' }}">
                            @if($errors->has('beneficiary_name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('beneficiary_name') }}
                            </em>
                            @endif
                        </div>
                        <div class="form-group purple-border">
                            <label for="account_number">Account Number:</label>
                            <input type="text" class="form-control" name="account_number" id="account_number" value="{{ !empty($bank_details->account_number) ? $bank_details->account_number : '' }}">
                            @if($errors->has('account_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('account_number') }}
                            </em>
                            @endif
                        </div>
                        <div class="form-group purple-border">
                            <label for="ifsc_code">IFSC Code:</label>
                            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="{{ !empty($bank_details->ifsc_code) ? $bank_details->ifsc_code : '' }}">
                            @if($errors->has('ifsc_code'))
                            <em class="invalid-feedback">
                                {{ $errors->first('ifsc_code') }}
                            </em>
                            @endif
                        </div>
                        <div>
                            <input class="btnn btnn-s" id="payment_status"  type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
    
    </script>
@endsection

@endsection