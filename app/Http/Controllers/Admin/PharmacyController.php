<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Users;
use App\Models\BankDetail;
use App\Models\Disease;
use App\Models\HealthConcern;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Banner;
use App\Models\UserAddress;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    use CommonTrait;

    public function __construct()
    {
    }

    public function api_file_path()
    {
        return env('UPLOAD_FILE');
    }

    public function pharmacy_list(Request $request)
    {
        // $pharmacy_order_list = DB::table('pharmacy_order')->where('is_deletd', '0')->get();
        return view('Admin.Agent.Pharmacy.index', compact('pharmacy_order_list'));
    }
}
