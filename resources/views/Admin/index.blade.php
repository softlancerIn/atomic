@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'dashboard';

if(Auth::guard('user')->user()->role == 'warehousemanager'){

$new_request = App\Models\Transection::where(['status' => 1, 'company_id' => Auth::guard('user')->user()->id])->whereDay('created_at', now()->day)->count();
$approved_request = App\Models\Transection::where(['status' => 2, 'company_id' => Auth::guard('user')->user()->id])->whereDay('created_at', now()->day)->count();
$reject_request = App\Models\Transection::where(['status' => 3, 'company_id' => Auth::guard('user')->user()->id])->whereDay('created_at', now()->day)->count();
$toaysTotalTransection = App\Models\Transection::where(['company_id' => Auth::guard('user')->user()->id])->whereDay('created_at', now()->day)->count();
}else{
$new_request = App\Models\Transection::where(['status' => 1])->whereDay('created_at', now()->day)->count();
$approved_request = App\Models\Transection::where(['status' => 2])->whereDay('created_at', now()->day)->count();
$reject_request = App\Models\Transection::where(['status' => 3])->whereDay('created_at', now()->day)->count();
$toaysTotalTransection = App\Models\Transection::whereDay('created_at', now()->day)->count();

$todayPayout = App\Models\RefundRequest::whereDay('created_at', now()->day)->count();
$todayCommission = App\Models\Settelment::where('status','1')->whereDay('created_at', now()->day)->get();

$comm = 0;
foreach($todayCommission as $key=>$value){
$company = App\Models\Agent::where('id',$value->company_id)->first();
$agentCommission = $company->comission ?? '0';
if($agentCommission == '0'){
$amt = 0;
}else{
$amt = ($value->amount * $agentCommission)/100;
}

$comm+=$amt;

}

$totalCommission = App\Models\Settelment::where('status','1')->get();
$totlComm = 0;
foreach($totalCommission as $key2=>$value2){
$company = App\Models\Agent::where('id',$value2->company_id)->first();
$agentCommission = $company->comission;
$amt = ($value2->amount * $agentCommission)/100;
$totlComm+=$amt;

}

}

@endphp
<style>
    .card {
        height: 125px;
    }

</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="row mx-3 mt-3 mb-0">
        <form class="row " method="post" action="#" enctype="multipart/form-data">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-lg-2 col-md-6 col-sm-4 pt-1">
                <button type="button" class="btn btn-sm btn-primary">submit</button>
            </div>
        </form>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            @if(Auth::guard('user')->user()->role == 'admin' || 'user')
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Todays Payout Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$todayPayout ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Todays Comission</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$comm ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box text-white" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Total Comission</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$totlComm ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box text-white" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">New Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$new_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Approved Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$approved_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Reject Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$reject_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block"><a href="{{route('categoryList',['type'=>'new'])}}">Today Transaction(Rs.)</a></span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$data['totalTransaction'] ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                    <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Total Settelment(Rs.)</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$data['totalSettelment'] ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                    <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Recived Settelment(Rs.)</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$data['recivedSettelment'] ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0 bg-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                    <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Pending Settelment(Rs.)</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$data['pendingSettelment'] ?? '0'}}</h3>
                    </div>
                </div>
            </div>

            @elseif(Auth::guard('user')->user()->role == 'warehousemanager')
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box text-white" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">New Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$new_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Approved Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$approved_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Reject Request</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$reject_request ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Today Total Transection</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$toaysTotalTransection ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Total Assign Order</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$total_wareHou_assign_order ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Pending Order</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$total_wareHou_pending_order ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Accept Order</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$total_wareHou_accept_order ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-suitcase-lg text-white" viewBox="0 0 16 16">
                                    <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2H5Zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1ZM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3H1.5ZM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5Zm-3 .5V3H4v10h8Z" />
                                </svg>
                            </div>
                            <span class="mb-2 d-block">Reject Order</span>
                        </div>
                        <h3 class="card-title mb-2 text-end">{{$total_wareHou_reject_order ?? '0'}}</h3>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@include('Admin.Modal.modal');
@endsection
