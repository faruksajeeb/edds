<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;
use App\Lib\Webspice;
use App\Models\Market;
use App\Models\Option;
use App\Models\RespondentType;
use App\Services\Api\SendSmsService;
use DB;
use Illuminate\Support\Facades\Log;
// use Carbon\Carbon;

class SmsController extends Controller
{
    use SendSmsService;
    public $webspice;
    public $tableName;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
        $this->tableName = 'user_response_sms_info';
        // $this->middleware('throttle:5,1');

        // $this->middleware('throttle:' . $this->limiterKey(request()), [
        //     'maxAttempts' => $this->limiterMaxAttempts(),
        //     'decayMinutes' => $this->limiterDecayMinutes(),
        // ]);
    }

    function newSmsResponse(Request $request)
    {
        // dd($request->contact_no);
        if ($request->has('contact_no') && $request->has('msg')) {
            ### হাঁস-মুরগির বাজারে ব্যবহারকারীর ধরন এর কোড ঃ
            //কর্মচারী/বিক্রেতা/পরিচ্ছন্নতাকর্মী = S
            //ক্রেতা = B

            // আপনি যদি মৃত হাঁস, মুরগি, কোয়েল, টার্কি, রাজহাঁস ইত্যাদি জাতীয় কিছু দেখেন, তাহলে রিপোর্টের টাইপ হিসেবে P লিখুন এবং মোট সংখ্যা টাইপ করুন  (যেমন: P 4)।			
            //আপনি যদি কোন ধরনের মৃত বন্য অথবা পোষা পাখি দেখেন, তাহলে রিপোর্টের টাইপ হিসেবে W লিখুন এবং মোট সংখ্যা টাইপ করুন (যেমন: W 4)
            //আপনি যদি আপনার শারীরিক অসুস্থতা রিপোর্ট করতে চান, তাহলে রিপোর্টের টাইপ হিসেবে IL লিখুন

            ### লোকেশন এর কোডঃ
            // রায়েরবাজার সিটিকর্পোরেশন মার্কেট (R)
            // মিরপুর ৬ কাঁচাবাজার (M)

            ### Report Format
            // RespondentType<SPACE>Location<SPACE>ReportItem<>ResponseNumber Example: [S M P 4]
            // B<>M<>P<>4
            // S<>M<>P<>4

            $repondentList = ['S', 'B'];
            $itemList = ['P', 'W', 'IL']; //category

            $repondentList = RespondentType::where('status',7)->whereNotNull('sms_code')->get();
            // Extract 'sms_code' values from the results
            $repondentList = $repondentList->pluck('sms_code')->toArray();

            $itemList = Option::where('option_group_name','category')->where('status',7)->whereNotNull('option_value3')->get();
            // Extract 'sms_code' values from the results
            $itemList = $itemList->pluck('option_value3')->toArray();

            $marketList = Market::where('status',7)->whereNotNull('sms_code')->get();
            // Extract 'sms_code' values from the results
            $marketList = $marketList->pluck('sms_code')->toArray();


            $validFormat = "S<>M<>P<>4";
            $errMessage = '';

            $contact_no = $request->input('contact_no');
            $text = $request->input('msg');
            // dd($text);
            if ($text == null) {
                $errMessage = "Empty Response! Please Input Valid Format. Example: " . $validFormat;                
                
                $smsResponse = $this->sendSms($contact_no, $errMessage);
                if (!$smsResponse) {
                    $smsResponse = ' Sorry, SMS was not delivered.';
                }
                $response = [
                    'message' => $errMessage,
                    'data' => [
                        'sms_send_response' => $smsResponse,
                        'mobile_no' => $contact_no,
                        'response' => $text
                    ]
                ];
                return new ErrorResource($response);
            }


            $msg = explode(' ', $text);
            if (count($msg) == 1 || count($msg) == 2) {
                $respondentType = strtoupper($msg[0]);
                if ($respondentType == 'S') {
                    $validFormat = "S<>M<>P<>4";
                } else if ($respondentType == 'B') {
                    $validFormat = "B<>M<>P<>4";
                }
                $errMessage = "Invalid Format! Please Input Valid Format. Example: " . $validFormat;
                $smsResponse = $this->sendSms($contact_no, $errMessage);
                if (!$smsResponse) {
                    $smsResponse = ' Sorry, SMS was not delivered.';
                }
                $response = [
                    'message' => $errMessage,
                    'data' => [
                        'sms_send_response' => $smsResponse,
                        'mobile_no' => $contact_no,
                        'response' => $text
                    ]
                ];
                return new ErrorResource($response);
            } else {

                $respondentType = strtoupper($msg[0]);
                $responseLocation = strtoupper($msg[1]);
                $itemType = strtoupper($msg[2]);

                if ($respondentType == 'S') {
                    if ($itemType && $itemType == 'IL') {
                        $validFormat = "S<>M<>IL";
                    } else {
                        $validFormat = "S<>M<>P<>4";
                    }
                } else if ($respondentType == 'B') {
                    $validFormat = "B<>M<>P<>4";
                }

                #Validation Check...
                if (!in_array($respondentType, $repondentList)) {
                    $errMessage = "Invalid Respondent Type Code! Please Use Valid Code, Example: " . $validFormat;
                }else if (!in_array($responseLocation, $marketList)) {
                    $errMessage = "Invalid Location Code! Please Use Valid Code, Example: " . $validFormat;
                }else if (!in_array($itemType, $itemList)) {
                    $errMessage = "Invalid Response Item Code! Please Use Valid Code, Example: " . $validFormat;
                } else if ($respondentType != 'B' && $itemType == 'IL' && count($msg) != 3) {
                    $errMessage = "Bad Format ! Please Input Valid Format Example: " . $validFormat;
                } else if ($itemType != 'IL' && count($msg) != 4) {
                    $errMessage = "Bad Format ! Please Input Valid Format Example: " . $validFormat;
                } else if ($respondentType == 'B' && $itemType == 'IL') {
                    $errMessage = "Bad Format! Please Input Valid Format Example: " . $validFormat;
                }

                if ($errMessage) {
                    $smsResponse = $this->sendSms($contact_no, $errMessage);
                    if (!$smsResponse) {
                        $smsResponse = ' Sorry, SMS was not delivered.';
                    }
                    $response = [
                        'message' => $errMessage,
                        'data' => [
                            'sms_send_response' => $smsResponse,
                            'mobile_no' => $contact_no,
                            'response' => $text
                        ]
                    ];
                    return new ErrorResource($response);
                }

                try {
                    $quantity = $msg[3];
                    DB::transaction(function() use($contact_no,$respondentType,$responseLocation,$itemType,$quantity){
                        DB::table($this->tableName)->insert([
                            'contact_no' => $contact_no,
                            'respondent_type' => $respondentType,
                            'address' => $responseLocation,
                            'item' => $itemType,
                            'quantity' => isset($quantity) ? $quantity : NULL,
                            'created_at' => $this->webspice->now('datetime24'),
                        ]);
                    },5);                   

                    # Send SMS to Responder
                    $smsResponse = $this->sendSms($contact_no, "Thank You For Your Report");
                    if (!$smsResponse) {
                        $smsResponse = ' Sorry, SMS was not delivered.';
                    }
                    # Write Log
                    Log::channel('customlog')->info('SMS Response Received');
                    $response = [
                        'message' => "Response Received!",
                        'data' => [
                            'sms_send_response' => $smsResponse,
                            'mobile_no' => $contact_no,
                            'response' => $request->input('msg')
                        ]
                    ];
                    return new SuccessResource($response);
                } catch (\Exception $e) {
                    //$this->sendSms($contact_no, "Sorry, SMS was not received.");
                    # Write Log
                    Log::channel('customlog')->info($e->getMessage());
                    return 'An error occurred while inserting data.' . $e->getMessage();
                    $response = [
                        'message' => 'An error occurred while inserting data',
                        'data' => [
                            'error' => $e->getMessage(),
                            'mobile_no' => $contact_no,
                            'response' => $request->input('msg')
                        ]
                    ];
                    return new ErrorResource($response);
                }
            }
        } else {
            $response = [
                'message' => "'Contact_no' and 'msg' parameters are not found",
                'data' => []
            ];
            return new ErrorResource($response);
        }
    }


    protected function limiterKey(Request $request)
    {
        // Customize the limiter key based on the user or any other factor
        // return $request->ip();   
        // dd($request->input('contact_no'));    
        return $request->input('contact_no');
    }

    protected function limiterMaxAttempts()
    {
        // Set the maximum number of allowed attempts in a specific time period
        return 5;
    }

    protected function limiterDecayMinutes()
    {
        // Set the time period (in minutes) during which the attempts are counted
        return 1;
    }

}
