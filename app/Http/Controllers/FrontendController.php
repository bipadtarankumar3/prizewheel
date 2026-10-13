<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Spinner;
use App\Models\SpinnerForm;
use App\Models\Camping;
use App\Models\User;
use App\Models\BikeModel;
use App\Models\SpinnerFormAccess;
use App\Models\FormFields;
use App\Models\sitesetting;
use DB;
use Config;
use Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SpinnerFormMail;
use App\Models\ip_skip;

use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index($user_name){

        $date = date('Y-m-d');
        $user = User::where('name_url',$user_name)->first();
        // $computerId = $_SERVER['HTTP_USER_AGENT'].$_SERVER['LOCAL_ADDR'].$_SERVER['LOCAL_PORT'].$_SERVER['REMOTE_ADDR'];
        // echo $computerId;die;
        
        try {

            if ($user) {
    
                $userUpdate = User::where('id',$user->id)->update(['total_visit'=>$user->total_visit+1]);
    
                $userDate = User::whereDate('expiry_date','>=',$date)->where('id',$user->id)->first();
                if ($userDate) {
    
                    $today = date('Y-m-d');
                    //dd($today );
    
                    //$where = '1=1';
                    //$where .= " and  date(campings.end_date) >= '$today'" ;
                    $Camping = Camping::
                    whereDate('end_date', '>=',$today)
                     ->whereDate('start_date', '<=', $today)
                     ->where('created_by', $user->id)
                    ->where('status', 'active')
                    ->where('total_form', '>=', 1)
                    ->orderBy('id','desc')
                    //->whereRaw($where)
                    
                    ->first();
                    
                    if ($Camping) {
    
                        if ($user->default_spinn == 1) {
                            $Spinner = Spinner::where('created_by', $user->id)->where('camping_id', $Camping->id)->where('status','active')->inRandomOrder()->get();
    
                            // dd($Spinner);
    
                            $spinner_data = [];
                            $spinner_skip_data = [];
                            foreach ($Spinner as $key => $value) {
                                $arr = array(
                                    'id'=>encrypt($value->id),
                                    'text'=>$value->name,
                                    'color'=>$value->color,
                                    'reaction'=>"shocked",
                                    'price'=>$value->value,
                                    'image'=>$value->image,
                                    'chances'=>$value->chances !== null ? (float)$value->chances : null,
                                    'skip'=>$value->skip,
                                );
                                $spinner_data[] =  $arr ;
                                $isSkipped = (!empty($value->skip) && in_array(strtolower(trim($value->skip)), ['yes', '1', 'true']));
                                $isZeroStock = ((float)$value->value <= 0);
                                $isZeroChance = ($value->chances !== null && (float)$value->chances <= 0);
                                if ($isSkipped || $isZeroStock || $isZeroChance) {
                                    $spinner_skip_data[] = $value->name;
                                }
                            }
        
                            $spinner_data_json = json_encode( $spinner_data );
                            $spinner_skip_json = json_encode( $spinner_skip_data );
                            $rotation_time = $Camping->spinner_time;
        
                            $BikeModel = BikeModel::where('created_by',$userDate->id)->get();
                            $FormFields = FormFields::where('user_id',$userDate->id)->first();
        
                            //print_r($spinner_skip_data);die;
        
                            $ip_address = request()->ip();
                            $campaign_id = $Camping->id;
        
                            
                            $ip_skip = ip_skip::where('ip',$ip_address)->where('user_id',$userDate->id)->first();
                            if ($ip_skip) {
                                $SpinnerFormAccessCount = 'NO_LIMIT';
                            } else {
                                $SpinnerFormAccessCount = SpinnerFormAccess::where('ip_address',$ip_address)->where('campaign_id',$campaign_id)->count();
                            }
                            
                            $sitesetting = sitesetting::first();
                            
        
                            return view('frontend.index',compact(
                                'spinner_data_json',
                                'spinner_skip_json',
                                'rotation_time',
                                'Camping',
                                'user',
                                'BikeModel',
                                'SpinnerFormAccessCount',
                                'FormFields',
                                'sitesetting'
                            ));
                        } else {
                                 
                            $Spinner = Spinner::where('created_by', $user->id)->where('camping_id', $Camping->id)->where('status','active')->orderBy('id','desc')->get();
                            
                            if(count($Spinner) == 0 ){
                                    $status= 'spinn_not_available';
                                    return view('frontend.404',compact('status','user'));
                            }
                            
                            // dd($Spinner);
    
                            $spinner_data = [];
                            $spinner_skip_data = [];
                            foreach ($Spinner as $key => $value) {
                                $arr = array(
                                    'id'=>encrypt($value->id),
                                    'text'=>$value->name,
                                    'fillStyle'=>$value->color,
                                    'reaction'=>"shocked",
                                    'price'=>$value->value,
                                    'image'=>$value->image,
                                    'chances'=>$value->chances !== null ? (float)$value->chances : null,
                                    'skip'=>$value->skip,
                                );
                                $spinner_data[] =  $arr ;
                                $isSkipped = (!empty($value->skip) && in_array(strtolower(trim($value->skip)), ['yes', '1', 'true']));
                                $isZeroStock = ((float)$value->value <= 0);
                                $isZeroChance = ($value->chances !== null && (float)$value->chances <= 0);
                                if ($isSkipped || $isZeroStock || $isZeroChance) {
                                    $spinner_skip_data[] = $value->name;
                                }
                            }
    
                            $spinner_data_json = json_encode( $spinner_data );
                            $spinner_skip_json = json_encode( $spinner_skip_data );
                            $rotation_time = $Camping->spinner_time;
    
                            $BikeModel = BikeModel::where('created_by',$userDate->id)->get();
                            $FormFields = FormFields::where('user_id',$userDate->id)->first();
    
                            // print_r($spinner_data);die;
    
                            $ip_address = request()->ip();
                            $campaign_id = $Camping->id;
    
                            
                            $ip_skip = ip_skip::where('ip',$ip_address)->where('user_id',$userDate->id)->first();
                            if ($ip_skip) {
                                $SpinnerFormAccessCount = 'NO_LIMIT';
                            } else {
                                $SpinnerFormAccessCount = SpinnerFormAccess::where('ip_address',$ip_address)->where('campaign_id',$campaign_id)->count();
                            }
                            
                            $sitesetting = sitesetting::first();
    
                            $spinn_count = count($Spinner);
                            // dd($spinn_count);
                                // Calculate degree for each segment
                            $degreeIncrement = 360 / $spinn_count;
                            
    
                            return view('frontend.spinn2',compact(
                                'spinner_data_json',
                                'spinner_skip_json',
                                'rotation_time',
                                'Camping',
                                'user',
                                'BikeModel',
                                'SpinnerFormAccessCount',
                                'FormFields',
                                'sitesetting',
                                'campaign_id',
                                'degreeIncrement',
                                'spinn_count',
                            ));
                        }
                        
                       
                    } else {
                        $status= 'no_camping_available';
                        return view('frontend.404',compact('status','user'));
                    }
                } else {
                    $status= 'user_date_expired';
                    return view('frontend.404',compact('status','user'));
                }
                
                
                
    
                
            } else {
                $status= 'no_user_available';
                return view('frontend.404',compact('status'));
            }
        
        } catch (Exception $e) {
            Log::error("Unexpected error: " . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
         
    }

    public function submitForm(Request $request)
    {

        $Spinner = Spinner::where('camping_id', $request->campaign_id)->where('status','active')->orderBy('id','desc')->get()->toArray();

        $count = count($Spinner);
        if ($count <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No active prizes found for this campaign.',
            ]);
        }

        $degreeIncrement = 360 / $count;
        $prizes = [];
        $i = 1;
        foreach ($Spinner as $key => $value) {
            $prizes[] = [
                'id' => $value['id'],
                'segment_number' => $i,
                'fillStyle' => $value['color'],
                'text' => $value['name'],
                'image' => $value['image'] ?? '',
                'weight' => (isset($value['chances']) && $value['chances'] !== null && trim((string)$value['chances']) !== '') ? (float)$value['chances'] : null,
                'max_qty' => isset($value['value']) ? (float)$value['value'] : 0,
                'skip' => $value['skip'] ?? 'No',
                'degree' => $degreeIncrement * $i,
            ];
            $i++;
        }

        // ABSOLUTE STRICT FILTER: Eligible prizes ONLY!
        // A prize is DISQUALIFIED if:
        // 1. skip is 'Yes' (or 'yes', '1', 'true')
        // 2. max_qty/value <= 0 (out of stock / zero quantity)
        // 3. chances <= 0 (e.g. 0, 0.0, 0.00 — strictly never winnable)
        $eligiblePrizes = [];
        $totalWeight = 0;
        foreach ($prizes as $prize) {
            $isSkipped = (!empty($prize['skip']) && in_array(strtolower(trim($prize['skip'])), ['yes', '1', 'true']));
            $noStock = ($prize['max_qty'] <= 0);
            $hasChancesConfigured = ($prize['weight'] !== null);
            $zeroChance = ($hasChancesConfigured && $prize['weight'] <= 0);

            // If skipped, zero stock, or zero chance: NEVER SELECT!
            if ($isSkipped || $noStock || $zeroChance) {
                continue;
            }

            $chancesVal = $hasChancesConfigured ? (float)$prize['weight'] : 1.0;
            if ($chancesVal > 0) {
                // Higher quantity items are selected proportionally more often:
                $qtyWeight = max(1, (float)$prize['max_qty']) * $chancesVal;
                $eligiblePrizes[] = array_merge($prize, ['calc_weight' => $qtyWeight]);
                $totalWeight += $qtyWeight;
            }
        }

        if (empty($eligiblePrizes) || $totalWeight <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Currently no winning prizes are available. Please try again later.',
            ]);
        }

        // Weighted random selection strictly among eligible items
        $rand = (mt_rand(1, 100000) / 100000) * $totalWeight;
        $cumulative = 0;
        $selectedPrize = null;
        foreach ($eligiblePrizes as $prize) {
            $cumulative += $prize['calc_weight'];
            if ($rand <= $cumulative) {
                $selectedPrize = $prize;
                break;
            }
        }

        if (!$selectedPrize) {
            $selectedPrize = $eligiblePrizes[array_rand($eligiblePrizes)];
        }

        $after_angle = $selectedPrize['degree'];

        return response()->json([
            'success' => true,
            'data' => [
                'id' => encrypt($selectedPrize['id']),
                'code' => 'WIN' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6)),
                'segment_number' => $selectedPrize['segment_number'],
                'after_angle' => $after_angle,
                'seg_angle' => $selectedPrize['degree'],
                'name' => $selectedPrize['text'],
                'price' => $selectedPrize['max_qty'],
                'image' => $selectedPrize['image'] ?? '',
                'degree' => $degreeIncrement,
            ]
        ]);
    }
    


    
    
    

    
    
    


    public function spinner_form(Request $request){
        DB::beginTransaction();
        try {
            
            $spinner_id = decrypt($request->spinner_id);
            $Spinner = Spinner::where('id',decrypt($request->spinner_id))->first();

            $isSkipped = (!empty($Spinner->skip) && in_array(strtolower(trim($Spinner->skip)), ['yes', '1', 'true']));
            $isZeroStock = ($Spinner && (float)$Spinner->value <= 0);
            $isZeroChance = ($Spinner && $Spinner->chances !== null && (float)$Spinner->chances <= 0);

            if ($Spinner && !$isSkipped && !$isZeroStock && !$isZeroChance) {

                $Camping = Camping::where('id',$Spinner->camping_id)->first();
                // dd($Spinner);
                if ($Camping && $Camping->total_form >= 1 ) {
                        $ip_address = request()->ip();
                        $camping_id = $Spinner->camping_id;
                    // $SpinnerMacAddr = SpinnerForm::where('mac_address',$ip_address)->first();
                    // if ($SpinnerMacAddr) {
                    //     $data = array(
                    //         'message'=>'AlreadyInserted',
                    //         'status'=>1,
                    //         'data'=>'',
                    //     );
                    //     return response()->json($data);
                    // }

                    $url='';
                    /*************document upload **********/
                    if ($request->hasFile('screenshot')) {
                        try {
                            $screenshot = $request->file('screenshot');
                            $milisecond = round(microtime(true) * 1000);
                            $name = $screenshot->getClientOriginalName();
                            $actual_name = str_replace(" ", "_", $name);
                            $uploadName = $milisecond . "_" . $actual_name;
                            $uploadDir = public_path('upload/');
                            if (!file_exists($uploadDir)) {
                                @mkdir($uploadDir, 0777, true);
                            }
                            $screenshot->move($uploadDir, $uploadName);
                            $url = asset('upload/' . $uploadName);
                        } catch (\Throwable $e) {
                            Log::warning("Screenshot file upload failed: " . $e->getMessage());
                        }
                    } elseif ($request->filled('screenshot-file') || $request->filled('screenshot_file')) {
                        try {
                            $base64Screenshot = trim($request->input('screenshot-file') ?? $request->input('screenshot_file') ?? '');
                            if (!empty($base64Screenshot) && preg_match('/^data:image\/([a-zA-Z0-9\+\-\.]+);base64,/', $base64Screenshot, $type)) {
                                $data = substr($base64Screenshot, strpos($base64Screenshot, ',') + 1);
                                $ext = strtolower($type[1]);
                                if ($ext === 'jpeg') {
                                    $ext = 'jpg';
                                }
                                if (!in_array($ext, ['jpg', 'png', 'gif', 'webp'])) {
                                    $ext = 'png';
                                }
                                $data = str_replace(' ', '+', $data);
                                $decoded = base64_decode($data);
                                if ($decoded !== false && strlen($decoded) > 50) {
                                    $uploadDir = public_path('upload/');
                                    if (!file_exists($uploadDir)) {
                                        @mkdir($uploadDir, 0777, true);
                                    }
                                    $milisecond = round(microtime(true) * 1000);
                                    $filename = $milisecond . "_screenshot." . $ext;
                                    file_put_contents($uploadDir . $filename, $decoded);
                                    $url = asset('upload/' . $filename);
                                    Log::info("Screenshot saved successfully: " . $filename . " URL: " . $url);
                                } else {
                                    Log::warning("Base64 screenshot decode produced empty/invalid data.");
                                }
                            } else {
                                Log::warning("Screenshot base64 format invalid. Length: " . strlen($base64Screenshot));
                            }
                        } catch (\Throwable $e) {
                            Log::warning("Base64 screenshot decode failed: " . $e->getMessage());
                        }
                    }
                    /***********document upload ************/

                    date_default_timezone_set("Asia/Calcutta"); 
                    $userDate = User::where('id', $Spinner->created_by)->first();
                    $FormFields = FormFields::where('user_id', $userDate->id ?? $Spinner->created_by)->first();
                    $hasWhatsapp = (!isset($FormFields) || $FormFields->whatsapp_no != 'off');
                    $whatsapp_number = $hasWhatsapp ? (!empty($request->whatsapp_number) ? $request->whatsapp_number : $request->phone) : null;

                    $arr = array(
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'phone'=>$request->phone,
                        'whatsapp_number'=>$whatsapp_number,
                        'schreenshot'=>$url,
                        'spinner_id'=>$Spinner->id,
                        'camping_id'=>$Spinner->camping_id,
                        'bike_model_id'=>$request->bike_model_id,
                        'mac_address'=>$ip_address
                    );
                    SpinnerForm::create($arr);

                    $form_submitted = $Camping->form_submitted + 1;
                    Camping::where('id',$camping_id)->update(['form_submitted'=>$form_submitted,'number_of_total_spinn'=> $Camping->number_of_total_spinn - 1]);
                   
                    Spinner::where('id',$spinner_id)->update(['value'=>$Spinner->value-1]);

                    $mail=DB::table('mail_configures')->first();
                    if ($mail) {
                        $config = array(
                            'driver' => 'smtp',
                            'host' => $mail->mail_host,
                            'port' => $mail->mail_port,
                            'from' => array('address' => $mail->mail_from_address, 'name' => $mail->mail_from_name),
                            'encryption' => $mail->mail_encryption,
                            'username' => $mail->mail_username,
                            'password' => $mail->mail_password,
                            'sendmail' => '/usr/sbin/sendmail -bs',
                            'pretend' => false,
                            'stream' => [
                                'ssl' => [
                                    'allow_self_signed' => true,
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                ],
                            ],
                        );
                        Config::set('mail',$config);
                    }
                    $type="ADMIN";
                    $subject="Spinner Form";
                    
                    $userDate = User::where('id',$Camping->created_by)->first();
                    if ($userDate) {
                        
                        $SpinnerDetails = Spinner::where('id',decrypt($request->spinner_id))->first();
                        $mail_arr = array(
                            'name'=>$request->name,
                            'email'=>$request->email,
                            'phone'=>$request->phone,
                            'whatsapp_number'=>$request->whatsapp_number,
                            'schreenshot'=>$url,
                            'spinner_id'=>$Spinner->id,
                            'spinner_name'=>($SpinnerDetails)? $SpinnerDetails->name:'',
                            'camping_id'=>$Spinner->camping_id,
                            'camping_name'=>$Camping->title,
                            'bike_model_id'=>$request->bike_model_id,
                            'ip_address'=>$ip_address
                        );
                        
                        if(!empty($request->phone) && !empty($userDate->wp_key)){
                            try {
                                $curl = curl_init();
                                
                                $string = ($SpinnerDetails)? $SpinnerDetails->name:'';
                                $replaced = str_replace(' ', '%20', $string);
                                $message = 'Congratulations,%20'.$request->name.'%20You%20have%20won%20the%20'.$replaced.',%20Our%20team%20will%20contact%20you%20soon.%20If%20have%20you%20any%20Query,%20Please%20reply%20Hello';
                            
                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'http://api.vyyapar.com/wapp/api/send?apikey='.$userDate->wp_key.'&mobile='.$request->phone.'&msg='.$message,
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 5,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'GET',
                                ));
                                
                                $response = curl_exec($curl);
                                
                                curl_close($curl);

                                if($userDate->wp_count == ''){
                                    $count = 1;
                                }else{
                                    $count = $userDate->wp_count + 1;
                                }

                                User::where('id',$userDate->id)->update(['wp_count'=>$count]);
                            } catch (\Throwable $wpEx) {
                                Log::warning("WhatsApp API error: " . $wpEx->getMessage());
                            }
                        }
                        
                            


                       // $admin= Mail::to($userDate->email)->send(new SpinnerFormMail($type,$mail_arr,$subject));

                        // if ($request->email !='') {
                        //     $user= Mail::to($request->email)->send(new SpinnerFormMail('CUSTOMER',$mail_arr,$subject));
                        // }

                        
                    }
                    
                    DB::commit();

                    $data = array(
                        'message'=>'Inserted',
                        'status'=>1,
                        'data'=>'',
                    );
                    return response()->json($data);
                } else {
                    // DB::rollback();
                    $data = array(
                        'message'=>'Error',
                        'status'=>0,
                        'data'=>'',
                    );
                    return response()->json($data);
                }
                
            } else {
                DB::rollback();
                $data = array(
                    'message'=>'Not Getting The Spinner',
                    'status'=>0,
                    'data'=>'',
                );
                return response()->json($data);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $data = array(
                'message' => 'Code Error: ' . $th->getMessage(),
                'status' => 0,
                'data' => '',
            );
            return response()->json($data);
        }
        
    }
    
    public function dummy(){

        return view('frontend.dummy');
        
    }
    
    public function spinner_form_check(Request $request){

        $ip_address = request()->ip();

        $SpinnerMacAddr = SpinnerForm::where('mac_address',$ip_address)->first();
        if ($SpinnerMacAddr) {
            $data = array(
                'message'=>'AlreadyInserted',
                'status'=>1,
                'data'=>'',
            );
            return response()->json($data);
        }
        
    }
    
    public function spinner_value_check(Request $request){


        try {
            $spinner_id = decrypt($request->spinner_id);
            $Spinner = Spinner::where('id',$spinner_id)->first();
            $isSkipped = (!empty($Spinner->skip) && in_array(strtolower(trim($Spinner->skip)), ['yes', '1', 'true']));
            $hasStock = ($Spinner && (float)$Spinner->value > 0);
            $hasChances = ($Spinner && ($Spinner->chances === null || trim((string)$Spinner->chances) === '' || (float)$Spinner->chances > 0));

            if ($Spinner && $hasStock && !$isSkipped && $hasChances) {

                // $SpinnerUpdate = Spinner::where('id',$spinner_id)->update(['value'=>$Spinner->value-1]);
                $Camping = Camping::where('id',$Spinner->camping_id)->first();
                if ($Camping) {
                    $total_form = $Camping->total_form - 1;
                    $CampingUpdate = Camping::where('id',$Spinner->camping_id)->update(['total_form'=>$total_form]);
                    $userDate = User::where('id',$Camping->created_by)->first();
                    if ($userDate) {
                        $userUpdate = User::where('id',$Camping->created_by)->update(['total_spin_round'=>$userDate->total_spin_round + 1]);

                    }
                   
                }

               
    
                $data = array(
                    'message'=>'updated',
                    'status'=>true,
                    'data'=>''
                );
                return response()->json($data);
            }else{
                $data = array(
                    'message'=>'There Is No Offer',
                    'status'=>false,
                    'data'=>''
                );
                return response()->json($data);
            }
        } catch (\Throwable $th) {
            $data = array(
                'message'=>'Id Error',
                'status'=>false,
                'data'=>'',
            );
            return response()->json($data);
        }

        
        
    }
    
    public function spinner_round_check(Request $request){

        $ip_address = request()->ip();
        $campaign_id = $request->campaign_id;
        $user_id = $request->user_id;

        $user = User::where('id',$user_id)->first();

        
        $ip_skip = ip_skip::where('ip',$ip_address)->where('user_id',$user->id)->first();

        if ($ip_skip) {
            $data = array(
                'message'=>'NotInserted',
                'status'=>true,
                'data'=>'',
                'total_count'=>'No Limit'
            );
            return response()->json($data);
        } else {

            $Camping = Camping::where('id',$campaign_id)->first();
            $SpinnerFormAccess = SpinnerFormAccess::where('ip_address',$ip_address)->where('campaign_id',$campaign_id)->count();
            $total_count =  $user->spin_whell_round -$SpinnerFormAccess ;
            
            if ($Camping->number_of_total_spinn > 0 ) {
                

                $SpinnerMacAddr = SpinnerForm::where('mac_address',$ip_address)->where('camping_id',$campaign_id)->first();
                if ($SpinnerMacAddr) {
                    $data = array(
                        'message'=>'You have already submitted details',
                        'status'=>false,
                        'data'=>'',
                        'total_count'=>$total_count
                    );
                    return response()->json($data);
                }

                if ($SpinnerFormAccess >= $user->spin_whell_round) {
                        $data = array(
                            'message'=>'You have no limit for spin',
                            'status'=>false,
                            'data'=>'',
                            'total_count'=>$total_count
                        );
                    return response()->json($data);
                }else{

                    $SpinnerFormAccess = SpinnerFormAccess::create(['ip_address'=>$ip_address,'campaign_id'=>$campaign_id]);

                    $SpinnerFormAccessCount = SpinnerFormAccess::where('ip_address',$ip_address)->where('campaign_id',$campaign_id)->count();
                    $total_count =  $user->spin_whell_round -$SpinnerFormAccessCount ;

                   

                    $data = array(
                        'message'=>'NotInserted',
                        'status'=>true,
                        'data'=>'',
                        'total_count'=>$total_count
                    );
                    return response()->json($data);

                    

                }
            }else{
                $data = array(
                    'message'=>'Camping Spin Not Available',
                    'status'=>false,
                    'data'=>'',
                    'total_count'=>$total_count
                );
                return response()->json($data);
            }

            
        }
        


        
        
    }
}
