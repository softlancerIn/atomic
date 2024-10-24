<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Agent;
use App\Models\BankDetails;
use App\Models\Transection;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\Validator;

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
        $data = $this->getDecodeData($code);
        $transection = Transection::where(['order_id' => $data['orderId'], 'company_id' => $data['companyId']])->first();
        if ($transection) {
            return view('thanks');
        }

        $bankDetails = BankDetails::where(['company_id' => $data['companyId'], 'status' => '1'])->inRandomOrder()->get();
        $banks = [];
        foreach ($bankDetails as $bankDetail) {
            $type = [
                '1' => 'upi',
                '2' => 'bank_service'
            ];
            if (in_array($bankDetail->payment_type, array_keys($type)) && $bankDetail->status) {
                $banks[$type[$bankDetail->payment_type]] = $bankDetail;
            }
        }
        arsort($banks);
        $amount = $data['amount'];
        $qrCode = null;
        if (isset($banks['upi']) && $banks['upi']) {
            $upiUrl = "upi://pay?pa=" . $banks['upi']->upi_id . "&pn=" . $banks['upi']->account_holderName . "&am=$amount&cu=INR";
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
                    '2' => 'bank_service'
                ];
                if (in_array($bankDetail->payment_type, array_keys($type)) && $bankDetail->status) {
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

            $code = $this->getEncodeData($agent->id, $orderId, $amount);

            $url = 'https://atomic.softlancer.in/v1/' . $code;

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

    public function payout()
    {
        $token = request()->header('token');
        $agent = Agent::where('password', $token)->first();

        if ($agent) {
            $ref_no = request()->header('ref_no');

            if (!$ref_no) {
                return response()->json([
                    'status' => false,
                    'message' => 'ref_no required!',
                ], 422);
            }

            $transection = Transection::where(['ref_no' => $ref_no, 'company_id' => $agent->id,])->first();

            if (!$transection) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid ref_no!',
                ], 422);
            }

            $response = RefundRequest::updateOrCreate([
                'ref_no' => $ref_no,
                'company_id' => $agent->id,
            ], [
                'ref_no' => $ref_no,
                'company_id' => $agent->id,
            ]);

            if ($response->status == 0) {
                $status = 'Initiate';
            } elseif ($response->status == 1) {
                $status = 'approved';
            } elseif ($response->status == 2) {
                $status = 'reject';
            }

            $responseData = [
                'ref_no' => $ref_no,
                'status' => $status,
            ];

            return response()->json([
                'status' => true,
                'message' => 'data successfully send!',
                'data' => $responseData
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'unauthorized user'
            ], 401);
        }
    }

    public function refundStatus()
    {
        $token = request()->header('token');
        $agent = Agent::where('password', $token)->first();

        if ($agent) {
            $ref_no = request()->header('ref_no');
            if (!$ref_no) {
                return response()->json([
                    'status' => false,
                    'message' => 'ref_no required!',
                ], 422);
            }

            $transection = Transection::where(['ref_no' => $ref_no, 'company_id' => $agent->id,])->first();

            if (!$transection) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid ref_no!',
                ], 422);
            }

            $response = RefundRequest::where([
                'ref_no' => $ref_no,
                'company_id' => $agent->id,
            ])->first();

            if ($response->status == 0) {
                $status = 'Initiate';
            } elseif ($response->status == 1) {
                $status = 'approved';
            } elseif ($response->status == 2) {
                $status = 'reject';
            }

            $responseData = [
                'ref_no' => $ref_no,
                'status' => $status,
            ];

            return response()->json([
                'status' => true,
                'message' => 'data successfully send!',
                'data' => $responseData
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
        Validator::make(request()->all(), [
            'type' => 'required',
            'order_id' => 'required',
            'company_id' => 'required',
            'amount' => 'required',
            'ref_no' => 'required'
        ]);

        $transection = Transection::where(['order_id' => request()->order_id, 'company_id' => request()->company_id])->first();

        if ($transection) {
            return redirect()->route('thank_you');
        }

        $data = request()->only([
            'type',
            'order_id',
            'company_id',
            'amount',
            'ref_no'
        ]);

        $bank = BankDetails::where('company_id', request()->company_id)->first();

        $otherData = [
            'account_no' => $bank->account_no,
            'ifsc_code' => $bank->ifsc_code,
            'holder_name' => $bank->holder_name
        ];
        // If the type is not 'upi', add additional fields
        if (request()->type != 'upi') {
            $data = array_merge($data, request()->only([
                'account_no',
                'ifsc_code',
                'holder_name'
            ]));
        } else {
            $data = array_merge($data, $otherData);
        }

        \DB::table('transactions')->insert($data);

        session::flash('success', 'Data saved Successfully');

        return redirect()->route('thank_you');
    }

    public function thank_you()
    {
        return view('thanks');
    }
}
