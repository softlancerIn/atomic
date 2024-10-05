<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    public function show() 
    {
        return view('web');
    }

    public function store()
    {
        $data = request()->only([
            'type', 
            'order_id', 
            'amount', 
            'ref_no'
        ]);

        // If the type is not 'upi', add additional fields
        if (request()->type != 'upi') {
            $data = array_merge($data, request()->only([
                'account_no', 
                'ifsc_code', 
                'holder_name'
            ]));
        }

        \DB::table('transactions')->insert($data);

        return redirect()->back();
    }
}
