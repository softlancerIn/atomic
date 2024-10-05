@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'home_slider';
?>
<!------------Styling------------>
<style>
    .inline-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .d-flex nav {
        display: block !important;
    }

    .w-5 {
        width: 23px;
        height: 23px;
    }

    div nav .justify-between {
        display: none;
    }

    .sm:justify-between div p {
        display: none;
    }
</style>
<!------------Styling------------>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Home Slider List</h4>
            </div>
            <div class="col-6 text-end">
                {{-- <a href="{{url()->previous()}}" class="btn btn-primary">Go Back</a> --}}
                <a href="{{route('home_slider_create')}}" class="btn btn-primary">Add Home Slider</a>
            </div>
        </div>
        <!-- Borderless Table -->

        <!--- Session flash message -------->
        @if(Session::has('message'))
        <div class="flash-message">
            <p class="alert alert-success">{{ Session::get('message') }}</p>
        </div>
        @endif
        <!--- Session flash message -------->

        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Slider Type</th>
                            <th>Product Name</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($data) && sizeof($data) > 0)
                        @forelse ($data['slider'] as $key=>$item)
                        <tr>
                            <td>{{$key +1}}</td>
                            <td>
                                @switch($item->type)
                                    @case('engineer_service')
                                        Engineering Service Slider
                                        @break;
                                    @case('super_special_offer')
                                        Super Special Offer Slider
                                        @break;
                                    @case('obsolute_discontinued_item')
                                        Obsolute or Discontinued Item Slider
                                        @break;
                                    @case('robot_spares_slider')
                                        Robot and Robot Spares Slider
                                        @break;
                                    @case('deal_of_the_day')
                                        Deal of thr Day Slider
                                        @break;
                                    @case('engineer_drawing_tool')
                                        Engineering Drawing and Tools Slider
                                        @break;
                                    @case('refurnished_product')
                                        Refurnished Product Slider
                                        @break;
                                    @case('highest_selling_product')
                                        Highest Selling Product Slider
                                        @break;
                                @endswitch
                            </td>
                            <td class="text-wrap">
                                {{$item->product_name}}
                            </td>
                            <td class="text-wrap">
                                <strong>{{!empty($item->name) ? $item->name : '--'}}</strong>
                            </td>
                            <td>
                                @if(!empty($item->image))
                                <img src="{{$item->image}}" alt="" width="50px" height="50px" />
                                @else
                                --
                                @endif
                            </td>
                            <td style="width: 20px;">
                                <a href="{{route('home_slider_edit',['id'=>$item->id])}}" class="btn btn-primary text-white">Edit</a>
                                <a href="{{route('global_delete',['type'=>'home_slider','id'=>$item->id])}}" class="btn btn-primary text-white">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">Data Not Found!!</h5>
                            </td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $data['slider']->links('Admin.pagination')}}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

    $('.delete_cat_btn').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        $('#delete_id').val(cat_id);
    });

    $('#delete_category_btn').on("click", function() {
        var delete_id = $('#delete_id').val();
        axios.post("{{route('delete-category')}}", {
                'id': delete_id,
            })
            .then(res => {
                console.log(res);
                window.location.reload()
            }).catch(error => {
                console.error(error);
            });
    });
</script>
@endsection