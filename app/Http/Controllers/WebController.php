<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Agent;
use App\Models\BankDetails;

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

    public function show($code) 
    {
        $data = $this->getDecodeData($code);
        $bankDetails = BankDetails::where(['company_id' => $data['companyId'], 'status' => '1'])->get();
        $banks = [];
        foreach ($bankDetails as $bankDetail) {
            $type = [
                '1' => 'upi',
                '2' => 'rtgs',
                '3' => 'neft',
                '4' => 'imps'
            ];
            if (in_array($bankDetail->payment_type, array_keys($type)) && $bankDetail->status){
                $banks[$type[$bankDetail->payment_type]] = $bankDetail;
            }
        }
        arsort($banks);
        $amount = $data['amount'];
        $qrCode = null;
        if (isset($banks['upi']) && $banks['upi']) {
            $upiUrl = "upi://pay?pa=".$banks['upi']->upi_id."&pn=".$banks['upi']->account_holderName."&am=$amount&cu=INR";
            $qrCode = QrCode::size(300)->generate($upiUrl);
        }

        return view('web', compact('qrCode', 'data', 'banks'));
    }

    public function auth() 
    {
        $token = request()->header('token');
        $agent = Agent::where('password', $token)->first();

        if ($agent) {
            $bankDetails = BankDetails::where(['company_id' => $agent->id, 'status' => '1'])->get();
            $banks = [];
            foreach ($bankDetails as $bankDetail) {
                $type = [
                    '1' => 'upi',
                    '2' => 'rtgs',
                    '3' => 'neft',
                    '4' => 'imps'
                ];
                if (in_array($bankDetail->payment_type, array_keys($type)) && $bankDetail->status){
                    $banks[$type[$bankDetail->payment_type]] = $bankDetail;
                }
            }

            if (!$banks) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company BankDetails Not found!',
                ], 422);
            }
            $orderId = request()->header('orderId');
            $amount = request()->header('amount');

            if (!$orderId || !$amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'please pass orderId and amount',
                ], 422);
            }

            $code = $this->getEncodeData($agent->id ,$orderId, $amount);

            $url = 'https://softlancer.in/other/atomic_git_old/v1/' . $code;

            $response = [
                'redirect_url' => $url
            ];

            return response()->json([
                'status' => true,
                'message' => 'data successfully send!',
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'unauthorized user'
            ], 401);
        }
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

        return redirect()->route('thank_you');
    }

    public function thank_you() 
    {
        return view('thanks');
    }
}
