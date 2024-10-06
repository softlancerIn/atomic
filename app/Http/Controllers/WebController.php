<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    public function getEncodeData($companyId, $orderId, $amount)
    {
        // Concatenate parameters
        $stringToEncode = $companyId . '|' . $orderId . '|' . $amount;

        // Base64 encode the string
        $encodedString = base64_encode($stringToEncode);

        return $encodedString;
    }

    public function getDecodeData($code)
    {
        // Concatenate parameters
        $array = explode('|', base64_decode($code));

        $data = [
            'companyId' => $array[0],
            'orderId' => $array[1],
            'amount' => $array[2],
        ];

        return $data;
    }

    function isBase64($string)
    {
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string) && strlen($string) % 4 === 0) {
            $decoded = base64_decode($string, true);

            if ($decoded !== false && base64_encode($decoded) === $string) {
                return true; 
            }
        }

        return false; 
    }


    public function show($code) 
    {
        if ($this->isBase64($code)) {
            $data = $this->getDecodeData($code);
        } else {
            abort(404, 'Invalid or tampered URL');
        }

        $upiUrl = "upi://pay?pa=9889702929@ybl&pn=rohit&am=100.00&cu=INR";

        // Generate QR code
        $qrCode = QrCode::size(300)->generate($upiUrl);

        // Pass QR code to the view
        return view('web', compact('qrCode', 'data'));
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

        session::flash('success', 'Data saved Successfully');

        return redirect()->back();
    }
}