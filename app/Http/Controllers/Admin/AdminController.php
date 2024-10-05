<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\{
    Users,
    Files,
    Agent,
    Brand,
    Stock,
    Offer,
    Coupon,
    Career,
    Reward,
    Product,
    Category,
    Industry,
    ContactUs,
    Warehouse,
    HomeSlider,
    ProductImage,
    OrderInvoice,
    TrustedPartner,
    ProductVarient,
    ProductAttribute,
};

use App\Models\Admin;
use App\Models\Notification;
use App\Models\SubCategory;
use App\Models\Banner;
use App\Models\File;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use DB;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use CommonTrait;

    public function __construct() {}

    public function api_file_path()
    {
        return env('UPLOAD_FILE');
    }

    public function index()
    {
        return view('Admin.login');
    }

    //======================== Log Sign up releted function ======================//
    public function login(Request $request)
    {
        $user_check = Agent::where('email', $request->email)->first();
        if (empty($user_check)) {
            return redirect()->back()->with('error', 'Invalid Credentials!');
        } else {
            $check_pass = Hash::check($request->password, $user_check->password);
            if (!empty($check_pass)) {
                Auth::guard('user')->loginUsingId($user_check->id);
                return redirect()->route('dashboard')->with('Login Successfully!');
            } else {
                return redirect()->back()->with('error', 'Invalid Credentials!');
            }
        }
    }

    public function register(Request $request)
    {
        return view('Admin.register');
    }

    public function registration(Request $request)
    {
        $validatedata = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required',
        ]);

        if ($request->password != $request->c_password) {
            return redirect()->back()->with('error', 'Password And Confirm Password Not Matched!');
        }
        $check_email = Agent::where('email', $request->email)->first();

        if (!empty($check_email)) {
            if (!empty($check_email->password)) {
                return redirect()->back()->with('error', 'You have already registered please login with your credentials!');
            } else {
                $password = $request->password;
                $register = Agent::where('email', $request->email)->update([
                    'password' => Hash::make($password),
                ]);
                if ($register == '1' || $register == '0') {
                    Auth::guard('user')->loginUsingId($check_email->id);
                    return redirect()->route('dashboard')->with('Login Successfully!');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Email Not Registered!');
        }
    }

    //======================== Log Sign up releted function ======================//

    public function dashboard()
    {
        $data = [];
        $data['user'] = Users::count();
        $data['banner'] = Banner::count();
        $data['category'] = Category::count();
        $data['product'] = Product::count();
        $data['order'] = Order::count();
        $data['confirm_order'] = Order::where('order_status', '1')->count();
        $data['crops'] = [];
        $data['pending_order'] = Order::where('order_status', '0')->count();
        return view('Admin.index', compact('data'));
    }

    public function dashboard2()
    {
        return view('Admin.index');
    }

    public function bank(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data['bank_details'] = [];
            return view('Admin.Bank.index', compact('data'));
        } else {
            //
        }
    }

    public function allUsers(Request $request)
    {
        $user = Users::all();
        $users['users'] = $user->map(function ($item) {
            $item->address = UserAddress::where('user_id', $item->id)->first(['address']);
            return $item;
        });
        /// custom pagination when use mapping data ///
        $perPage = 10;
        $page = request()->get('page', 1);
        $all_user = new \Illuminate\Pagination\LengthAwarePaginator(
            $users['users']->forPage($page, $perPage),
            $users['users']->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
        return view('Admin.User.index', compact('all_user'));
    }

    public function adduserform()
    {
        return view('Admin.User.create');
    }
    // ==========================================================================
    public function addUser(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'block_status' => 'required',
        ]);

        $add_user = Users::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'block_status' => $request->block_status
        ]);

        return redirect()->route('users')->with('success', 'add user  successfully.');
    }
    // ==================================================================================
    public function user_create(Request $request)
    {
        $user_add = User::create([
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'phone' => $request->phone ?? '',
            'address' => $request->address ?? '',
            'pincode' => $request->pincode ?? '',
            'married_status' => $request->married_status ?? '',
            'spouse_name' => $request->spouse_name ?? '',
            'childname' => $request->childname ?? '',
            'image' => $request->image ?? '',
            'health_insurance' => $request->health_insurance ?? '',
            'password' => $request->password ?? '',
            'block_status' => $request->block_status ?? '',
            'register_status' => $request->register_status ?? '',
        ]);

        if (!empty($user_check)) {
            return redirect()->route()->with('message', 'User Added Succefully!');
        } else {
            return response()->json(['message' => 'Somethinf went wrong!']);
        }
    }

    public function user_edit(Request $request)
    {
        $user_edit = User::where('id', $request->id)->first();
        return view('Admin.User.edit', compact('user_edit'));
    }

    public function updateUser(Request $request)
    {
        $update_user = Users::where('id', $request->user_id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'block_status' => $request->block_status,

        ]);
        return redirect()->route('users')->with('success', 'Update user  successfully.');
    }

    public function deleteUser($id)
    {
        $delete_user = Users::where('id', $id)->first();
        $delete_user->delete();
        return redirect()->route('users')->with('success', 'Users delete successfully');
    }

    public function statusUser(Request $request)
    {
        $status_change = Users::where('id', $request->id)->first();
        $status_change->update([
            'block_status' => $request->status,
        ]);
        return response()->json(['status' => true, 'success' => 'status chaned successfully!']);
    }
    // =================================Banner-start==================================
    public function banner(Request $request)
    {
        $banner['banner'] = Banner::paginate(10);

        return view('Admin.Banner.index', compact('banner'));
    }

    public function addbannersForm()
    {
        $data['category'] = Category::get();
        return view('Admin.Banner.create', compact('data'));
    }

    public function addBanner(Request $request)
    {
        $validatedata = $request->validate([
            'banner_name' => 'required',
            'banner_type' => 'required',
            'web_image' => 'required',
            'mobile_image' => 'required',
            'description' => 'required',
        ]);

        $web_image = $request->web_image;
        $web_Image = time() . $web_image->getClientOriginalName();
        $web_image->move(public_path('uploads/banners/'), $web_Image);

        $mobile_image = $request->mobile_image;
        $mobile_Image = time() . $mobile_image->getClientOriginalName();
        $mobile_image->move(public_path('uploads/banners/'), $mobile_Image);

        $add_banner = Banner::create([
            'name' => $request->banner_name,
            'type' => $request->banner_type ?? '',
            'link' => $request->link,
            'description' => $request->description ?? '',
            'web_image' => $web_Image ?? '',
            'mobile_image' => $mobile_Image ?? '',
        ]);
        if (!empty($add_banner)) {
            return redirect()->route('banners')->with('message', 'Banner Addedd Successfully!');
        } else {
            return response()->json(['message' => 'Something went wrong!']);
        }
    }

    public function editBanner(Request $request)
    {
        $id = $request->id;
        $data = [];
        $products = Banner::where('id', $id)->first();
        $data['products'] = $products;
        return view('Admin.Banner.edit', compact('data'));
    }

    public function upadateBanner(Request $request)
    {
        if (!empty($request->web_image)) {
            $web_fileName = time() . '_' . $request->web_image->getClientOriginalName();
            $request->web_image->move(public_path('uploads/banners'), $web_fileName);

            $update_agent = Banner::where('id', $request->update_id)->update([
                'web_image' => $web_fileName ?? '',
            ]);
        }

        if (!empty($request->mobile_image)) {
            $mobile_fileName = time() . '_' . $request->mobile_image->getClientOriginalName();
            $request->mobile_image->move(public_path('uploads/banners'), $mobile_fileName);

            $update_agent = Banner::where('id', $request->update_id)->update([
                'mobile_image' => $mobile_fileName ?? '',
            ]);
        }


        $update_agent = Banner::where('id', $request->update_id)->update([
            'name' => $request->sub_cat_name,
            'type' => $request->select_type ?? '',
            'link' => $request->link,
            'description' => $request->description ?? '',
        ]);


        return redirect()->route('banners')->with('success', 'Update Banner  successfully.');
    }

    public function deleteBanner($id)
    {
        $delete_agent = Banner::where('id', $id)->first();
        $delete_agent->delete();
        return redirect()->route('banners')->with('success', 'banner deleted successfully');
    }


    public function editUser(Request $request)
    {
        $id = $request->id ?? '';
        $data = [];
        $user = Users::where('id', $request->id)->first();
        $data['user'] = $user;
        return view('Admin.User.edit', compact('data'));
    }


    public function categoryList(Request $request, $type)
    {
        switch ($type) {
            case 'new':
                $data['type'] = 'new';
                $data['category_data'] = Category::where('type', '0')->paginate(20);
                return view('Admin.Category.c_index', compact('data'));
                break;
            case 'approved':
                $data['type'] = 'approved';
                $data['category'] = Category::where(['type' => '0', 'status' => '1'])->get();

                if ($request->has('search')) {
                    $data['category_data'] = Category::where('name', 'LIKE', $request->search . '%')->where('type', '1')->paginate(10);
                } else {
                    $data['category_data'] = Category::where('type', '1')->paginate(20);
                }

                foreach ($data['category_data'] as $item) {
                    $cat_name = Category::where('id', $item->cat_id)->first();
                    $item->category_name = $cat_name->name ?? '--';
                }
                return view('Admin.Category.c_index', compact('data'));
                break;
            case 'reject':
                $data['type'] = 'reject';
                $data['category'] = Category::where(['type' => '1', 'status' => '1'])->get();

                if ($request->has('search')) {
                    $data['category_data'] = Category::where('name', 'LIKE', $request->search . '%')->where('type', '2')->paginate(10);
                } else {
                    $data['category_data'] = Category::where('type', '2')->paginate(20);
                }



                foreach ($data['category_data'] as $item) {
                    if (!empty($item->cat_id)) {
                        $c1_cat_name = Category::where('id', $item->cat_id)->first();
                        $item->c1_category_name = $c1_cat_name->name ?? '';
                    } else {
                        $item->c1_category_name = '';
                    }
                    if (!empty($c1_cat_name->cat_id)) {
                        $cat_name = Category::where('id', $c1_cat_name->cat_id)->first();
                        $item->category_name = $cat_name->name ?? '';
                    } else {
                        $item->category_name = '';
                    }
                }
                return view('Admin.Category.c_index', compact('data'));
                break;
        }
    }

    public function addCategory(Request $request, $type)
    {
        $slug = $this->createSlug($request->name);
        switch ($type) {
            case 'all':
                if ($request->has('id')) {
                    $validatedata = $request->validate([
                        'cat_name' => 'required',
                        'description' => 'required',
                    ]);


                    if ($request->has('image')) {
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                        $add_category = Category::where('id', $request->id)->update([
                            'image' => $images,
                        ]);
                    }
                    if ($request->has('banner_image')) {
                        $banner_img = time() . '-' . $request->banner_image->getClientOriginalName();
                        $request->banner_image->move(public_path('uploads/Category'), $images);
                        $add_category = Category::where(['id' => $request->id])->update([
                            'banner_img' => $banner_img,
                        ]);
                    }

                    $slug = $this->createSlug($request->cat_name);

                    $add_category = Category::where(['id' => $request->id])->update([
                        'name' => $request->cat_name,
                        'cat_id' => '0',
                        'slug' => $slug,
                        'description' => $request->description ?? '',
                    ]);
                } else {
                    $validatedata = $request->validate([
                        'cat_name' => 'required',
                        // 'image' => 'required',
                        'description' => 'required',
                    ]);

                    $slug = $this->createSlug($request->cat_name);

                    if ($request->has('image')) {
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                    } else {
                        $images = '';
                    }
                    if ($request->has('banner_image')) {
                        $banner_img = time() . '-' . $request->banner_image->getClientOriginalName();
                        $request->banner_image->move(public_path('uploads/Category'), $images);
                    } else {
                        $banner_img = '';
                    }

                    $add_category = Category::create([
                        'name' => $request->cat_name,
                        'slug' => $slug,
                        'image' => $images,
                        'banner_img' => $banner_img,
                        'cat_id' => '0',
                        'description' => $request->description ?? '',
                    ]);
                }

                if (!empty($add_category)) {
                    return redirect()->route('categoryList', ['type' => 'all'])->with('message', 'Category Addedd Successfully!');
                } else {
                    return response()->json(['message' => 'Something went wrong!']);
                }

                break;
            case 'c1':
                if ($request->has('id')) {
                    if ($request->has('image') && !empty($request->image)) {
                        $validatedata = $request->validate([
                            'image' => 'required',
                        ]);
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                        $update_category = Category::where('id', $request->id)->update([
                            'image' => $images,
                        ]);
                    }
                    $validatedata = $request->validate([
                        'name' => 'required',
                        'cat_id' => 'required',
                    ]);

                    $update_category = Category::where('id', $request->id)->update([
                        'name' => $request->name,
                        'slug' => $slug,
                        'cat_id' => $request->cat_id
                    ]);
                    return redirect()->route('categoryList', ['type' => 'c1'])->with('success', 'Data Updated Successfully!');
                } else {
                    $validatedata = $request->validate([
                        'name' => 'required',
                        // 'image' => 'required',
                        'cat_id' => 'required',
                    ]);

                    if ($request->has('image')) {
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                    } else {
                        $images = '';
                    }
                    $add_category = Category::create([
                        'name' => $request->name,
                        'slug' => $slug,
                        'image' => $images,
                        'cat_id' => $request->cat_id,
                        'type' => '1'
                    ]);
                    if (!empty($add_category)) {
                        return redirect()->back()->with('success', 'Data Added Successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
            case 'c2':
                if ($request->has('id')) {
                    if ($request->has('image')) {
                        $validatedata = $request->validate([
                            'image' => 'required',
                        ]);
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                        $update_category = Category::where('id', $request->id)->update([
                            'image' => $images,
                        ]);
                    }
                    $validatedata = $request->validate([
                        'name' => 'required',
                        'cat_id' => 'required',
                    ]);

                    $update_category = Category::where('id', $request->id)->update([
                        'name' => $request->name,
                        'slug' => $slug,
                        'cat_id' => $request->cat_id
                    ]);
                    return redirect()->route('categoryList', ['type' => 'c2'])->with('success', 'Data Updated Successfully!');
                } else {
                    $validatedata = $request->validate([
                        'name' => 'required',
                        // 'image' => 'required',
                        'cat_id' => 'required',
                    ]);

                    if ($request->has('image')) {
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                    } else {
                        $images = '';
                    }
                    $add_category = Category::create([
                        'name' => $request->name,
                        'slug' => $slug,
                        'image' => $images,
                        'cat_id' => $request->cat_id,
                        'type' => '2'
                    ]);
                    if (!empty($add_category)) {
                        return redirect()->back()->with('success', 'Data Added Successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
            case 'leaf':
                if ($request->has('id')) {
                    if ($request->has('image')) {
                        $validatedata = $request->validate([
                            'image' => 'required',
                        ]);
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                        $update_category = Category::where('id', $request->id)->update([
                            'image' => $images,
                        ]);
                    }
                    $validatedata = $request->validate([
                        'name' => 'required',
                        'cat_id' => 'required',
                    ]);

                    $update_category = Category::where('id', $request->id)->update([
                        'name' => $request->name,
                        'slug' => $slug,
                        'cat_id' => $request->cat_id
                    ]);
                    return redirect()->route('categoryList', ['type' => 'leaf'])->with('success', 'Data Updated Successfully!');
                } else {
                    $validatedata = $request->validate([
                        'name' => 'required',
                        // 'image' => 'required',
                        'cat_id' => 'required',
                    ]);

                    if ($request->has('image')) {
                        $images = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('uploads/Category'), $images);
                    } else {
                        $images = '';
                    }
                    $add_category = Category::create([
                        'name' => $request->name,
                        'slug' => $slug,
                        'image' => $images,
                        'cat_id' => $request->cat_id,
                        'type' => '3'
                    ]);
                    if (!empty($add_category)) {
                        return redirect()->back()->with('success', 'Data Added Successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
        }
    }

    public function editCategory(Request $request, $type, $id)
    {
        $data = [];
        switch ($type) {
            case 'all':
                $edit_category = Category::where('id', $request->id)->first();
                if (!empty($edit_category)) {
                    return response()->json(['status' => true, 'data' => $edit_category]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Something went wrong!']);
                }
                break;
            case 'c1':
                $category = Category::where(['type' => '0'])->get();
                $edit_data = Category::where(['id' => $id, 'type' => '1'])->first();

                $data['type'] = 'C1';
                $data['categories'] = $category;
                $data['edit_data'] = $edit_data;
                return view('Admin.Category.c_edit', compact('data'));
                break;
            case 'c2':
                $category = Category::where(['type' => '1'])->get();
                $edit_data = Category::where(['id' => $id, 'type' => '2'])->first();

                $data['type'] = 'C2';
                $data['categories'] = $category;
                $data['edit_data'] = $edit_data;
                return view('Admin.Category.c_edit', compact('data'));
                break;
            case 'leaf':
                $category = Category::where(['type' => '2'])->get();
                $edit_data = Category::where(['id' => $id, 'type' => '3'])->first();

                $data['type'] = 'leaf';
                $data['categories'] = $category;
                $data['edit_data'] = $edit_data;
                return view('Admin.Category.c_edit', compact('data'));
                break;
        }
    }

    public function updateCategory(Request $request, $type)
    {
        switch ($type) {
            case 'all':
                $update_cat = Category::where('id', $request->cat_id)->update([
                    'name' => $request->cat_name,
                    'description' => $request->description,
                ]);

                if ($update_cat == '1') {
                    return redirect()->route('category', ['type' => $request->type])->with('message', 'Category Updated Successfully!');
                } else {
                    return response()->json(['status' => false, 'message' => 'Something went wrong!']);
                }
                break;
            case 'c1':
                $validatedata = $request->validate([
                    'name' => 'required',
                    'cat_id' => 'required',
                ]);

                if ($request->has('imgae')) {
                    $images = time() . '-' . $request->image->getClientOriginalName();
                    $request->image->move(public_path('uploads/Category'), $images);
                    $update_category = Category::where('id', $request->id)->update([
                        'image' => $images,
                    ]);
                }

                $update_category = Category::where('id', $request->id)->update([
                    'name' => $images,
                    'cat_id' => $request->cat_id
                ]);

                return redirect()->route('categoryList', ['type' => 'c1'])->with('success', 'Data Updated Successfully!');
                break;
        }
    }

    public function sample_c2_leaf_cat()
    {
        $data = [
            [
                'c1_category',
                'c2_category',
                'leaf_category',
            ]
        ];
        return $this->exportCSV($data, 'sample_c2&leaf_file', '', '');
    }

    public function import_c2_leaf_cat(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();

                $extension = $request->file('csv_file')->getClientOriginalExtension();

                if ($extension == 'csv' || $extension == 'xlsx') {
                    $data = array_map('str_getcsv', file($path));
                    $header = array_shift($data);
                    foreach ($data as $key => $row) {
                        if (!empty($row[0])) {
                            $c1_category = Category::where('name', 'like', $row[0] . '%')->first();
                            if (!empty($row[1])) {
                                $c2_check = Category::where('name', 'like', $row[1] . '%')->first();
                                if (empty($c2_check)) {
                                    $c2_slug = $this->createSlug($row[1]);
                                    $add_c2_cat = Category::create([
                                        'cat_id' => $c1_category->id,
                                        'name' => $row[1],
                                        'type' => '2',
                                        'slug' => $c2_slug,
                                        'description' => '',
                                    ]);

                                    $leaf_check = Category::where('name', 'like', $row[2] . '%')->first();
                                    if (empty($leaf_check)) {
                                        $leaf_slug = $this->createSlug($row[2]);
                                        $add_leaf_cat = Category::create([
                                            'cat_id' => $add_c2_cat->id,
                                            'name' => $row[2],
                                            'type' => '3',
                                            'slug' => $leaf_slug,
                                            'description' => '',
                                        ]);
                                    }
                                } else {
                                    $leaf_check = Category::where('name', 'like', $row[2] . '%')->first();
                                    if (empty($leaf_check)) {
                                        $leaf_slug = $this->createSlug($row[2]);
                                        $add_leaf_cat = Category::create([
                                            'cat_id' => $c2_check->id,
                                            'name' => $row[2],
                                            'type' => '3',
                                            'slug' => $leaf_slug,
                                            'description' => '',
                                        ]);
                                    }
                                }
                            }
                        }
                    }

                    $filename =  $this->fileupload($request->csv_file, 'Upload_csv', 'csv_upload');
                    return redirect()->back()->with('success', 'CSV imported successfully');
                } else {
                    return redirect()->back()->with('error', 'Please select a CSV file to import');
                }
            } else {
                return redirect()->back()->with('error', 'Please select a CSV file to import');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    //====================== C2 Category Accessories  =====================//
    public function accesories_list($id)
    {
        $data = [];
        return view('Admin.accesories.index', compact('data'));
    }
    //======================= Brand Releted Function ====================//
    public function brandList()
    {
        $data = [];
        $brand = Brand::paginate(10);
        foreach ($brand as $item) {
            $item->image = env('ADMIN_IMG') . '/brand/' . $item->image;
        }

        $data['brands'] = $brand;
        return view('Admin.Brand.index', compact('data'));
    }

    public function brandAdd(Request $request)
    {
        $slug = $this->createSlug($request->name);
        if ($request->has('id')) {
            $validatedata = $request->validate([
                'name' => 'required',
            ]);
            if ($request->has('image')) {
                $validatedata = $request->validate([
                    'image' => 'required',
                ]);

                $images = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/brand'), $images);

                $update_data = Brand::where('id', $request->id)->update([
                    'image' => $images,
                ]);
            }

            $update_data = Brand::where('id', $request->id)->update([
                'name' => $request->name,
                'slug' => $slug,
            ]);
            return redirect()->route('brandList')->with('succes', 'Data Updated Successfully!');
        } else {
            $validatedata = $request->validate([
                'name' => 'required',
                'image' => 'required',
            ]);
            if ($request->has('image')) {
                $images = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/brand'), $images);
            } else {
                $images = '';
            }

            $add_category = Brand::create([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $images,
            ]);
            return redirect()->back()->with('success', 'Data Added Successfully!');
        }
    }

    public function brandEdit($id)
    {
        $data = [];
        $brand_data = Brand::where('id', $id)->first();
        $data['brand'] = $brand_data;
        return view('Admin.Brand.edit', compact('data'));
    }

    public function brandDelete($id)
    {
        $brand = Brand::where('id', $id)->first();
        $brand->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully!');
    }
    //======================= Brand Releted Function ====================//

    //======================= Coupon Releted Function ====================//
    public function coupon_list()
    {
        $data = [];
        $list = Coupon::paginate(10);
        foreach ($list as $item) {
            $item->image = env("ADMIN_IMG") . '/coupon/' . $item->image;
        }

        $data['coupon'] = $list;
        return view('Admin.coupon.index', compact('data'));
    }

    public function counpon_create(Request $request)
    {
        return view('Admin.coupon.create');
    }

    public function coupon_add(Request $request)
    {
        if ($request->has('id')) {
            $validatedata = $request->validate([
                'name' => 'required',
                'percentage' => 'required',
                'max_amount' => 'required',
                'min_amount' => 'required',
                'description' => 'required',
                'total_discount' => 'required',
                'validate_from' => 'required',
                'valid_to' => 'required',
            ]);

            $upddate_coupon = Coupon::where('id', $request->id)->update([
                'name' => $request->name,
                'percentage' => $request->percentage,
                'max_amount' => $request->max_amount,
                'min_amount' => $request->min_amount,
                'description' => $request->description,
                'total_discount' => $request->total_discount,
                'validate_from' => $request->validate_from,
                'valid_to' => $request->valid_to,
            ]);
            return redirect()->route('coupon_list')->with('success', 'Data Updated Successfully!');
        } else {
            $validatedata = $request->validate([
                'name' => 'required',
                'percentage' => 'required',
                'max_amount' => 'required',
                'min_amount' => 'required',
                'description' => 'required',
                'total_discount' => 'required',
                'validate_from' => 'required',
                'valid_to' => 'required',
            ]);

            $add_coupon = Coupon::create($request->all());
            return redirect()->route('coupon_list')->with('success', 'Coupon Added Successfully!');
        }
    }

    public function coupon_edit($id)
    {
        $data = [];
        $edit_data = Coupon::where('id', $id)->first();
        if (!empty($edit_data)) {
            $data['coupon_data'] = $edit_data;
            return view('Admin.coupon.edit', compact('data'));
        } else {
            return redirect()->route()->with('error', 'Something went wrong!');
        }
    }
    //======================= Coupon Releted Function ====================//

    // ============ Delete Function for c type Category ===========//
    public function deleteC_typeCat(Request $request, $type, $id)
    {
        switch ($type) {
            case 'all':
                $type = '0';
                break;
            case 'c1':
                $type = '1';
                break;
            case 'c2':
                $type = '2';
                break;
            case 'leaf':
                $type = '3';
                break;
            case 'c4':
                $type = '4';
                break;
        }

        $delete_cat = Category::where(['type' => $type, 'id' => $id])->first();
        $delete_cat->delete();
        return redirect()->back()->with('success', 'Data Deleted Successfully!');
    }
    // ============ Delete Function for c type Category ===========//

    //================= Product releted function =============//
    public function product_list(Request $request)
    {
        $data = [];

        if ($request->has('search')) {
            $product = Product::where('status', '1')->where('sku_code', 'LIKE', "$request->search%")->orderBy('id', 'DESC')->paginate(20);
        } else {
            $product = Product::where('status', '1')->orderBy('id', 'DESC')->paginate(20);
        }

        if (!empty($product)) {
            foreach ($product as $key => $item) {
                $main_category = Category::where('id', $item->main_cat_id)->first('name');
                $c1_category = Category::where('id', $item->c1_cat_id)->first('name');
                $c2_category = Category::where('id', $item->c2_cat_id)->first('name');
                $leaf_category = Category::where('id', $item->leaf_cat_id)->first('name');
                $brand = Brand::where('id', $item->brand_id)->first();

                $item->main_cat = !empty($main_category) ? $main_category->name : '';
                $item->c1_cat = !empty($c1_category) ? $c1_category->name : '';
                $item->c2_cat = !empty($c2_category) ? $c2_category->name : '';
                $item->leaf_cat = !empty($leaf_category) ? $leaf_category->name : '';
                $item->brand = !empty($brand) ? $brand->name : '';
            }
        } else {
            $product = [];
        }

        $data['product'] = $product;
        return view('Admin.Product.index', compact('data'));
    }

    public function export_pro_sample()
    {
        $data = [
            [
                'name',
                'brand',
                'main_category',
                'c1_category',
                'c2_category',
                'leaf_category',
                'artical_no',
                'series_name',
                'model_no',
                'mrp',
                'seling_price',
                'unit_of_measurement',
                'selling_unit',
                'magnitude_of_uom',
                'description',
                'image_1',
                'image_2',
                'image_3',
                'image_4',
                'image_5',
                'attribute1a',
                'attribute1b',
                'attribute2a',
                'attribute2b',
                'attribute3a',
                'attribute3b',
                'attribute4a',
                'attribute4b',
                'attribute5a',
                'attribute5b',
                'attribute6a',
                'attribute6b',
                'attribute7a',
                'attribute7b',
                'attribute8a',
                'attribute8b',
                'attribute9a',
                'attribute9b',
                'attribute10a',
                'attribute10b',
                'attribute11a',
                'attribute11b',
                'image',
                'sku_code',
                'hsn',
                'tax',
                'catalogue_url',
                'is_return_available',
                'return_day',
                'faq',
                'width',
                'height',
                'depth',
                'weight',
                'min_quantity',
                'ship_time',
                'accesoriess_cat_name',
            ]
        ];
        return $this->exportCSV($data, 'sample_file', '', '');
    }

    public function import_product(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();

                $extension = $request->file('csv_file')->getClientOriginalExtension();

                if ($extension == 'csv' || $extension == 'xlsx') {
                    $data = array_map('str_getcsv', file($path));
                    $header = array_shift($data);
                    foreach ($data as $key => $row) {
                        if (!empty($row[0])) {
                            $name = '"' . $row[0] . '"';
                            $cleanname = mb_convert_encoding($name, 'UTF-8', 'UTF-8');
                        }

                        $check_data = Product::where('id', $cleanname)->first();

                        if (empty($check_data) && count($row) == 57) {
                            if (!empty($row[0])) {
                                $product_subName = substr($row[0], 0, 13);
                                $trim_name = trim($product_subName);
                                $actual_subName = rtrim(str_replace([' ', ',', '-'], '-', $trim_name), '-');
                                $sku_code = rand(1111111111, 9999999999) . '-' . $actual_subName;
                            } else {
                                $sku_code = (string)rand(1111111111, 9999999999);
                            }

                            if (isset($row[2])) {
                                $main_category = Category::where(['cat_id' => '0', 'type' => '0'])->where('name', 'like', '%' . $row[2] . '%')->first('id');
                                $c1_category = Category::where('type', '1')->where('name', 'like', trim($row[3]))->first('id');
                                if (isset($row[4])) {
                                    $c2_category = Category::where(['type' => '2'])->where('name', 'like', trim($row[4]))->first('id');
                                } else {
                                    $c2_category = '';
                                }
                                if (isset($row[5]) && $row[5] != '') {
                                    $leaf_category = Category::where(['type' => '3'])->where('name', 'like', trim($row[5]))->first('id');
                                } else {
                                    $leaf_category = '';
                                }
                                $brand = Brand::where('name', 'like', '%' . trim($row[1]) . '%')->first('id');
                                $slug = $this->createSlug($row[0]);

                                if (!empty($row[14])) {
                                    $description = '"' . $row[14] . '"';
                                    $cleanDescription = mb_convert_encoding($description, 'UTF-8', 'UTF-8');
                                }
                                if (isset($row[56]) && !empty($row[56])) {
                                    $accesories_cat = Category::where(['type' => '2'])->where('name', 'like', '%' . $row[56] . '%')->first();
                                    if (!empty($accesories_cat)) {
                                        $accesories_cat_id = $accesories_cat->id;
                                    } else {
                                        $accesories_cat_id = '';
                                    }
                                } else {
                                    $accesories_cat_id = '';
                                }

                                if (!empty($main_category)) {
                                    if (!empty($c1_category)) {
                                        $product = Product::create([
                                            'name' => $row[0] ?? '',
                                            'slug' => $slug,
                                            'brand_id' => $brand->id ?? '',
                                            'main_cat_id' => $main_category->id ?? '',
                                            'c1_cat_id' => $c1_category->id ?? '',
                                            'c2_cat_id' => $c2_category->id ?? '',
                                            'leaf_cat_id' => $leaf_category->id ?? '',
                                            'artical_no' => $row[6] ?? '',
                                            'series_name' => $row[7] ?? '',
                                            'model_no' => $row[8] ?? '',
                                            'mrp' => $row[9] ?? '',
                                            'selling_price' => $row[10] ?? '',
                                            'unit_of_measurment' => $row[11] ?? '',
                                            'selling_unit' => $row[12] ?? '',
                                            'magnitude_of_uom' => $row[13] ?? '',
                                            'description' => $cleanDescription ?? '',
                                            'image' => $row[42] ?? '',
                                            'sku_code' => $sku_code ?? '',
                                            'hsn' => $row[44] ?? '',
                                            'tax' => $row[45] ?? '',
                                            'catalogue' => $row[46] ?? '',
                                            'is_return_available' => $row[47] ?? '',
                                            'return_day' => $row[48] ?? '',
                                            'faq' => $row[49] ?? '',
                                            'width' => $row[50] ?? '',
                                            'height' => $row[51] ?? '',
                                            'depth' => $row[52] ?? '',
                                            'weight' => $row[53] ?? '',
                                            'min_quantity' => $row[54] ?? '',
                                            'ship_time' => $row[55] ?? '',
                                            'accesoriess_cat_id' => $accesories_cat_id ?? '',
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'updated_at' => date('Y-m-d H:i:s'),

                                        ]);
                                        $product_id = $product->id;
                                        ProductImage::create([
                                            'product_id' => $product_id,
                                            'image_1' => $row[15] ?? '',
                                            'image_2' => $row[16] ?? '',
                                            'image_3' => $row[17] ?? '',
                                            'image_4' => $row[18] ?? '',
                                            'image_5' => $row[19] ?? '',
                                        ]);

                                        ProductAttribute::create([
                                            'product_id' => $product_id,
                                            'attribute1a' => $row[20] ?? '',
                                            'attribute1b' => $row[21] ?? '',
                                            'attribute2a' => $row[22] ?? '',
                                            'attribute2b' => $row[23] ?? '',
                                            'attribute3a' => $row[24] ?? '',
                                            'attribute3b' => $row[25] ?? '',
                                            'attribute4a' => $row[26] ?? '',
                                            'attribute4b' => $row[27] ?? '',
                                            'attribute5a' => $row[28] ?? '',
                                            'attribute5b' => $row[29] ?? '',
                                            'attribute6a' => $row[30] ?? '',
                                            'attribute6b' => $row[31] ?? '',
                                            'attribute7a' => $row[32] ?? '',
                                            'attribute7b' => $row[33] ?? '',
                                            'attribute8a' => $row[34] ?? '',
                                            'attribute8b' => $row[35] ?? '',
                                            'attribute9a' => $row[36] ?? '',
                                            'attribute9b' => $row[37] ?? '',
                                            'attribute10a' => $row[38] ?? '',
                                            'attribute10b' => $row[39] ?? '',
                                            'attribute11a' => $row[40] ?? '',
                                            'attribute11b' => $row[41] ?? '',
                                        ]);
                                    } else {
                                        return redirect()->back()->with('error', 'Please Check C1 category!');
                                    }
                                } else {
                                    return redirect()->back()->with('error', 'Please Check main category!');
                                }
                            }
                        } else {
                            $check_data = Product::where('id', $row[0])->first();

                            $main_category = Category::where(['cat_id' => '0', 'type' => '0'])->where('name', 'like', $row[3])->first('id');
                            $c1_category = Category::where('type', '1')->where('name', 'like', trim($row[4]))->first('id');
                            if (!empty($row[5])) {
                                $c2_category = Category::where(['type' => '2'])->where('name', 'like', trim($row[5]))->first('id');
                            } else {
                                $c2_category = [];
                            }
                            if (!empty($row[6])) {
                                $leaf_category = Category::where(['type' => '3'])->where('name', 'like', trim($row[6]))->first('id');
                            } else {
                                $leaf_category = [];
                            }
                            $brand = Brand::where('name', 'like', trim($row[2]))->first('id');
                            $accesories_cat_name = Category::where('name', 'like', $row[57])->first('id');

                            $slug = $this->createSlug($row[1]);

                            if (!empty($main_category)) {
                                $product = Product::where('id', $check_data->id)->update(
                                    [
                                        'name' => $row[1] ?? '--',
                                        'slug' => $slug,
                                        'brand_id' => $brand->id ?? '--',
                                        'main_cat_id' => $main_category->id ?? '--',
                                        'c1_cat_id' => $c1_category->id ?? '--',
                                        'c2_cat_id' => $c2_category->id ?? '--',
                                        'leaf_cat_id' => $leaf_category->id ?? '--',
                                        'artical_no' => $row[7] ?? '--',
                                        'series_name' => $row[8] ?? '--',
                                        'model_no' => $row[9] ?? '--',
                                        'mrp' => $row[10] ?? '',
                                        'selling_price' => $row[11] ?? '',
                                        'unit_of_measurment' => $row[12] ?? '--',
                                        'selling_unit' => $row[13] ?? '--',
                                        'magnitude_of_uom' => $row[14] ?? '--',
                                        'description' => $row[15] ?? '--',
                                        'image' => $row[43] ?? '--',
                                        'sku_code' => $row[44] ?? '--',
                                        'hsn' => $row[45] ?? '--',
                                        'tax' => $row[46] ?? '--',
                                        'catalogue' => $row[47] ?? '--',
                                        'is_return_available' => $row[48] ?? '--',
                                        'return_day' => $row[49] ?? '--',
                                        'faq' => $row[50] ?? '--',
                                        'width' => $row[51] ?? '--',
                                        'height' => $row[52] ?? '--',
                                        'depth' => $row[53] ?? '--',
                                        'weight' => $row[54] ?? '--',
                                        'min_quantity' => $row[55] ?? '--',
                                        'ship_time' => $row[56],
                                        'accesoriess_cat_id' => !empty($accesories_cat_name) ? $accesories_cat_name->id : '-',
                                    ]
                                );
                                $product_id = $check_data->id;
                                ProductImage::where('product_id', $product_id)->update([
                                    'product_id' => $product_id,
                                    'image_1' => $row[16] ?? '--',
                                    'image_2' => $row[17] ?? '--',
                                    'image_3' => $row[18] ?? '--',
                                    'image_4' => $row[19] ?? '--',
                                    'image_5' => $row[20] ?? '--',
                                ]);

                                ProductAttribute::where('product_id', $product_id)->update([
                                    'product_id' => $product_id,
                                    'attribute1a' => $row[21] ?? '--',
                                    'attribute1b' => $row[22] ?? '--',
                                    'attribute2a' => $row[23] ?? '--',
                                    'attribute2b' => $row[24] ?? '--',
                                    'attribute3a' => $row[25] ?? '--',
                                    'attribute3b' => $row[26] ?? '--',
                                    'attribute4a' => $row[27] ?? '--',
                                    'attribute4b' => $row[28] ?? '--',
                                    'attribute5a' => $row[29] ?? '--',
                                    'attribute5b' => $row[30] ?? '--',
                                    'attribute6a' => $row[31] ?? '--',
                                    'attribute6b' => $row[32] ?? '--',
                                    'attribute7a' => $row[33] ?? '--',
                                    'attribute7b' => $row[34] ?? '--',
                                    'attribute8a' => $row[35] ?? '--',
                                    'attribute8b' => $row[36] ?? '--',
                                    'attribute9a' => $row[37] ?? '--',
                                    'attribute9b' => $row[38] ?? '--',
                                    'attribute10a' => $row[39] ?? '--',
                                    'attribute10b' => $row[40] ?? '--',
                                    'attribute11a' => $row[41] ?? '--',
                                    'attribute11b' => $row[42] ?? '--',
                                ]);
                            }
                        }
                    }

                    $filename =  $this->fileupload($request->csv_file, 'Upload_csv', 'csv_upload');
                    return redirect()->back()->with('success', 'CSV imported successfully');
                } else {
                    return redirect()->back()->with('error', 'Please select a CSV file to import');
                }
            } else {
                return redirect()->back()->with('error', 'Please select a CSV file to import');
            }
        } catch (\Illuminate\Database\QueryException $exception) {

            return back()->with('error', $exception->getMessage());
        }
    }

    public function testing_import_product(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();

                $extension = $request->file('csv_file')->getClientOriginalExtension();

                if ($extension == 'csv' || $extension == 'xlsx') {
                    $data = array_map('str_getcsv', file($path));
                    $header = array_shift($data);
                    foreach ($data as $key => $row) {
                        $check_data = Product::where('id', $row[0])->first();

                        if (empty($check_data)) {
                            if (!empty($row[0])) {
                                $product_subName = substr($row[0], 0, 13);
                                $trim_name = trim($product_subName);
                                $actual_subName = rtrim(str_replace([' ', ',', '-'], '-', $trim_name), '-');
                                $sku_code = rand(1111111111, 9999999999) . '-' . $actual_subName;
                            } else {
                                $sku_code = (string)rand(1111111111, 9999999999);
                            }

                            if (isset($row[2])) {
                                $main_category = Category::where(['cat_id' => '0', 'type' => '0'])->where('name', 'like', '%' . $row[2] . '%')->first('id');
                                $c1_category = Category::where('type', '1')->where('name', 'like', '%' . trim($row[3]) . '%')->first('id');
                                if (isset($row[4])) {
                                    $c2_category = Category::where(['type' => '2'])->where('name', 'like', '%' . trim($row[4]) . '%')->first('id');
                                } else {
                                    $c2_category = '';
                                }
                                if (isset($row[5])) {
                                    $leaf_category = Category::where(['type' => '3'])->where('name', 'like', '%' . trim($row[5]) . '%')->first('id');
                                } else {
                                    $leaf_category = '';
                                }
                                $brand = Brand::where('name', 'like', '%' . trim($row[1]) . '%')->first('id');
                                $slug = $this->createSlug($row[0]);

                                if (!empty($row[14])) {
                                    $cleanDescription = mb_convert_encoding($row[14], 'UTF-8', 'UTF-8');
                                }
                                $html = '';
                                $html = nl2br($row[14]);
                                $data = str_replace("\n", "<br>", $html);
                                dd($data);
                                // $product = Product::create([
                                //     'name' => $row[0] ?? '--',
                                //     'slug' => $slug,
                                //     'brand_id' => $brand->id ?? '--',
                                //     'main_cat_id' => $main_category->id ?? '--',
                                //     'c1_cat_id' => $c1_category->id ?? '--',
                                //     'c2_cat_id' => $c2_category->id ?? '--',
                                //     'leaf_cat_id' => $leaf_category->id ?? '--',
                                //     'artical_no' => $row[6] ?? '--',
                                //     'series_name' => $row[7] ?? '--',
                                //     'model_no' => $row[8] ?? '--',
                                //     'mrp' => $row[9] ?? '--',
                                //     'selling_price' => $row[10] ?? '--',
                                //     'unit_of_measurment' => $row[11] ?? '--',
                                //     'selling_unit' => $row[12] ?? '--',
                                //     'magnitude_of_uom' => $row[13] ?? '--',
                                //     'description' => $cleanDescription ?? '--',
                                //     'image' => $row[42] ?? '--',
                                //     'sku_code' => $sku_code ?? '--',
                                //     'hsn' => $row[44] ?? '--',
                                //     'tax' => $row[45] ?? '--',
                                //     'catalogue' => $row[46] ?? '--',
                                //     'is_return_available' => $row[47] ?? '--',
                                //     'return_day' => $row[48] ?? '--',
                                //     'faq' => $row[49] ?? '--',
                                //     'width' => $row[50] ?? '--',
                                //     'height' => $row[51] ?? '--',
                                //     'depth' => $row[52] ?? '--',
                                //     'weight' => $row[53] ?? '--',
                                //     'min_quantity' => $row[54] ?? '--',
                                //     'ship_time' => $row[55] ?? '--',
                                //     'created_at' => date('Y-m-d H:i:s'),
                                //     'updated_at' => date('Y-m-d H:i:s'),

                                // ]);
                                // $product_id = $product->id;
                                // ProductImage::create([
                                //     'product_id' => $product_id,
                                //     'image_1' => $row[15] ?? '--',
                                //     'image_2' => $row[16] ?? '--',
                                //     'image_3' => $row[17] ?? '--',
                                //     'image_4' => $row[18] ?? '--',
                                //     'image_5' => $row[19] ?? '--',
                                // ]);

                                // ProductAttribute::create([
                                //     'product_id' => $product_id,
                                //     'attribute1a' => $row[20] ?? '--',
                                //     'attribute1b' => $row[21] ?? '--',
                                //     'attribute2a' => $row[22] ?? '--',
                                //     'attribute2b' => $row[23] ?? '--',
                                //     'attribute3a' => $row[24] ?? '--',
                                //     'attribute3b' => $row[25] ?? '--',
                                //     'attribute4a' => $row[26] ?? '--',
                                //     'attribute4b' => $row[27] ?? '--',
                                //     'attribute5a' => $row[28] ?? '--',
                                //     'attribute5b' => $row[29] ?? '--',
                                //     'attribute6a' => $row[30] ?? '--',
                                //     'attribute6b' => $row[31] ?? '--',
                                //     'attribute7a' => $row[32] ?? '--',
                                //     'attribute7b' => $row[33] ?? '--',
                                //     'attribute8a' => $row[34] ?? '--',
                                //     'attribute8b' => $row[35] ?? '--',
                                //     'attribute9a' => $row[36] ?? '--',
                                //     'attribute9b' => $row[37] ?? '--',
                                //     'attribute10a' => $row[38] ?? '--',
                                //     'attribute10b' => $row[39] ?? '--',
                                //     'attribute11a' => $row[40] ?? '--',
                                //     'attribute11b' => $row[41] ?? '--',
                                // ]);
                            }
                        } else {
                            $main_category = Category::where(['cat_id' => '0', 'type' => '0'])->where('name', 'like', '%' . $row[3] . '%')->first('id');
                            $c1_category = Category::where('type', '1')->where('name', 'like', '%' . trim($row[4]) . '%')->first('id');
                            if (!empty($row[5])) {
                                $c2_category = Category::where(['type' => '2'])->where('name', 'like', '%' . trim($row[5]) . '%')->first('id');
                            } else {
                                $c2_category = [];
                            }
                            if (!empty($row[6])) {
                                $leaf_category = Category::where(['type' => '3'])->where('name', 'like', '%' . trim($row[6]) . '%')->first('id');
                            } else {
                                $leaf_category = [];
                            }
                            $brand = Brand::where('name', 'like', '%' . trim($row[2]) . '%')->first('id');
                            $accesories_cat_name = Category::where('name', 'like', $row[57] . '%')->first('id');

                            $slug = $this->createSlug($row[1]);
                            $product = Product::where('id', $check_data->id)->update(
                                [
                                    'name' => $row[1] ?? '--',
                                    'slug' => $slug,
                                    'brand_id' => $brand->id ?? '--',
                                    'main_cat_id' => $main_category->id ?? '--',
                                    'c1_cat_id' => $c1_category->id ?? '--',
                                    'c2_cat_id' => $c2_category->id ?? '--',
                                    'leaf_cat_id' => $leaf_category->id ?? '--',
                                    'artical_no' => $row[7] ?? '--',
                                    'series_name' => $row[8] ?? '--',
                                    'model_no' => $row[9] ?? '--',
                                    'mrp' => $row[10] ?? '',
                                    'selling_price' => $row[11] ?? '',
                                    'unit_of_measurment' => $row[12] ?? '--',
                                    'selling_unit' => $row[13] ?? '--',
                                    'magnitude_of_uom' => $row[14] ?? '--',
                                    'description' => $row[15] ?? '--',
                                    'image' => $row[43] ?? '--',
                                    'sku_code' => $row[44] ?? '--',
                                    'hsn' => $row[45] ?? '--',
                                    'tax' => $row[46] ?? '--',
                                    'catalogue' => $row[47] ?? '--',
                                    'is_return_available' => $row[48] ?? '--',
                                    'return_day' => $row[49] ?? '--',
                                    'faq' => $row[50] ?? '--',
                                    'width' => $row[51] ?? '--',
                                    'height' => $row[52] ?? '--',
                                    'depth' => $row[53] ?? '--',
                                    'weight' => $row[54] ?? '--',
                                    'min_quantity' => $row[55] ?? '--',
                                    'ship_time' => $row[56],
                                    'accesoriess_cat_id' => !empty($accesories_cat_name) ? $accesories_cat_name->id : '-',
                                ]
                            );
                            $product_id = $check_data->id;
                            ProductImage::where('product_id', $product_id)->update([
                                'product_id' => $product_id,
                                'image_1' => $row[16] ?? '--',
                                'image_2' => $row[17] ?? '--',
                                'image_3' => $row[18] ?? '--',
                                'image_4' => $row[19] ?? '--',
                                'image_5' => $row[20] ?? '--',
                            ]);

                            ProductAttribute::where('product_id', $product_id)->update([
                                'product_id' => $product_id,
                                'attribute1a' => $row[21] ?? '--',
                                'attribute1b' => $row[22] ?? '--',
                                'attribute2a' => $row[23] ?? '--',
                                'attribute2b' => $row[24] ?? '--',
                                'attribute3a' => $row[25] ?? '--',
                                'attribute3b' => $row[26] ?? '--',
                                'attribute4a' => $row[27] ?? '--',
                                'attribute4b' => $row[28] ?? '--',
                                'attribute5a' => $row[29] ?? '--',
                                'attribute5b' => $row[30] ?? '--',
                                'attribute6a' => $row[31] ?? '--',
                                'attribute6b' => $row[32] ?? '--',
                                'attribute7a' => $row[33] ?? '--',
                                'attribute7b' => $row[34] ?? '--',
                                'attribute8a' => $row[35] ?? '--',
                                'attribute8b' => $row[36] ?? '--',
                                'attribute9a' => $row[37] ?? '--',
                                'attribute9b' => $row[38] ?? '--',
                                'attribute10a' => $row[39] ?? '--',
                                'attribute10b' => $row[40] ?? '--',
                                'attribute11a' => $row[41] ?? '--',
                                'attribute11b' => $row[42] ?? '--',
                            ]);
                        }
                    }

                    $filename =  $this->fileupload($request->csv_file, 'Upload_csv', 'csv_upload');
                    return redirect()->back()->with('success', 'CSV imported successfully');
                } else {
                    return redirect()->back()->with('error', 'Please select a CSV file to import');
                }
            } else {
                return redirect()->back()->with('error', 'Please select a CSV file to import');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
    public function export_pro_data(Request $request)
    {
        $product = Product::where('brand_id', $request->brand_id)->get();
        $brand = Brand::where('id', $request->brand_id)->first();
        foreach ($product as $key => $item) {
            $main_category = Category::where('id', $item->main_cat_id)->first('name');
            $c1_category = Category::where('id', $item->c1_cat_id)->first('name');
            $c2_category = Category::where('id', $item->c2_cat_id)->first('name');
            $leaf_category = Category::where('id', $item->leaf_cat_id)->first('name');
            $brand = Brand::where('id', $item->brand_id)->first('name');

            if (!empty($item->accesoriess_cat_id)) {
                $accesories_cat_name = Category::where('id', $item->accesoriess_cat_id)->first('name');
            } else {
                $accesories_cat_name = '';
            }

            $item->main_category = $main_category->name ?? '';
            $item->c1_category = $c1_category->name ?? '';
            $item->c2_category = $c2_category->name ?? '';
            $item->leaf_category = $leaf_category->name ?? '';
            $item->brand = $brand->name ?? '';

            $item->all_image = ProductImage::where('product_id', $item->id)->first(['image_1', 'image_2', 'image_3', 'image_4', 'image_5']);
            $item->attribute = ProductAttribute::where('product_id', $item->id)->first();
        }

        $row = [
            'id',
            'name',
            'brand',
            'main_category',
            'c1_category',
            'c2_category',
            'leaf_category',
            'artical_no',
            'series_name',
            'model_no',
            'mrp',
            'seling_price',
            'unit_of_measurement',
            'selling_unit',
            'magnitude_of_uom',
            'description',
            'image_1',
            'image_2',
            'image_3',
            'image_4',
            'image_5',
            'attribute1a',
            'attribute1b',
            'attribute2a',
            'attribute2b',
            'attribute3a',
            'attribute3b',
            'attribute4a',
            'attribute4b',
            'attribute5a',
            'attribute5b',
            'attribute6a',
            'attribute6b',
            'attribute7a',
            'attribute7b',
            'attribute8a',
            'attribute8b',
            'attribute9a',
            'attribute9b',
            'attribute10a',
            'attribute10b',
            'attribute11a',
            'attribute11b',
            'image',
            'sku_code',
            'hsn',
            'tax',
            'catalogue_url',
            'is_return_available',
            'return_day',
            'faq',
            'width',
            'height',
            'depth',
            'weight',
            'min_quantity',
            'ship_time',
            'accesoriess_cat_name',
        ];

        $dataRows  = [];

        foreach ($product as $key => $pro_item) {
            $description = $pro_item->description;
            $dataRows[] = [
                $pro_item->id,
                '"' . $pro_item->name . '"',
                $pro_item->brand,
                !empty($pro_item->main_category) ? '"' . $pro_item->main_category . '"' : '',
                !empty($pro_item->c1_category) ? '"' . $pro_item->c1_category . '"' : '',
                !empty($pro_item->c2_category) ? '"' . $pro_item->c2_category . '"' : '',
                !empty($pro_item->leaf_category) ? '"' . $pro_item->leaf_category . '"' : '',
                !empty($pro_item->artical_no) ? '"' . $pro_item->artical_no . '"' : '',
                !empty($pro_item->series_name) ? '"' . $pro_item->series_name . '"' : '',
                !empty($pro_item->model_no) ? '"' . $pro_item->model_no . '"' : '',
                (!empty($pro_item->mrp) || ($pro_item->mrp != '')) ? '"' . $pro_item->mrp . '"' : '',
                !empty($pro_item->selling_price) ? '"' . $pro_item->selling_price . '"' : '',
                !empty($pro_item->unit_of_measurment) ? '"' . $pro_item->unit_of_measurment . '"' : '',
                !empty($pro_item->selling_unit) ? '"' . $pro_item->selling_unit . '"' : '',
                !empty($pro_item->magnitude_of_uom) ? '"' . $pro_item->magnitude_of_uom . '"' : '',
                '"' . $description . '"',
                !empty($pro_item->all_image->image_1) ? $pro_item->all_image->image_1 : '',
                !empty($pro_item->all_image->image_2) ? $pro_item->all_image->image_2 : '',
                !empty($pro_item->all_image->image_3) ? $pro_item->all_image->image_3 : '',
                !empty($pro_item->all_image->image_4) ? $pro_item->all_image->image_4 : '',
                !empty($pro_item->all_image->image_5) ? $pro_item->all_image->image_5 : '',
                !empty($pro_item->attribute->attribute1a) ? $pro_item->attribute->attribute1a : '',
                !empty($pro_item->attribute->attribute1b) ? $pro_item->attribute->attribute1b : '',
                !empty($pro_item->attribute->attribute2a) ? $pro_item->attribute->attribute2a : '',
                !empty($pro_item->attribute->attribute2b) ? $pro_item->attribute->attribute2b : '',
                !empty($pro_item->attribute->attribute3a) ? $pro_item->attribute->attribute3a : '',
                !empty($pro_item->attribute->attribute3b) ? $pro_item->attribute->attribute3b : '',
                !empty($pro_item->attribute->attribute4a) ? $pro_item->attribute->attribute4a : '',
                !empty($pro_item->attribute->attribute4b) ? $pro_item->attribute->attribute4b : '',
                !empty($pro_item->attribute->attribute5a) ? $pro_item->attribute->attribute5a : '',
                !empty($pro_item->attribute->attribute5b) ? $pro_item->attribute->attribute5b : '',
                !empty($pro_item->attribute->attribute6a) ? $pro_item->attribute->attribute6a : '',
                !empty($pro_item->attribute->attribute6b) ? $pro_item->attribute->attribute6b : '',
                !empty($pro_item->attribute->attribute7a) ? $pro_item->attribute->attribute7a : '',
                !empty($pro_item->attribute->attribute7b) ? $pro_item->attribute->attribute7b : '',
                !empty($pro_item->attribute->attribute8a) ? $pro_item->attribute->attribute8a : '',
                !empty($pro_item->attribute->attribute8b) ? $pro_item->attribute->attribute8b : '',
                !empty($pro_item->attribute->attribute9a) ? $pro_item->attribute->attribute9a : '',
                !empty($pro_item->attribute->attribute9b) ? $pro_item->attribute->attribute9b : '',
                !empty($pro_item->attribute->attribute10a) ? $pro_item->attribute->attribute10a : '',
                !empty($pro_item->attribute->attribute10b) ? $pro_item->attribute->attribute10b : '',
                !empty($pro_item->attribute->attribute11a) ? $pro_item->attribute->attribute11a : '',
                !empty($pro_item->attribute->attribute11b) ? $pro_item->attribute->attribute11b : '',
                !empty($pro_item->image) ? $pro_item->image :  '',
                !empty($pro_item->sku_code) ? $pro_item->sku_code : '',
                !empty($pro_item->hsn) ? $pro_item->hsn : '',
                !empty($pro_item->tax) ? $pro_item->tax : '',
                !empty($pro_item->catalogue) ? $pro_item->catalogue : '',
                !empty($pro_item->is_return_available) ? $pro_item->is_return_available : '',
                !empty($pro_item->return_day) ? $pro_item->return_day : '',
                !empty($pro_item->faq) ? $pro_item->faq : '',
                !empty($pro_item->width) ? $pro_item->width : '',
                !empty($pro_item->height) ? $pro_item->height : '',
                !empty($pro_item->depth) ? $pro_item->depth : '',
                !empty($pro_item->weight) ? $pro_item->weight : '',
                !empty($pro_item->min_quantity) ? $pro_item->min_quantity : '',
                !empty($pro_item->ship_time) ? $pro_item->ship_time : '',
                !empty($accesories_cat_name) ? $accesories_cat_name : '',
            ];
        }
        $dataToExport = array_merge([$row], $dataRows);
        return $this->exportCSV($dataToExport, $brand->name . '-product', '', '');
    }

    public function product_edit($id)
    {
        $data = [];
        $edit_data = Product::where('id', $id)->first();
        $brand_list = Brand::where('status', '1')->get(['id', 'name']);
        $data['edit_data'] = $edit_data;
        $data['brand_list'] = $brand_list;
        return view('Admin.Product.edit', compact('data'));
    }

    public function product_update(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'brand_name' => 'required',
            // 'mrp' => 'required',
            // 'selling_price' => 'required',
            'min_quantity' => 'required',

        ]);

        if ($request->has('image') && ($request->image != '')) {
            $filename = $this->fileupload($request->image, 'Product');
            $add = Product::where('id', $request->id)->update([
                'image' => $filename,
            ]);
        }
        $slug = $this->strToslug($request->name);
        $add = Product::where('id', $request->id)->update([
            'name' => $request->name ?? '',
            'slug' => $slug,
            'brand_id' => $request->brand_name ?? '',
            'series_name' => $request->series_no ?? '',
            'model_no' => $request->model_no ?? '',
            'artical_no' => $request->artical_no ?? '',
            'mrp' => $request->mrp ?? '',
            'selling_price' => $request->selling_price ?? '',
            'tax' => $request->tax ?? '',
            'min_quantity' => $request->min_quantity ?? '',
            'ship_time' => $request->ship_time ?? '',
            'description' => $request->description ?? '',

        ]);
        return redirect()->route('product_list')->with('success', 'Data Updated Successfully!');
    }
    public function product_varientList($id)
    {
        $data = [];
        $product_var = ProductVarient::where('product_id', $id)->paginate(10);

        $data['product_var'] = $product_var;
        $data['id'] = $id;
        return view('Admin.Product.varient_list', compact('data'));
    }

    public function saveProductVarient(Request $request)
    {
        if ($request->has('varient_id')) {
            $add = ProductVarient::where('id', $request->varient_id)->update([
                'product_id' => $request->product_id,
                'qty_range' => $request->qty_range,
                'price_per_pc' => $request->price_per_pc,
            ]);
        } else {
            $add = ProductVarient::create([
                'product_id' => $request->product_id,
                'qty_range' => $request->qty_range,
                'price_per_pc' => $request->price_per_pc,
            ]);
        }

        return redirect()->route('product_varientList', ['id' => $request->product_id])->with('success', 'Data Added Successfully!');
    }

    public function editProductVarient(Request $request)
    {
        $data = [];
        $var_data = ProductVarient::where('id', $request->var_id)->first();
        $data['var_data']  = $var_data;
        return response()->json([
            'status' => true,
            'success' => 'Data Send Successfully!',
            'data' => $data['var_data'],
        ], 200);
    }
    //================= Product releted function =============//

    //=================== Home Slider function ==================//
    public function home_slider_list(Request $request)
    {
        $data['slider'] = HomeSlider::paginate(10);
        foreach ($data['slider'] as $key => $item) {
            if (!empty($item->image)) {
                $item->image = env('ADMIN_IMG') . '/home_slider/' . $item->image;
            }
            $prodct = Product::where('id', $item->product_id)->first('name');
            $item->product_name  = $prodct->name;
        }

        return view('Admin.home_slider.index', compact('data'));
    }

    public function home_slider_create(Request $request)
    {
        $data = [];
        return view('Admin.home_slider.create', compact('data'));
    }

    public function home_slider_save(Request $request)
    {
        if ($request->has('id')) {
            $validatedata = $request->validate([
                'product_name' => 'required',
                'slider_type' => 'required',
            ]);

            if ($request->has('image')) {
                $filename = $this->fileupload($request->image, 'home_slider');
                $update = HomeSlider::where('id', $request->id)->update([
                    'image' => $filename,
                ]);
            }

            $product = Product::where('name', 'like', '%' . $request->product_name . '%')->first('id');

            $update = HomeSlider::where('id', $request->id)->update([
                'name' => $request->name ?? '',
                'type' => $request->slider_type,
                'product_id' => $product->id,

            ]);
            if (!empty($update)) {
                return redirect()->route('home_slider_list')->with('success', 'Data Updated Succesfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } else {
            $validatedata = $request->validate([
                'product_name' => 'required',
                'slider_type' => 'required',
            ]);

            if ($request->has('image') && !empty($request->image)) {
                $filename = $this->fileupload($request->image, 'home_slider');
            } else {
                $filename = '';
            }

            $product = Product::where('name', 'like', '%' . $request->product_name . '%')->first('id');


            $create = HomeSlider::create([
                'name' => $request->name ?? '',
                'type' => $request->slider_type,
                'image' => $filename,
                'product_id' => $product->id,
            ]);
            if (!empty($create)) {
                return redirect()->route('home_slider_list')->with('success', 'Data Added Succesfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }

    public function home_slider_edit(Request $request, $id)
    {
        $data['slider_data'] = HomeSlider::where('id', $id)->first();
        $product = Product::where('id', $data['slider_data']->product_id)->first(['name', 'id']);
        $data['slider_data']->product = $product;
        return view('Admin.home_slider.edit', compact('data'));
    }

    public function get_product_list(Request $request)
    {
        $product = Product::where('artical_no', $request->search_key)->get(['id', 'name']);
        if (!empty($product)) {
            return response()->json([
                'status' => true,
                'message' => 'Data Send Successfully!',
                'data' => $product,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Data Send Successfully!',
                'data' => [],
            ]);
        }
    }
    //=================== Home Slider function ==================//




    public function updatesubCategory(Request $request)
    {
        $update_cat = Category::where('id', $request->cat_id)->update([
            'name' => $request->cat_name,
            'description' => $request->description,
        ]);

        if ($update_cat == '1') {
            return redirect()->route('category')->with('message', 'Category Updated Successfully!');
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function deleteCategory(Request $request)
    {
        $del_cat = Category::where('id', $request->id)->first();
        $del_sub_cat = SubCategory::where('category_id', $request->id)->first();
        if (!empty($del_sub_cat)) {
            $del_sub_cat->delete();
        }

        if (!empty($del_cat)) {
            $del_cat->delete();
            return response()->json(['message' => 'Category Deleted Successfully!']);
        } else {
            return response()->json(['message' => 'Something went wrong!']);
        }
    }

    public function subCategoryList()
    {
        $data = [];
        $subcategory = Category::where('cat_id', '!=', '0')->get();
        $sub_cat = $subcategory->map(function ($item) {
            $item->category = Category::where('id', $item->cat_id)->first('name');
            return $item;
        });
        $data['subcategory'] = $subcategory;
        return view('Admin.SubCategory.index', compact('data'));
    }

    public function addSubCategory($type, $id)
    {
        $data = [];
        if ($type == 'add') {
            $category = Category::where('cat_id', '==', '0')->get();
            $data['category'] = $category;
            return view('Admin.SubCategory.create', compact('data'));
        }
        if ($type == 'edit') {
            $edit_data = Category::where('id', $id)->first();
            $category = Category::where('cat_id', '==', '0')->get();

            $data['category'] = $category;
            $data['cat_id'] = $id;
            $data['edit_data'] = $edit_data;
            return view('Admin.SubCategory.edit', compact('data'));
        }
    }

    public function saveSubCategory(Request $request)
    {
        if ($request->has('id')) {
            $validatedata = $request->validate([
                'name' => 'required',
            ]);


            if ($request->has('image')) {
                $filename = $this->fileupload($request->image, 'Category');
                $add_subcat = Category::where('id', $request->id)->update([
                    'image' => $filename,
                ]);
            }
            if ($request->has('banner_img')) {
                $filename = $this->fileupload($request->banner_img, 'Category');
                $add_subcat = Category::where('id', $request->id)->update([
                    'banner_img' => $filename,
                ]);
            }
            $add_subcat = Category::where('id', $request->id)->update([
                'cat_id' => $request->cat_id,
                'name' => $request->name,
                'description' => $request->description ?? '',
            ]);

            if (!empty($add_subcat)) {
                return redirect()->route('subCategoryList')->with('success', 'Sub Category Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Someting went wrong!');
            }
        } else {
            $validatedata = $request->validate([
                'name' => 'required',
                'image' => 'required',
                'banner_img' => 'required',
            ]);


            if ($request->has('image')) {
                $image = $this->fileupload($request->image, 'Category');
            }
            if ($request->has('banner_img')) {
                $banner_img = $this->fileupload($request->banner_img, 'Category');
            }
            $add_subcat = Category::create([
                'cat_id' => $request->cat_id,
                'name' => $request->name,
                'image' => $image,
                'banner_img' => $banner_img,
                'description' => $request->discription ?? '',
            ]);

            if (!empty($add_subcat)) {
                return redirect()->route('subCategoryList')->with('success', 'Sub Category Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Someting went wrong!');
            }
        }
    }

    public function delSubCategory(Request $request)
    {
        $validator = $request->validate([
            'id' => 'required',
        ]);

        $delete_data = Category::where('id', $request->id)->first();
        $delete_data->delete();
        return redirect()->route('sub_category', $request->cat_id)->with('success', 'Sub Category deleted Succesfully!');
    }

    //============================= Order Section ============================//
    public function order_list(Request $request)
    {
        $data = [];
        if (Auth::guard('user')->user()->role == 'warehousemanager') {
            $order = Order::where('warehouse_id', '!=', '')->orderBy('id', 'DESC')->paginate(10);
        } else {
            $order = Order::where('order_status', '!=', '2')->orderBy('id', 'DESC')->paginate(10);
        }
        if (!empty($order)) {
            foreach ($order as $key => $item) {
                $user = Users::where('id', $item->user_id)->first();
                $user_add = UserAddress::where('id', $item->address_id)->first();

                $productdata = json_decode(str_replace("'", '"', $item->product_data), true);

                $totalQty = 0;
                foreach ($productdata as $item2) {
                    $totalQty += (int)$item2['qty']; // Convert to integer to ensure proper addition
                }
                $item->user = $user;
                $item->user_add = $user_add;
                $item->totalQty = $totalQty;
            }
            $data['order'] = $order;
        }
        return view('Admin.order.index', compact('data'));
    }

    public function order_view($id)
    {
        $data = [];
        $data['product'] = [];
        $order = Order::where('id', $id)->first();

        if (!empty($order)) {
            if ($order->invoice) {
                $order->invoice->file_name = asset('public/uploads/order_invoice') . '/' . $order->invoice->file_name;
            }


            $Products = json_decode(str_replace("'", '"', $order->product_data), true);
            foreach ($Products as $item) {
                $item['product_detail'] = Product::where('id', $item['id'])->first();
                $item['product_detail']->image = env('ADMIN_IMG') . '/Product/' . $item['product_detail']->image;
                $item['product_detail']->qty = $item['qty'];
                array_push($data['product'], $item['product_detail']);
            }
            $data['order'] = $order;
        }


        $user = Users::where('id', $order->user_id)->first();
        $user_add = UserAddress::where('user_id', $order->user_id)->first();
        // dd($user_add);
        $data['user'] = $user;
        $data['user_add'] = $user_add;
        return view('Admin.order.view', compact('data'));
    }

    public function order_status(Request $request)
    {
        $updte_data = Order::where('id', $request->id)->update([
            'order_status' => $request->status,
        ]);
        return response()->json(['status' => true, 'message' => 'Status Updated Successfully!'], 200);
    }

    public function cancel_order_list(Request $request)
    {
        $data = [];
        $order = Order::where('order_status', '2')->paginate(10);
        if (!empty($order)) {
            foreach ($order as $key => $item) {
                $user = Users::where('id', $item->user_id)->first();
                $productdata = json_decode(str_replace("'", '"', $item->product_data), true);

                $totalQty = 0;
                foreach ($productdata as $item2) {
                    $totalQty += (int)$item2['qty']; // Convert to integer to ensure proper addition


                    $product = Product::where('id', $item2['id'])->first(['name', 'image', 'sku_code', 'artical_no']);
                    if (!empty($product->image)) {
                        // dd($product->image);
                        $product->image = env('ADMIN_IMG') . '/Product/' . $product->image;
                    } else {
                        // $product->image = env('ADMIN_IMG') . '/Product/no_image.png';
                    }
                    $item->product = $product;
                }
                $item->user = $user;
                $item->totalQty = $totalQty;
            }
            $data['order'] = $order;
        }
        return view('Admin.order.cancel_order.index', compact('data'));
    }

    public function assign_warehouse(Request $request)
    {
        $assign = Order::where('id', $request->order_id)->update([
            'warehouse_id' => $request->warehouse_id,
        ]);
        return redirect()->back()->with('success', 'Warehouse Assigned!');
    }

    public function order_conf(Request $request, $id, $type)
    {
        $order = Order::where('id', $id)->update([
            'warehouse_accept' => $type,
        ]);
        return redirect()->back()->with('success', 'Order Status Updated Successfully!');
    }

    public function downloadImage($image)
    {
        $imagePath = $this->downloadImage($image);
    }

    public function orderInvoiceUpload(Request $request)
    {
        $validatedata = $request->validate([
            'invoice' => 'required',
        ]);

        $filename = $this->fileupload($request->invoice, 'order_invoice');

        $data = OrderInvoice::updateOrCreate(
            [
                'order_id' => $request->order_id,
            ],
            [
                'file_name' => $filename,
            ]
        );

        return redirect()->back()->with('success', 'Invoice Uploaded Successfully!');
    }
    // ================================Order Section-end============================


    //================================ Warehouse=============================//
    public function wareHouse_list()
    {
        $data = [];
        $warehouse = Warehouse::all();

        $data['warehouse']  = $warehouse;
        return view('Admin.warehouse.index', compact('data'));
    }

    public function wareHouse_create()
    {
        return view('Admin.warehouse.create');
    }

    public function wareHouse_add(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
        ]);

        $warehouse = Warehouse::create($request->all());

        if (!empty($warehouse)) {
            return redirect()->route('wareHouse_list')->with('success', 'Warehouse Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function wareHouse_edit($id)
    {
        $data = [];
        $warehoue_data = Warehouse::where('id', $id)->first();
        $data['warehoue_data'] = $warehoue_data;
        return view('Admin.warehouse.edit', compact('data'));
    }

    public function wareHouse_update(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
        ]);

        $update_data = Warehouse::where('id', $request->id)->update($request->only(['name', 'code', 'address', 'city', 'state', 'zipcode']));
        if (!empty($update_data)) {
            return redirect()->route('wareHouse_list')->with('success', 'Data Updated Sucessfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    //================================ Warehouse Manager=============================//



    //================================ Warehouse Manager=============================//
    public function wareHouManag_list()
    {
        $data = [];
        $warehouse_manager = Agent::where('role', 'warehousemanager')->get();

        $data['warehouse_manager']  = $warehouse_manager;
        return view('Admin.warehouse_manager.index', compact('data'));
    }

    public function wareHouManag_create()
    {
        $data = [];
        $warehouse = Warehouse::where('status', '1')->get();

        $data['warehouse'] = $warehouse;
        return view('Admin.warehouse_manager.create', compact('data'));
    }

    public function wareHouManag_add(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'password' => 'required| min:4|confirmed',
            'password_confirmation' => 'required| min:4',
        ]);


        $warehouse_manager = Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'empcode' => '',
            'role' => 'warehousemanager',
            'password' => Hash::make($request->password),
            'plain_password' => $request->password
        ]);

        if (!empty($warehouse_manager)) {
            return redirect()->route('wareHouManag_list')->with('success', 'Company Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function wareHouManag_edit($id)
    {
        $data = [];
        $warehouse = Warehouse::where('status', '1')->get();
        $warehoue_data = Agent::where('id', $id)->first();
        $data['warehoue_data'] = $warehoue_data;
        $data['warehouse'] = $warehouse;
        return view('Admin.warehouse_manager.edit', compact('data'));
    }

    public function wareHouManag_update(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'password' => 'required| min:4|confirmed',
            'password_confirmation' => 'required| min:4',
        ]);

        if ($request->has('password') && ($request->password != Null)) {
            $validatedata = $request->validate([
                'password' => 'required| min:4|confirmed',
                'password_confirmation' => 'required| min:4',
            ]);

            $update_data = Agent::where('id', $request->id)->update([
                'password' => Hash::make($request->password),
                'plain_password' => $request->password
            ]);
        }

        $update_data = Agent::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if (!empty($update_data)) {
            return redirect()->route('wareHouManag_list')->with('success', 'Data Updated Sucessfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    //================================ Warehouse Manager=============================//

    //================================ Data Manager=============================//
    public function dataManag_list()
    {
        $data = [];
        $data_manager = Agent::where('role', 'datamanager')->paginate(10);

        $data['data_manager']  = $data_manager;
        return view('Admin.data_manager.index', compact('data'));
    }

    public function dataManag_create()
    {
        $data = [];
        return view('Admin.data_manager.create');
    }

    public function dataManag_add(Request $request)
    {
        $validatedata = $request->validate([
            'name' => 'required',
            'empcode' => 'required',
            'email' => 'required',
            'password' => 'required| min:4|confirmed',
            'password_confirmation' => 'required| min:4',
            'phone' => 'required',
        ]);


        $data_manager = Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'empcode' => $request->empcode,
            'role' => 'datamanager',
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if (!empty($data_manager)) {
            return redirect()->route('dataManag_list')->with('success', 'Data Manager Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function dataManag_edit($id)
    {
        $data = [];
        $data_manager = Agent::where('id', $id)->first();
        $data['datamanager'] = $data_manager;
        return view('Admin.data_manager.edit', compact('data'));
    }

    //================================ Warehouse Manager=============================//

    //============================= Trusted Partner ===============================//
    public function trusted_prt_list()
    {
        $data['trusted_partner'] = TrustedPartner::paginate(10);
        foreach ($data['trusted_partner'] as $key => $item) {
            $item->image = env('ADMIN_IMG') . '/trusted_partner/' . $item->image;
        }
        return view('Admin.trusted_partner.index', compact('data'));
    }

    public function trusted_prt_save(Request $request)
    {

        if ($request->has('id')) {

            $validatedata = $request->validate([
                'name' => 'required',
            ]);

            if (!empty($request->image)) {
                $validatedata = $request->validate([
                    'image' => 'required',
                ]);
                $filename = $this->fileupload($request->image, 'trusted_partner');
                $add = TrustedPartner::where('id', $request->id)->update([
                    'image' => $filename,
                ]);
            }

            $add = TrustedPartner::where('id', $request->id)->update([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Data Updated Successfully!');
        } else {
            $validatedata = $request->validate([
                'name' => 'required',
                'image' => 'required',
            ]);

            $filename = $this->fileupload($request->image, 'trusted_partner');

            $add = TrustedPartner::create([
                'name' => $request->name,
                'image' => $filename,
            ]);

            return redirect()->back()->with('success', 'Data Added Successfully!');
        }
    }

    public function trusted_prt_edit(Request $request)
    {
        $data['edit_data'] = TrustedPartner::where('id', $request->id)->first();
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Data send successfully!'
        ]);
    }
    //============================= Trusted Partner ===============================//

    //-=========================== Stock Function ===================================//
    public function stockList(Request $request)
    {
        $data = [];

        if ($request->has('search')) {
            $product = Product::where('status', '1')->where('sku_code', 'LIKE', "$request->search%")->first();
            $stock = Stock::where('product_id', $product->id)->paginate(20);
        } else {
            $stock = Stock::paginate(20);
        }

        foreach ($stock as $key => $item) {
            $product = Product::where('id', $item->product_id)->first(['name', 'sku_code', 'model_no', 'artical_no']);
            $warehouse = Warehouse::where('id', $item->warehouse_id)->first(['name', 'code']);
            $item->product_name = $product->name ?? '--';
            $item->sku = $product->sku_code ?? '--';
            $item->model_no = $product->model_no ?? '--';
            $item->artical_no = $product->artical_no ?? '--';
            $item->warehouse_name = $warehouse->name ?? '--';
            $item->warehouse_code = $warehouse->code ?? '--';
        }

        $data['stock'] = $stock;
        return view('Admin.stock.index', compact('data'));
    }

    public function stockSample()
    {
        $data = [
            [
                'warehouse_code',
                'product_sku',
                'quantity',
            ]
        ];
        return $this->exportCSV($data, 'stock_sample_file', '', '');
    }

    public function stockImport(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();

            $extension = $request->file('csv_file')->getClientOriginalExtension();

            if ($extension == 'csv' || $extension == 'xlsx') {
                $data = array_map('str_getcsv', file($path));
                $header = array_shift($data);
                foreach ($data as $row) {
                    $product = Product::where('sku_code', $row[1])->first(['id']);
                    $warehouse = WareHouse::where('code', $row[0])->first(['id']);
                    if (!empty($product)) {
                        $add_update = Stock::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'warehouse_id' => $warehouse->id,
                            ],
                            [
                                'product_id' => $product->id ?? '',
                                'warehouse_id' => $warehouse->id,
                                'qty' => $row[2],
                            ]
                        );
                    }
                }

                $filename =  $this->fileupload($request->csv_file, 'Upload_csv', 'csv_upload');
                return redirect()->back()->with('success', 'CSV imported successfully');
            } else {
                return redirect()->back()->with('error', 'Please select a CSV file to import');
            }
        } else {
            return redirect()->back()->with('error', 'Please select a CSV file to import');
        }
    }
    //-=========================== Stock Function ===================================//

    //========================== Industry Funrtion =============================//
    public function industry_list(Request $request)
    {
        $data = [];

        $industry = Industry::paginate(10);
        foreach ($industry as $key => $item) {
            $item->image = asset('public/uploads/Industry/') . '/' . $item->image;
        }

        $data['industry'] = $industry;
        return view('Admin.industry.index', compact('data'));
    }

    public function industry_save(Request $request)
    {
        // dd($request->all());
        if ($request->has('industry_id')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($request->has('image') && ($request->image != null)) {
                $filename = $this->fileupload($request->image, 'Industry');
                $add = Industry::where('id', $request->industry_id)->update([
                    'image' => $filename,
                ]);
            }

            $add = Industry::where('id', $request->industry_id)->update([
                'name' => $request->name,
            ]);
            if (!empty($add)) {
                return redirect()->route('industry_list')->with('success', 'Data Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
            ]);

            $filename = $this->fileupload($request->image, 'Industry');

            $add = Industry::create([
                'name' => $request->name,
                'image' => $filename,
            ]);
            if (!empty($add)) {
                return redirect()->route('industry_list')->with('success', 'Data Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }

    public function industry_edit(Request $request)
    {
        $data = Industry::where('id', $request->id)->first(['name']);
        return response()->json([
            'status' => true,
            'success' => 'Data Send Successfully!',
            'data' => $data,
        ], 200);
    }
    //========================== Industry Funrtion =============================//

    //========================== Offer Funrtion =============================//
    public function offer_list(Request $request)
    {
        $data = [];

        $offer = Offer::paginate(10);
        foreach ($offer as $key => $item) {
            $item->image = asset('public/uploads/Offer/') . '/' . $item->image;
        }

        $data['offer'] = $offer;
        return view('Admin.Offer.index', compact('data'));
    }

    public function offer_save(Request $request)
    {
        if ($request->has('offer_id')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($request->has('image') && ($request->image != null)) {
                $filename = $this->fileupload($request->image, 'Offer');
                $add = Offer::where('id', $request->offer_id)->update([
                    'image' => $filename,
                ]);
            }

            $add = Offer::where('id', $request->offer_id)->update([
                'name' => $request->name,
            ]);
            if (!empty($add)) {
                return redirect()->route('offer_list')->with('success', 'Data Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
            ]);

            $filename = $this->fileupload($request->image, 'Offer');

            $add = Offer::create([
                'name' => $request->name,
                'image' => $filename,
            ]);
            if (!empty($add)) {
                return redirect()->route('offer_list')->with('success', 'Data Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }

    public function offer_edit(Request $request)
    {
        $data = Offer::where('id', $request->id)->first(['name']);
        return response()->json([
            'status' => true,
            'success' => 'Data Send Successfully!',
            'data' => $data,
        ], 200);
    }
    //========================== Offer Funrtion =============================//

    //========================== Career Funrtion =============================//
    public function career_list(Request $request)
    {
        $data = [];

        $career = Career::paginate(10);

        $data['career'] = $career;
        return view('Admin.Career.index', compact('data'));
    }

    public function career_create()
    {
        return view('Admin.Career.create');
    }

    public function career_save(Request $request)
    {
        if ($request->has('career_id')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'skill' => 'required',
                'location' => 'required',
                'description' => 'required',
            ]);

            $add = Career::where('id', $request->career_id)->update([
                'title' => $request->title,
                'skill' => $request->skill,
                'location' => $request->location,
                'description' => $request->description,
            ]);
            if (!empty($add)) {
                return redirect()->route('career_list')->with('success', 'Data Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'skill' => 'required',
                'location' => 'required',
                'description' => 'required',
            ]);

            $add = Career::create([
                'title' => $request->title,
                'skill' => $request->skill,
                'location' => $request->location,
                'description' => $request->description,
            ]);
            if (!empty($add)) {
                return redirect()->route('career_list')->with('success', 'Data Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
    }

    public function career_edit(Request $request, $id)
    {
        $data['career'] = Career::where('id', $id)->first();
        return view('Admin.Career.edit', compact('data'));
    }
    //========================== Career Function =============================//

    //==================== Contact Us section ================================//
    public function contact_us(Request $request)
    {
        $contact_us = ContactUs::paginate(10);
        foreach ($contact_us as $key => $value) {
            $user = Users::where('id', $value->user_id)->first('name');
            $value->user_data = $user;
        }

        $data['contact'] = $contact_us;
        return view('Admin.contact_us.index', compact('data'));
    }
    //==================== Contact Us Section ================================//

    //=================== Reward Section ========================//
    public function reward_list()
    {
        $data = [];
        $reward = [];
        $reward = Reward::orderBy('id', 'DESC')->paginate(10);
        $data['reward'] = $reward;
        return view('Admin.reward.index', compact('data'));
    }


    public function add_reward(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'amount_range' => 'required',
            'reward_point' => 'required',
        ]);

        $add = Reward::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'amount_range' => $request->amount_range,
                'reward_point' => $request->reward_point,
            ]
        );

        if (!empty($add)) {
            return redirect()->back()->with('success', 'Data Added Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function edit_reward(Request $request)
    {
        $reward_data = Reward::where('id', $request->id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Data Send Succesfully!',
            'data' => $reward_data,
        ], 200);
    }
    //=================== Reward Section ========================//





    //========================= Upload Image function =======================//
    public function upload_image_list(Request $request)
    {
        $data = [];
        $images = Files::orderBy('id', 'DESC')->paginate(10);
        foreach ($images as $key => $item) {
            $item->image_name = $item->doc_path;
            $item->doc_path = asset('public/uploads/Product/') . '/' . $item->doc_path;
        }
        $data['image'] = $images;
        return view('Admin.Upload_image.index', compact('data'));
    }

    public function upload_image_save(Request $request)
    {
        foreach ($request->image as $key => $item) {
            $ext = $item->extension();
            $filename = $this->fileupload($item, 'Product');
            $add = Files::create([
                'doc_path' => $filename,
                'table' => 'Product',
                'doc_ext' => $ext,
            ]);
        }
        return redirect()->route('upload_image_list')->with('success', 'Image Uploaded Successfully!');
    }
    //========================= Upload Image function =======================//

    //=============================== Product Section =============================//
    public function product_listeee(Request $request)
    {
        $data = [];
        $prodct = Product::where('status', '1')->paginate(10);
        foreach ($prodct as $item) {
            $item->image = env('ADMIN_IMG') . '/Product/' . $item->image;
        }
        $data['product'] = $prodct;
        return view('Admin.Product.index', compact('data'));
    }



    public function product_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cat_id' => 'required',
            'sub_cat' => 'required',
            'mrp' => 'required',
        ]);

        $slug = $this->strToslug($request->name);
        if ($request->has('id')) {
            if ($request->has('image')) {
                if ($request->image) {
                    $filename = $this->fileupload($request->image, 'Product');
                    $save_product = Product::where('id', $request->id)->update([
                        'image' => $filename,
                    ]);
                }
            }
            $save_product = Product::where('id', $request->id)->update([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
                'su_catId' => $request->sub_cat,
                'slug' => $slug,
                'composition' => $request->composition,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type,
                'mrp' => $request->mrp,
                'sale_price' => $request->sale_price,
                'how_to_apply' => $request->how_to_apply,
                'safty_pricotion' => $request->safty_pricotion,
                'off' => $request->off,
            ]);
        } else {
            if ($request->has('image')) {
                if ($request->image) {
                    $filename = $this->fileupload($request->image, 'Product');
                    $save_product = Product::create([
                        'image' => $filename,
                    ]);
                }
            }
            $save_product = Product::create([
                'name' => $request->name,
                'cat_id' => $request->cat_id,
                'su_catId' => $request->sub_cat,
                'slug' => $slug,
                'composition' => $request->composition,
                'unit' => $request->unit,
                'unit_type' => $request->unit_type,
                'mrp' => $request->mrp,
                'sale_price' => $request->sale_price,
                'how_to_apply' => $request->how_to_apply,
                'safty_pricotion' => $request->safty_pricotion,
                'off' => $request->off,
            ]);
        }
        return redirect()->route('product_list')->with('Product Added Sucessfully!');
    }

    public function get_subCatData(Request $request)
    {
        $subcateory = Category::where('cat_id', $request->selectedCat)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data send successfully!',
            'data' => $subcateory,
        ], 200);
    }
    //============ String to slug ===================//
    public function strToslug($string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        return $string;
    }
    //====================== image Upload ======================//
    public function fileupload($file, $type)
    {
        $path = "public/uploads/" . $type;
        if (file_exists($path)) {
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        } else {
            mkdir($path, 0777, true);
            $filename = time() . '-' . $type . '-' . $file->getClientOriginalName();
            $file->move($path, $filename);
            return $filename;
        }
    }
    //====================== image Upload ======================//



    //====================== Send Notification=============================//
    public function send_notification($user_id, $title, $type, $body1)
    {
        // $user = $request->user();
        $devicetoken = DB::table('app_logins')->where('table_name_id', $user_id)->first();
        $deviceToken = $devicetoken->device_token;
        // $body1 = 'test';
        $sendData = array(
            'type' => !empty($type) ? $type : $body1,
            'body' => !empty($body) ? $body : $body1,
            'title' => !empty($title) ? $title : $body1,
            'sound' => 'Default'
        );
        return $a = $this->fcmNotification($deviceToken, $sendData);
    }

    public function fcmNotification($device_id, $sendData)
    {
        #API access key from Google API's Console
        // API_ACCESS_KEY = "AAAAB7PPzm0:APA91bHMeFQ3zlaXALn8nFqht-20HimgnH9eTjfa-RHYuwgbA_M-zWGR_tIxGLQjQw1-K2HOVV5V29MmYiuNNLtJa1AL8fdG4QSi4rsD5Uy6FzKRTQgOC_HVlWSFG-U3YrH2lKEfgh_O";

        $fields = array(
            'to'    => $device_id,
            'data'  => $sendData,
            'notification'  => $sendData
        );
        $d = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAAB7PPzm0:APA91bHMeFQ3zlaXALn8nFqht-20HimgnH9eTjfa-RHYuwgbA_M-zWGR_tIxGLQjQw1-K2HOVV5V29MmYiuNNLtJa1AL8fdG4QSi4rsD5Uy6FzKRTQgOC_HVlWSFG-U3YrH2lKEfgh_O",
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function save_notification($user_id, $order_id, $title, $body, $type)
    {
        $check_data = Notification::where(['order_id' => $order_id])->first();
        if (!empty($check_data)) {
            $save_noti = Notification::where('order_id', $order_id)->update(
                [
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'title' => $title,
                    'body' => $body,
                    'type' => $type,
                ]
            );
        } else {
            $save_noti = Notification::create([
                [
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'title' => $title,
                    'body' => $body,
                    'type' => $type,
                ]
            ]);
        }
        return $save_noti;
    }

    function exportCSV($data = '', $title, $start_date, $endDate)
    {
        // Set the file name
        $filename = $title . $start_date . '-' . $endDate . '.csv';

        // Get the full path of the CSV file
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $fileHandle = fopen($filePath, 'w');

        // Iterate over the data and write each row to the file
        foreach ($data as $row) {
            // Remove any existing double quotes from column values
            $row = array_map(function ($value) {
                return str_replace('"', '', $value);
            }, $row);

            // Write the row to the CSV file
            fputcsv($fileHandle, $row);
        }

        // Close the file
        fclose($fileHandle);

        // Register a shutdown function to delete the file after download
        register_shutdown_function(function () use ($filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        });

        // Download the file
        return response()->download($filePath, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }





    //===================== Export csv file function ======================//

    //===================== String into Slug ==============================//
    function createSlug($string)
    {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
    //===================== String into Slug ==============================//

    //========================== Gobal Delete Function ================//
    function globalDelete(Request $request, $type, $id)
    {
        switch ($type) {
            case 'warehouse_manager':
                $delete_data = Agent::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'warehouse':
                $delete_data = Warehouse::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'brand':
                $delete_data = Brand::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'coupon':
                $delete_data = Coupon::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'home_slider':
                $delete_data = HomeSlider::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'industry':
                $delete_data = Industry::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'offer':
                $delete_data = Offer::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'career':
                $delete_data = Career::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'reward':
                $delete_data = Reward::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'image':
                $delete_data = Files::where('id', $id)->first();
                $delete_data->delete();
                break;
            case 'product':
                $product = Product::where('id', $id)->first();
                $product_attribute = ProductAttribute::where('product_id', $id)->first();
                $product_image = ProductImage::where('product_id', $id)->first();
                if (!empty($product)) {
                    $product->delete();
                }
                if (!empty($product_attribute)) {
                    $product_attribute->delete();
                }
                if (!empty($product_image)) {
                    $product_image->delete();
                }
                break;
            case 'leaf':
                $delete_data = Category::where('id', $id)->first();
                $delete_data->delete();
                break;
            default:
                break;
        }
        return redirect()->back()->with('success', 'Data Deleted Successfully!');
    }
    //========================== Gobal Delete Function ================//
    //================= Logout Function ============================//
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect('/');
    }

    //============ Testing ======================//
    public function testing()
    {
        return view('Admin.testing');
    }
}
