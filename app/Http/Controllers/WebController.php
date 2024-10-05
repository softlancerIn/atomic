<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WebController extends Controller
{
    public function show() 
    {
        $upiUrl = "upi://pay?pa=9889702929@ybl&pn=rohit&am=500.00&cu=INR";

        // Generate QR code
        $qrCode = QrCode::size(300)->generate($upiUrl);

        // Pass QR code to the view
        return view('web', compact('qrCode'));
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
