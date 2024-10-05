@extends('Admin.Layout.layout')
@section('content')
@php
  use Carbon\Carbon;
  $active = 'order';

  $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $data['order']->created_at);
  $formattedDate = $carbonDate->format('M d, Y');

  if(!empty($data['order']->warehouse_id)){
    $warehouse = App\Models\Warehouse::where('id',$data['order']->warehouse_id)->first(['name','address','city','state','zipcode']);
  }

@endphp
<!-- ============================== -->
<style type="text/css">
  .btn-label-green {
    color: #01652f;
    border-color: rgba(0, 0, 0, 0);
    background: #01652f42;
  }

  .btn-label-green:hover {
    background: #01652f;
    color: #fff;
  }

  .btn-label-yellow {
    color: #a8ab09;
    border-color: rgba(0, 0, 0, 0);
    background: #cdc70e42;
  }

  .btn-label-yellow:hover {
    background: #b7cd04;
    color: #fff;
  }

  .btn-label-danger {
    color: #ff3e1d;
    border-color: rgba(0, 0, 0, 0);
    background: #ffe0db;
  }

  .btn-label-danger:hover {
    border-color: rgba(0, 0, 0, 0) !important;
    background: #e6381a !important;
    color: #fff !important;
    box-shadow: 0 0.125rem 0.25rem 0 rgba(255, 62, 29, .4) !important;
    transform: translateY(-1px) !important;
  }
</style>
<section>
  <div class="container">
    <div class="row g-3 mt-3">
      <div class="col-12 col-lg-4">
        <div class="card p-3" style="height: 180px;">
          <h5 class="mb-1  text-nowrap fw-bold ">Order: {{$data['order']->order_id}}
            @if(Auth::guard('user')->user()->role == 'admin')
            @if($data['order']->payment_type == '1')
            <span class="badge bg-label-success  ms-2">
              Online
            </span>
            @else
            <span class="badge bg-label-success  ms-2">
              COD
            </span>
            @endif
            @endif
          </h5>
          <p class="text-body mb-0">{{$formattedDate ?? ''}}</p>
          <p class="text-body mb-0">Order Status:
            @if($data['order']->order_status == '0')
            <span class="badge bg-label-warning me-2 ms-2">
              Pending
              @elseif($data['order']->order_status == '1')
              <span class="badge bg-label-success me-2 ms-2">
                Confirmed
                @else
                <span class="badge bg-label-danger me-2 ms-2">
                  Cancel
                  @endif
                </span>
          </p>
          <p class="text-body mb-0">Warehouse:
            @if(!empty($data['order']->warehouse_id) && ($data['order']->warehouse_accept == '0'))
            Assign But Not Accepted!
            @elseif(!empty($data['order']->warehouse_id) && ($data['order']->warehouse_accept == '1'))
            Assign and Accepted!
            @elseif(!empty($data['order']->warehouse_id) && ($data['order']->warehouse_accept == '2'))
            Assign but Rejected!
            @else
            Not Assign to warehouse
            @endif
          </p>
          @if($data['order']->warehouse_accept == '1')
          <p>Warehouse Detail-{{$warehouse->name}}</p>
          @endif
        </div>
      </div>
      <!-- <div class="col-12 col-lg-3 ">
      <div class="d-flex align-content-center flex-wrap gap-2">
        @if(Auth::guard('user')->user()->role == 'warehousemanager')
          <button class="btn btn-label-green delete-order">View Invoice</button>
        @elseif(Auth::guard('user')->user()->role == 'datamanager')
        <button class="btn btn-label-green delete-order">View Invoice</button>
        @else
        <button class="btn btn-label-green delete-order">View Invoice</button>
        @endif
      </div>
      </div> -->
      <div class="col-12 col-lg-4">
        <div class="card mb-4" style="height: 180px;">

          <div class="card-body p-3">
            <div class="card-header p-1">
              <h5 class="card-title m-0 fw-bold">Customer details</h5>
            </div>
            <div class="d-flex justify-content-start align-items-center mb-2">
              <div class="avatar me-2">
                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
              </div>
              <div class="d-flex flex-column">
                <a href="app-user-view-account.html" class="text-body text-nowrap">
                  <h6 class="mb-1">{{$data['user_add']->first_name ?? '--'}} {{$data['user_add']->last_name ?? '--'}}</h6>
                </a>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <h6 class="mb-2">Contact info</h6>
            </div>
            <p class=" mb-1">Email: {{$data['user_add']->email ?? '--'}}</p>
            <p class=" mb-0">Mobile: {{$data['user_add']->phone ?? '--'}}</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="card mb-4" style="height: 180px;">
          <div class="card-body p-3">
            <h5 class="card-title m-1 fw-bold">Shipping address - </h5>
            <p class="mb-0">{{$data['user_add']->address. ',' ?? ''}} {{$data['user_add']->landmark. ',' ?? ''}} {{$data['user_add']->city ?? ''}}<br>{{$data['user_add']->state.',' ?? ''}} <br>{{$data['user_add']->pincode ?? ''}}</p>
          </div>
        </div>
      </div>
    </div>

    @if(Session::has('success'))
      <p class="alert alert-success">{{Session::get('success')}}</p>
    @endif

    <div class="row">
      <div class="col-12 ">
        <div class="card mb-4">

          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="col-6">
              <h5 class="card-title m-0">Order details</h5>
            </div>
            <div class="col-6 text-end">
              @if(Auth::guard('user')->user()->role == 'warehousemanager')
               @if(!$data['order']->invoice)
                  <span class="mx-3"><b>Invoice Not Uploded Yet!</b></span>
                @endif
              @if($data['order']->warehouse_accept == '1' && !empty($data['order']->invoice))
                <a href="{{$data['order']->invoice->file_name}}" data-id="{{$data['order']->id}}" target="_blank"><button type="button" class="btn btn-success">View Invoice</button></a>
              @elseif($data['order']->warehouse_accept == '0')
              <a href="{{route('order_conf',['id'=>$data['order']->id, 'type' => '1'])}}" data-id="{{$data['order']->id}}"><button type="button" class="btn btn-primary">Accept</button></a>
              <a href="{{route('order_conf',['id'=>$data['order']->id, 'type' => '2'])}}" data-id="{{$data['order']->id}}"><button type="button" class="btn btn-danger">Reject</button></a>
              @endif

              @else
                <a href="javascript(0);" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#invoice_modal" id="upload_invoice" data-id="{{$data['order']->id}}">
                  @if($data['order']->invoice)
                    Already Uploaded
                  @else
                    Upload Invoice
                  @endif
                  </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#warehouse_modal" id="assign_wh" data-id="{{$data['order']->id}}">
                  <button type="button" class="btn btn-primary">
                    @if(!empty($data['order']->warehouse_id))
                    Reassign to warehouse
                    @else
                    Assign to warehouse
                    @endif
                  </button>
                </a>
                
              @endif
            </div>
            {{-- <h6 class="m-0"><a href=" javascript:void(0)">Edit</a></h6> --}}
          </div>
          <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
              <table class="datatables-order-details table dataTable no-footer dtr-column" id="DataTables_Table_0">
                <thead>
                  <tr>
                    <th class="control sorting_disabled dtr-hidden" rowspan="1" colspan="1" style="width: 0px; display: none;" aria-label=""></th>
                    <th class="text-nowrap sorting_disabled" rowspan="1" colspan="1" aria-label="products">Sr No.</th>
                    <th class="  sorting_disabled" rowspan="1" colspan="1" aria-label="products">products</th>
                    <th class="text-nowrap  sorting_disabled" rowspan="1" colspan="1" aria-label="products">Product SKU</th>
                    <th class="text-nowrap  sorting_disabled" rowspan="1" colspan="1" aria-label="products">Artical No</th>
                    <th class="  sorting_disabled" rowspan="1" colspan="1" aria-label="products">GST No</th>
                    <th class=" sorting_disabled" rowspan="1" colspan="1" aria-label="price">price</th>
                    <th class="  sorting_disabled" rowspan="1" colspan="1" aria-label="qty">qty</th>
                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="total">total</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $subtotal = 0;
                  $total_dis = 0;
                  $tax = 0;
                  @endphp
                  @foreach ($data['product'] as $key=>$item)
                  <tr class="odd">
                    <td>{{$key+1}}</td>
                    <td class="sorting_1">
                      <div class="d-flex justify-content-start align-items-center ">
                        <div class="avatar-wrapper">
                          <div class="avatar me-2"><img src="{{$item->image}}" alt="product-Wooden Chair" class="rounded-2"></div>
                        </div>
                        <div class="d-flex flex-column">
                          <h6 class="text-body mb-0">{{$item->name}}</h6><small class="text-muted">Material: Wooden</small>
                        </div>
                      </div>
                    </td>
                    <td>{{$item->sku_code}}</td>
                    <td>{{$item->artical_no}}</td>
                    <td>--</td>
                    <td><span>{{$item->selling_price}}</span></td>
                    <td><span class="text-body">{{$item->qty}}</span></td>
                    @php
                    $discount = intval($item->selling_price)*(intval($item->off)/100);
                    $actual_price = ($item->selling_price - round($discount, 2)) * intval($item->qty);

                    $subtotal = $subtotal+$actual_price;
                    $total_dis = $total_dis + $discount;
                    // $subtotal = 0;
                    // $total_dis = 0;
                    // $actual_price = 0;
                    @endphp
                    <td>
                      <h6 class="mb-0">{{$actual_price}}</h6>
                    </td>
                  </tr>
                  @endforeach
                  @php
                  $grand_total = $subtotal - $total_dis;
                  @endphp
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end align-items-center m-3 mb-2 p-1">
              <div class="order-calculations w-25">
                <div class="d-flex justify-content-between mb-2">
                  <span class="w-px-100">Subtotal:</span>
                  <span class="text-heading">{{$subtotal}}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="w-px-100">Discount:</span>
                  <span class="text-heading mb-0">{{$total_dis}}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="w-px-100">Tax:</span>
                  <span class="text-heading">{{$tax}}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <h6 class="w-px-100 mb-0">Total:</h6>
                  <h6 class="mb-0">{{$grand_total}}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-12 col-lg-4 d-none">
        <div class="card mb-4">
          <div class="card-header">
            <h6 class="card-title m-0">Customer details</h6>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-start align-items-center mb-4">
              <div class="avatar me-2">
                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle">
              </div>
              <div class="d-flex flex-column">
                <a href="app-user-view-account.html" class="text-body text-nowrap">
                  <h6 class="mb-0">{{$data['user']->name ?? ''}}</h6>
                </a>
                {{-- <small class="text-muted">Customer ID: #58909</small> --}}
              </div>
            </div>
            {{-- <div class="d-flex justify-content-start align-items-center mb-4">
              <span
                class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center"><i
                  class="bx bx-cart-alt bx-sm lh-sm"></i></span>
              <h6 class="text-body text-nowrap mb-0">12 Orders</h6>
            </div> --}}
            <div class="d-flex justify-content-between">
              <h6>Contact info</h6>
              {{-- <h6><a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editUser">Edit</a></h6> --}}
            </div>
            <p class=" mb-1">Email: {{$data['user']->email ?? '--'}}</p>
            <p class=" mb-0">Mobile: {{$data['user']->phone ?? '--'}}</p>
          </div>
        </div>

        <div class="card mb-4">

          <div class="card-header d-flex justify-content-between">
            <h6 class="card-title m-0">Shipping address - </h6>
          </div>
          <div class="card-body">
            <p class="mb-0">{{$data['user_add']->address. ',' ?? ''}} {{$data['user_add']->landmark. ',' ?? ''}} {{$data['user_add']->city ?? ''}}<br>{{$data['user_add']->state.',' ?? ''}} <br>{{$data['user_add']->pincode ?? ''}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ============================== -->
@include('Admin.Modal.modal')
<script>
  $(document).ready(function() {
    $("#assign_wh").on("click", function() {
      var order_id = $(this).data("id");
      $("#order_id").val(order_id);
    });

    $("#upload_invoice").on("click", function() {
      var order_id = $(this).data("id");
      console.log(order_id);
      $("#orderId").val(order_id);
    });
  });
</script>
@endsection