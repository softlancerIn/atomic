@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'reward';
?>
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
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Reward List</h4>
            </div>
            <div class="col-6 text-end">
                <a href="#"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_reward">Add Reward</button></a>
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

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card p-2">
            {{-- <h5 class="card-header">Borderless Table</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Order Amount Range</th>
                            <th>Reward</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['reward'] as $key=>$item)
                        <tr>
                            <td>
                                <strong>{{$key+1}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->amount_range}}</strong>
                            </td>
                            <td>{{$item->reward_point}}</td>
                            <td class="d-flex">
                                <div class="mx-2">
                                    <a href="#" class=""><button type="button" class="btn-sm btn-success editreward" data-bs-toggle="modal" data-bs-target="#edit_reward" data-id="{{$item->id}}">Edit</button></a>
                                </div>
                                <div class="">
                                    <a href="{{route('global_delete',['type'=>'reward','id'=>$item->id])}}"><button type="button" class="btn-sm btn-primary">Delete</button></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no any data are available!</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
            <div class="d-flex justify-content-center">
            {{ $data['reward']->links('Admin.pagination')}}
            </div>
        <!--/ Borderless Table -->
    </div>
</div>
@include('Admin.Modal.modal')
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

    $('.editreward').on("click", function() {
        var id = $(this).data("id");
        console.log(id);
        axios.post("{{route('edit_reward')}}", {
            'id': id,
        }).then(res => {
            console.log(res);
            $('#reward_id').val(res.data.data.id);
            $('#amount_range').val(res.data.data.amount_range);
            $('#reward_point').val(res.data.data.reward_point);
        }).catch(error => {
            console.error(error);
        });
    });

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