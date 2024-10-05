@php

$warehouse = App\Models\Warehouse::where('status','1')->get(['id','name','code']);

@endphp
<!----- Modal start here ------->
<!---*********** Add Category Modal Start Here ***********--->
<div class="modal fade" id="add_catrgory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-category',['type'=>'all']) }}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <!--- Hidden Category Type ---------->
                    @if(isset($type))
                    <input type="hidden" name="type" value="{{$type}}">
                    @endif
                    <div class="col-md-12">
                        <label for="cat_name">Name</label>
                        <input type="text" class="form-control" name="cat_name" id="cat_name" placeholder="Category Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="image">Category Image</label>
                        <input type="file" class="form-control" id="image" name="image" placeholder="Select Iamge" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="banner_image">Banner Image</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image" placeholder="Select Iamge" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="2" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---*********** Add Category Modal Start Here ***********--->
<!---*********** Edit Category Modal Start Here ***********--->
<div class="modal fade" id="edit_catrgory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_catrgory">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- @dd($data) --}}
                <form action="{{ route('add-category',['type'=>'all']) }}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <!--- Hidden Category Type ---------->
                    <input type="hidden" name="id" id="cat_id">
                    @if(isset($type))
                    <input type="hidden" name="type" value="{{$type}}">
                    @endif
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="cat_name" id="edit_cat_name" placeholder="Category Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" class="form-control" id="edit_cat_image" name="image" placeholder="Select Iamge" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <textarea name="description" id="edit_cat_description" cols="30" rows="2" class="form-control" placeholder="description"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---*********** Edit Category Modal Start Here ***********--->
<!---************ Delete Category Modal Start Here ***********-->
<div class="modal fade" id="category_delete_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Are you sure to want to delete this Category? If you Delete this category then the sub
                            category is also deleted.</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    Close
                </button>
                <input type="hidden" id="delete_id">
                <button type="button" class="btn btn-primary btn-sm" id="delete_category_btn">Yes Delete</button>
            </div>
        </div>
    </div>
</div>
<!---*********** Delete Category Modal End Here ************--->

<!---*********** Add Banner Modal Start Here ***********--->
<div class="modal fade" id="add_banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="needs-validation" id="add_banner_form" nonvalidate enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="sub_cat_name" id="banner_name" placeholder="Banner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <select class="form-select" id="banner_type" name="select_type" aria-label="Default select example">
                            <option disabled selected>Select Type</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="path_lab">Path Lab</option>
                            <option value="ambulance">Ambulance</option>
                            <option value="hospital">Hospital</option>
                            <option value="video_call">Video Call</option>
                            <option value="e_clinic">E-Clinic</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" name="image" class="form-control" id="bannner_img">
                    </div>
                    <div class="col-md-12 mt-3">
                        <textarea name="description" id="banner_desc" cols="30" rows="2" class="form-control" placeholder="Description"></textarea>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" id="" class="btn btn-primary addbanner_id">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---*********** Add Banner Modal End Here ***********--->

<!---*********** Edit Banner Modal Start Here ***********--->
<div class="modal fade" id="edit_banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sub_category_form" class="needs-validation" novalidate>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="sub_cat_name" id="banner_name" placeholder="Banner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <select class="form-select" id="type" aria-label="Default select example">
                            <option disabled selected>Select Type</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="path_lab">Path Lab</option>
                            <option value="ambulance">Ambulance</option>
                            <option value="hospital">Hospital</option>
                            <option value="video_call">Video Call</option>
                            <option value="e_clinic">E-Clinic</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                    <div class="col-md-12 mt-3">
                        <textarea name="description" id="description" cols="30" rows="2" class="form-control" placeholder="Description"></textarea>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---*********** Edit Banner Modal End Here ***********--->

<!---*********** Edit Sub Category Modal Start Here ***********--->
<div class="modal fade" id="edit_subCat_nodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Edit Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sub_category_form" class="needs-validation" novalidate>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="sub_cat_name" id="edit_sub_cat_name" placeholder="Sub Category Name" aria-label="Owner Name">
                    </div>
                    {{-- <div class="col-md-12 mt-3">
            <input type="file" class="form-control" id="cat_image" name="image" placeholder="Select Iamge" aria-label="Owner Name">
          </div> --}}
                    <!--- Hidden Category Type ---------->
                    <input type="hidden" id="edit_sub_cat_id" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" id="category_id">
                    <div class="col-md-12 mt-3">
                        <textarea name="description" id="edit_sub_cat_description" cols="30" rows="2" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="button" class="btn btn-primary edit_sub_category_btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---*********** Edit Sub Category Modal Start Here ***********--->

<!--********************* Add Trusted Parthner Modal *************************-->
<div class="modal fade" id="add_partner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('trusted_prt_save')}}" class="needs-validation" novalidate>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="name" id="edit_name" placeholder="Partner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" class="form-control" name="image" placeholder="Partner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--************************ trusted Partner ****************************-->

<!--********************* Edit Trusted Parthner Modal *************************-->
<div class="modal fade" id="edit_partner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('trusted_prt_save')}}" class="needs-validation" enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    <input name="id" type="hidden" id="partner_edit_id">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="name" id="edit_partner_name" placeholder="Partner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" class="form-control" name="image" placeholder="Partner Name" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--************************ trusted Partner ****************************-->


<!----------------------- assign warehouse --------------------------------->
<div class="modal fade" id="warehouse_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warehouse_modal">Assign Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('assign_warehouse')}}" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <div class="col-md-12">
                        <label for="warehouse">Select Warehouse</label>
                        <select class="form-select form-control" name="warehouse_id">
                            <option value="" selected disabled>Select Warehouse</option>
                            @foreach ($warehouse as $item)
                            <option value="{{$item->id}}">{{$item->name}},{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------- assign warehouse --------------------------------->

<!----------------------- Upload Invoice --------------------------------->
<div class="modal fade" id="invoice_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoice_modal">Order Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('orderInvoiceUpload')}}" class="needs-validation" enctype="multipart/form-data" novalidate method="POST">
                    @csrf
                    <input type="hidden" id="orderId" name="order_id">
                    <div class="col-md-12">
                        <label for="warehouse">Upload Invoice</label>
                        <input type="file" name="invoice" class="form-control">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------- Upload Invoice --------------------------------->


<!----------------------- Edit Industry --------------------------------->
<div class="modal fade" id="edit_industry" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_industry">Edit Industry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('industry_save')}}" enctype="multipart/form-data" class="needs-validation" novalidate method="POST">
                    @csrf
                    <input type="hidden" name="industry_id" id="industry_id">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="name" id="industry_name" placeholder="Enter Name" aria-label="Enter Name" value="{{old('name')}}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" name="image" class="form-control" id="image" placeholder="Choose Image" required>
                    </div>
                    <div class="col-md-2 col-lg-1 col-sm-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------- Edit Industry --------------------------------->

<!----------------------- Edit Industry --------------------------------->
<div class="modal fade" id="edit_offer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_offer">Edit Industry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('offer_save')}}" class="needs-validation" novalidate enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="offer_id" id="offer_id">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="name" id="offer_name" placeholder="Enter Name" aria-label="Enter Name" value="{{old('name')}}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="file" name="image" class="form-control" id="image" placeholder="Choose Image" required>
                    </div>
                    <div class="col-md-2 col-lg-1 col-sm-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------- Edit Industry --------------------------------->
<!----------------------- Import C2 and Leaf Category ------------------->
<div class="modal fade" id="import_c2_leaf_cat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Import C2 and leaf Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('import_c2_leaf_cat')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label for="csv_file">Csv File</label>
                        <input type="file" class="form-control" name="csv_file" id="csv_file" placeholder="Import Csv">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------- Import C2 and Leaf Category ------------------->

<!--********************* Add Reward Modal *************************-->
<div class="modal fade" id="add_reward" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory"><strong>Add Reward</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('add_reward')}}" class="needs-validation" enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label>Amount Range</label>
                        <input type="text" class="form-control" name="amount_range" placeholder="1000-1500" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Reward Points</label>
                        <input type="text" class="form-control" name="reward_point" placeholder="10" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--********************* Add Reward Modal *************************-->

<!--********************* Add Reward Modal *************************-->
<div class="modal fade" id="edit_reward" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_reward"><strong>Edit Reward</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('add_reward')}}" class="needs-validation" enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    <input type="hidden" id="reward_id" name="id">
                    <div class="col-md-12">
                        <label>Amount Range</label>
                        <input type="text" class="form-control" name="amount_range" id="amount_range" placeholder="1000-1500" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Reward Points</label>
                        <input type="text" class="form-control" name="reward_point" id="reward_point" placeholder="10" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--********************* Add Reward Modal *************************-->