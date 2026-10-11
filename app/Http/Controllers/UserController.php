<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;

use Hash;
use Session;
use App\Models\User;
use App\Models\Camping;
use App\Models\Spinner;
use App\Models\SpinnerForm;
use App\Models\ip_skip;
use App\Models\SpinnerFormAccess;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Str;

use Config;
use Mail;
use App\Mail\adminForgotPassMail;
use App\Mail\OtpVerifyMail;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;



class UserController extends Controller
{
    public function login(Request $request){
        if (Auth::check()) {
            return redirect('admin/dashboard');
        }
        $initialMode = $request->query('mode', 'login');
        if (!session()->has('captcha_code')) {
            session(['captcha_code' => $this->generateRandomCaptcha()]);
        }
        return view('admin.login', ['initialMode' => $initialMode]);
    }

    public function register_page(Request $request){
        if (Auth::check()) {
            return redirect('admin/dashboard');
        }
        if (!session()->has('captcha_code')) {
            session(['captcha_code' => $this->generateRandomCaptcha()]);
        }
        return view('admin.login', ['initialMode' => 'signup']);
    }

    public function refresh_captcha(){
        $code = $this->generateRandomCaptcha();
        session(['captcha_code' => $code]);
        return response()->json(['captcha' => $code]);
    }

    private function generateRandomCaptcha($length = 6){
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function register_post(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        if ($request->has('captcha') && !empty($request->captcha)) {
            $expectedCaptcha = session('captcha_code');
            if ($expectedCaptcha && strtoupper(trim($request->captcha)) !== strtoupper(trim($expectedCaptcha))) {
                $notification = array(
                    'messege' => 'Invalid human verification code. Please try again.',
                    'alert-type' => 'error'
                );
                return redirect('login?mode=signup')->with($notification)->withInput();
            }
        }

        $existing = User::where('email', $request->email)->first();
        if ($existing) {
            $notification = array(
                'messege' => 'This email is already registered. Please sign in.',
                'alert-type' => 'error'
            );
            return redirect('login')->with($notification)->withInput();
        }

        $baseSlug = Str::slug($request->name, '_');
        if (empty($baseSlug)) {
            $baseSlug = 'user';
        }
        $uniqueSlug = $baseSlug;
        $count = 1;
        while (User::where('name_url', $uniqueSlug)->exists()) {
            $uniqueSlug = $baseSlug . '_' . $count;
            $count++;
        }

        $user = User::create([
            'user_unique_id' => Str::random(10),
            'name' => $request->name,
            'name_url' => $uniqueSlug,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? '',
            'type' => 'user',
            'status' => 'active',
            'expiry_date' => date('Y-m-d', strtotime('+1 day')),
            'spin_whell_round' => 100,
            'default_background' => 'on',
            'default_spinn' => '1',
            'note' => 'Self-registered customer account (1-Day Trial)',
            'otp' => '123456',
            'otp_link_status' => 'yes',
        ]);

        Auth::login($user);
        session()->put('adminUserId', $user->id);
        session()->put('type', $user->type);
        session()->put('adminName', $user->name);

        $notification = array(
            'messege' => 'Welcome! Your account has been created successfully.',
            'alert-type' => 'success'
        );
        return redirect('admin/dashboard')->with($notification);
    }

    public function google_redirect(Request $request)
    {
        $clientId = env('GOOGLE_CLIENT_ID');
        $redirectUri = env('GOOGLE_REDIRECT_URI') ?: url('auth/google/callback');

        if ($clientId) {
            $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'response_type' => 'code',
                'scope' => 'openid email profile',
                'access_type' => 'offline',
                'prompt' => 'select_account',
            ]);
            return redirect($url);
        }

        // Demo / Instant Google login fallback if Google client credentials not configured in .env
        $demoEmail = 'google.user@example.com';
        $user = User::where('email', $demoEmail)->first();
        if (!$user) {
            $user = User::create([
                'user_unique_id' => Str::random(10),
                'name' => 'Google Business User',
                'name_url' => 'google_business_user',
                'email' => $demoEmail,
                'password' => Hash::make(Str::random(16)),
                'phone' => '+91 98765 43210',
                'type' => 'user',
                'status' => 'active',
                'expiry_date' => date('Y-m-d', strtotime('+1 day')),
                'spin_whell_round' => 100,
                'default_background' => 'on',
                'default_spinn' => '1',
                'note' => 'Google Authenticated User (1-Day Trial)',
                'otp' => '123456',
                'otp_link_status' => 'yes',
            ]);
        }
        Auth::login($user);
        session()->put('adminUserId', $user->id);
        session()->put('type', $user->type);
        session()->put('adminName', $user->name);
        if (empty($user->phone)) {
            session()->put('google_first_login_modal', true);
        }

        $notification = array(
            'messege' => 'Logged in successfully with Google! (1-Day Trial Active)',
            'alert-type' => 'success'
        );
        return redirect('admin/dashboard')->with($notification);
    }

    public function google_callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect('login')->with([
                'messege' => 'Google Sign-In cancelled: ' . $request->get('error'),
                'alert-type' => 'warning'
            ]);
        }

        $code = $request->get('code');
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI') ?: url('auth/google/callback');

        if ($code && $clientId && $clientSecret) {
            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->post('https://oauth2.googleapis.com/token', [
                    'form_params' => [
                        'code' => $code,
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'redirect_uri' => $redirectUri,
                        'grant_type' => 'authorization_code',
                    ],
                ]);
                $tokens = json_decode((string) $response->getBody(), true);
                $accessToken = $tokens['access_token'] ?? null;

                if ($accessToken) {
                    $userResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                        ],
                    ]);
                    $googleUser = json_decode((string) $userResponse->getBody(), true);
                    $email = $googleUser['email'] ?? null;
                    $name = $googleUser['name'] ?? 'Google User';

                    if ($email) {
                        $user = User::where('email', $email)->first();
                        if (!$user) {
                            $baseSlug = Str::slug($name, '_') ?: 'user';
                            $uniqueSlug = $baseSlug;
                            $count = 1;
                            while (User::where('name_url', $uniqueSlug)->exists()) {
                                $uniqueSlug = $baseSlug . '_' . $count;
                                $count++;
                            }
                            $user = User::create([
                                'user_unique_id' => Str::random(10),
                                'name' => $name,
                                'name_url' => $uniqueSlug,
                                'email' => $email,
                                'password' => Hash::make(Str::random(16)),
                                'phone' => '',
                                'type' => 'user',
                                'status' => 'active',
                                'expiry_date' => date('Y-m-d', strtotime('+1 day')),
                                'spin_whell_round' => 100,
                                'default_background' => 'on',
                                'default_spinn' => '1',
                                'note' => 'Google SSO User (1-Day Trial)',
                                'otp' => '123456',
                                'otp_link_status' => 'yes',
                            ]);
                        }
                        Auth::login($user);
                        session()->put('adminUserId', $user->id);
                        session()->put('type', $user->type);
                        session()->put('adminName', $user->name);
                        if (empty($user->phone)) {
                            session()->put('google_first_login_modal', true);
                        }

                        return redirect('admin/dashboard')->with([
                            'messege' => 'Signed in with Google successfully!',
                            'alert-type' => 'success'
                        ]);
                    }
                }
            } catch (\Exception $e) {
                return redirect('login')->with([
                    'messege' => 'Google Sign-In failed: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
            }
        }

        return redirect('login')->with([
            'messege' => 'Google authorization failed.',
            'alert-type' => 'error'
        ]);
    }

    public function complete_first_login_profile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:6|max:25',
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;

            if ($request->filled('name_url')) {
                $newSlug = Str::slug($request->name_url, '_');
                if (!empty($newSlug)) {
                    $slugExists = User::where('name_url', $newSlug)->where('id', '!=', $user->id)->exists();
                    if (!$slugExists) {
                        $user->name_url = $newSlug;
                    }
                }
            }

            if ($request->filled('wp_key')) {
                $user->wp_key = $request->wp_key;
            }

            $user->save();

            session()->forget('google_first_login_modal');
            session()->put('adminName', $user->name);

            $notification = [
                'messege' => 'Profile details saved successfully! Welcome to your dashboard.',
                'alert-type' => 'success'
            ];
            return redirect('admin/dashboard')->with($notification);
        }

        return redirect('login');
    }

    public function login_post(Request $request)
    {

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make(123456)
        // ]);return;

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if (Auth::user()->type == 'admin') {
                $otp_number = 123456;
                //$otp_number = mt_rand(100000, 999999);
                $admin=DB::table('users')->where('email',Auth::user()->email)->update(['otp'=>$otp_number]);
    
                 $mail=DB::table('mail_configures')->first();
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
                $type="ADMIN";
                $user= Mail::to(Auth::user()->email)->send(new OtpVerifyMail($type,$otp_number));
                session()->put('admin_id', Auth::user()->id);
                session()->put('otp', $otp_number);
                return redirect('otp_verify_page');
            } else {
                return redirect('admin/dashboard');
            }
            

            
        }
  
        $notification = array(
            'messege'=>'Login details are Invalid',
            'alert-type'=>'error'
        );
        return back()->with($notification);
    }

    public function otp_verify_page(){

        $admin_id = session()->get('admin_id');

        if ($admin_id) {
            return view('admin.otp_verify');
        } else {
            return redirect('admin');
        }
        
    }

    
    //admin Password Check
    public function otp_verify(Request $request){

        $admin_id = session()->get('admin_id');
        $otp = session()->get('otp');
        $get_otp = $request->otp;
    
        if ($otp == $get_otp) {

            $admin=User::where('id',$admin_id)->first();

            if ($admin->type == 'admin' ) {

                $six_digit_random_number = random_int(100000, 999999);

                
                $UserUpdate=User::where('id',$admin_id)->update(['otp_link_status'=>'yes']);

                $adminId=$admin->id;
                $request->session()->put('adminId', $adminId);
                session()->put('adminUserId', $admin->id);
                session()->put('type', $admin->type);
                session()->put('adminName', $admin->name);
                return redirect('admin/dashboard');
            } else {
                if ($admin->admin_status == '1') {
                    $subAdmin=Admin_permission::where('admin_permission_admin_id',$admin->id)->first();
                    $adminPermission = explode(',', $subAdmin->admin_permission_details);

                    //print_r($adminPermission);
                    for ($i=0; $i <count($adminPermission) ; $i++) {
                        $per =  $adminPermission[$i];
                        session()->put($per, $adminPermission[$i]);
                    }
                    $adminId=$admin->id;
                    $request->session()->put('adminId', $adminId);
                    session()->put('adminUserId', $admin->email);
                    session()->put('type', $admin->type);
                    session()->put('adminName', $admin->name);
                    //echo Session::get('ProductList'); die;
                    return redirect('admin/dashboard');
                } else {
                    $request->session()->flash('adminDeactive', 'adminDeactive');
                    return back();
                }

            }
        } else {
            $request->session()->flash('otp_error', 'otp_error');
            return redirect('otp_verify_page');
        }

     
    }


    public function dashboard()
    {
        if(Auth::check()){

            $today = date('Y-m-d');

            $Users = User::where('type','user')->count();
            $ActiveUsers = User::where('type','user')->where('status','active')->count();
            $InactiveUsers = User::where('type','user')->where('status','inactive')->count();
            $ExpiredUser = User::where('type','user')->whereDate('expiry_date','<',$today)->count();
            $Camping = Camping::where('created_by',Auth::user()->id)->count();
            $CampingList = Camping::where('created_by',Auth::user()->id)->select('id')->get()->toArray();
            $Spinner = Spinner::where('created_by',Auth::user()->id)->count();
            //dd($CampingList);
            $camp_id =[];
            foreach ($CampingList as $key => $value) {
                $camp_id[] =$value['id'];
            }
            $SpinnerForm = SpinnerForm::where('camping_id',$camp_id)->count();

            return view('admin.dashboard',compact('Users','Camping','SpinnerForm','ActiveUsers','InactiveUsers','ExpiredUser','Spinner'));
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    


    public function logout(){

        Session::flush();
      // $class=DB::table('class')->get();
       return redirect('/login');
    }


    public function sub_user_list(Request $request){

        if(Auth::check() && Auth::user()->type == 'admin'){


            $where = '1=1';

            if(isset($request))
            {
                
                if($request->start_date!='')
                {
                    $where .= " and  date(users.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if($request->end_date!='')
                {

                    $where .= " and  date(users.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }

            }

            $array['user'] = User::where('type','user')->whereRaw($where)->orderBy('id','desc')->get();
            // dd($user);
            return view('admin.user.list',$array);
        }else{
            return redirect('/');
        }
    }

    public function expiry_sub_user(Request $request){

        if(Auth::check()){

            $date = date('Y-m-d');

            $array['user'] = User::where('type','user')->whereDate('expiry_date','<=',$date)->get();
            // dd($user);
            return view('admin.user.expiry_user_list',$array);
        }
    }

    public function add_sub_user_page(){

        if(Auth::check()){
            return view('admin.user.create');
        }
    }

    public function downloadUserPdf(Request $request){

        if(Auth::check()){
                //dd($request->all());
                $user_id = $request->checkbox;
            if ($user_id != null) {
                $array['user'] = User::whereIn('id',$user_id )->get();
            $pdf = PDF::loadView('admin.user.userPdf', $array);
        
            return $pdf->download('user.pdf');
            } else {
                return back();
            }
                  
        }
    }

    public function user_name_checking(Request $request){

        //dd($request->all());

        $user = User::where('name_url',$request->name)->first();
        if ($user) {
            $user_status = 'exist';
        } else {
            $user_status = 'not_exist';
        }
        return $user_status;
    }

    public function add_sub_user(Request $request){

        if(Auth::check()){

            $name_url = str_replace(' ', '_',$request->name_url);
            $nameurl = strtolower($name_url);
            
            if ($request->id !='') {
                

                $user = User::find($request->id);

                if ($request->password != '' && $request->old_password != '') {
                    if(!Hash::check($request->old_password, $user->password)){
                        $notification = array(
                            'messege'=>'Old Password is not matching',
                            'alert-type'=>'error'
                        );
                        return back()->with($notification);
                    }else{
                        $user->password = Hash::make($request->password);
                    }
                    
                }

                if ($request->customer_password == 'changed') {
                    if(!empty($request->password)){
                        $user->password = Hash::make($request->password);
                    }
                }

                $user->name = $request->name;
                $user->name_url = $request->name_url;
                $user->email = $request->email;
                
                $user->phone = $request->phone;
                if ($request->status != '') {
                    $user->status = $request->status;
                }
                if ($request->expiry_date != '') {
                    $user->expiry_date = $request->expiry_date;
                }
                if ($request->spin_whell_round != '') {
                    $user->spin_whell_round = $request->spin_whell_round;
                }
                if ($request->note != '') {
                    $user->note = $request->note;
                }
                if ($request->background_color != '') {
                    $user->background_color = $request->background_color;
                }


                if ($request->default_background != '') {
                    $user->default_background = $request->default_background;
                }else{
                    $user->default_background = '';
                }

                if ($request->default_spinn != '') {
                    $user->default_spinn = $request->default_spinn;
                }


                if ($request->wp_key != '') {
                    $user->wp_key = $request->wp_key;
                }
                
                if (isset($request->file) && !empty($request->file)) {
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $name = time() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('upload/');
                        $file->move($destinationPath, $name);

                        $document_link =  URL('upload/'.$name);
                        $user->logo = $document_link;
                    }

                }
                
                if (isset($request->background_image) && !empty($request->background_image)) {
                    if ($request->hasFile('background_image')) {
                        $file = $request->file('background_image');
                        $name = time() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('upload/');
                        $file->move($destinationPath, $name);

                        $document_link =  URL('upload/'.$name);
                        $user->background_image = $document_link;
                    }

                }
                
                $user->save();

                
                $notification = array(
                    'messege'=>'User Updated successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);
            } else {

                $user = User::where('email',$request->email)->first();

                if ($user) {
                    $notification = array(
                        'messege'=>'Please enter unique email',
                        'alert-type'=>'error'
                    );
                    return back()->with($notification);
                }

                $document_link  ='';

                if (isset($request->file) && !empty($request->file)) {
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $name = time() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('upload/');
                        $file->move($destinationPath, $name);

                        $document_link =  URL('upload/'.$name);
                        
                    }
                }

                User::create([
                    'user_unique_id' => Str::random(10),
                    'name' => $request->name,
                    'name_url' => $nameurl,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'type' => 'user',
                    'status' => $request->status,
                    'expiry_date' => $request->expiry_date,
                    'spin_whell_round' => $request->spin_whell_round,
                    'default_background' => 'on',
                    'note' => $request->note,
                    'wp_key' => $request->wp_key,
                    'logo' => $document_link
                ]);

                $notification = array(
                    'messege'=>'User inserted successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);

            }
            


        }
    }

    
    public function edit_sub_user($id){

        if(Auth::check()){
            $user = User::where('id',$id)->first();
            return view('admin.user.create',compact('user','id'));
        }
    }
    
    public function profile(){

        if(Auth::check()){

            $id = Auth::user()->id;

            $user = User::where('id',$id)->first();
            return view('admin.user.profile',compact('user','id'));
        }
    }
    
    public function profile_update(Request $request){

        if(Auth::check()){
            
            $id = Auth::user()->id;
 
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != '') {
                $user->password = $request->password;
            }
            $user->phone = $request->phone;
            $user->note = $request->note;
            if (isset($request->file) && !empty($request->file)) {
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $name = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('upload/');
                    $file->move($destinationPath, $name);

                    $document_link =  URL('upload/'.$name);
                    $user->logo = $document_link;
                }

            }
            
            $user->save();

            
            $notification = array(
                'messege'=>'User Updated successfully',
                'alert-type'=>'success'
            );
            return back()->with($notification);

        }
    }

    public function delete_sub_user($id){

        if(Auth::check()){
            
            $user = User::where('id',$id)->delete();

            $notification = array(
                'messege'=>'User Deleted Successfully',
                'alert-type'=>'error'
            );
            return back()->with($notification);
            
        }
    }


        //Admin Forgot Password
        public function forgotPassword(){

            //echo "di";die;
    
            return view('admin.forgotPassword.forgotPassword');
         }
    
         //admin UserId Check
         public function adminUserIdCheck(Request $request){
             $userName = $request->email;
             $admin=DB::table('users')->where('email',$request->email)->first();
             if ($admin) {
                 //echo "dd";
                 //print_r($admin);
                 $adminKey = $admin->user_unique_id;
                 $adminMail = $admin->email;
                 $subject='Admin Forgot Password';
                 //$message='Thank You For Contact Us';
                 $admin=DB::table('users')->where('email',$request->email)->update(['user_email_status'=>'urlAvailable']);
    
                 $mail=DB::table('mail_configures')->first();
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
                $type="ADMIN";
                 $user= Mail::to($adminMail)->send(new adminForgotPassMail($type,$adminKey,$subject));
                 $request->session()->flash('checkYourMail', 'checkYourMail');
                 $notification = array(
                            'messege'=>'Check Your Email',
                            'alert-type'=>'success'
                        );
                        return back()->with($notification);
                 //return view('admin.forgotPassword.forgotConfirmPassword',compact('userName'));
    
             } else {
                $notification = array(
                    'messege'=>'User Id Not Maching',
                    'alert-type'=>'error'
                );
                return back()->with($notification);
             }
         }
    
         //admin Password Check
         public function confirmPasswordPage($adminKey){
             $admin=DB::table('users')
             ->where('user_unique_id',$adminKey)
             ->first();
             $adminStatus='';
             if ( $admin) {
                 if ($admin->user_email_status == 'urlAvailable') {
                     $adminStatus= "urlAvailable";
                 } else {
                     $adminStatus= "urlNotAvailable";
                 }
             }else{
                 $adminStatus= "adminNotAvailable";
             }
             //echo $adminStatus;
             $adminKey = $adminKey;
             return view('admin.forgotPassword.forgotConfirmPassword',compact('adminKey','adminStatus'));
         }
    
         //admin Password Check
         public function confirmPassword(Request $request){
             $password = $request->password;
             $confirmPassword = $request->confirmPassword;
    
             if ( $password  == $confirmPassword) {
                 $adminUp=DB::table('users')->where('user_unique_id',$request->adminKey)->update(['password'=>Hash::make($password),'user_email_status'=>'urlNotAvailable']);
                 $admin=User::where('user_unique_id',$request->adminKey)->first();
                    $credentials = [
                        'email' => $admin->email,
                        'password' =>$password,
                    ];

                        if (Auth::attempt($credentials)) {
                            return redirect('admin/dashboard');
                        }
             } else {
                
                 $notification = array(
                    'messege'=>'Password Not Match',
                    'alert-type'=>'error'
                );
                return back()->with($notification);
             }
         }



    //---------------------------------- Skip Ip ------------------------------------

    public function ip_skip(Request $request){

        if(Auth::check()){

            $where = '1=1';

            if(isset($request))
            {
                
                if($request->start_date!='')
                {
                    $where .= " and  date(ip_skips.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if($request->end_date!='')
                {

                    $where .= " and  date(ip_skips.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }

            }

            $array['ip_skip'] = ip_skip::where('user_id',Auth::user()->id)->whereRaw($where)->get();
            // dd($user);
            return view('user.ip_skip.list',$array);
        }
    }

    public function add_ip_skip_page(){

        if(Auth::check()){
            return view('user.ip_skip.create');
        }
    }

    
    public function downloadip_skipPdf(Request $request){

        if(Auth::check()){
                //dd($request->all());
                $id = $request->checkbox;
            if ($id != null) {
                $array['ip_skip'] = ip_skip::whereIn('id',$id )->get();
            $pdf = PDF::loadView('user.ip_skip.ip_skipPdf', $array);
        
            return $pdf->download('ip_skip.pdf');
            } else {
                return back();
            }
                 
        }
    }

    public function add_ip_skip(Request $request){

        ///dd($request->all());

        if(Auth::check()){
            
            if ($request->id !='') {

                ip_skip::where('id',$request->id)->update([
                    'ip' => $request->ip,
                    'user_id' => Auth::user()->id,
                    'status' => $request->status
                ]); 

                
                $notification = array(
                    'messege'=>'IP skip Updated successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);
            } else {


                ip_skip::create([
                    'ip' => $request->ip,
                    'user_id' => Auth::user()->id,
                    'status' => $request->status
                ]);

                $notification = array(
                    'messege'=>'IP skip Added Successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);

            }
            


        }
    }

    
    public function edit_ip_skip($id){

        if(Auth::check()){
            $ip_skip = ip_skip::where('id',$id)->first();
            return view('user.ip_skip.create',compact('ip_skip','id'));
        }
    }

    public function delete_ip_skip($id){

        if(Auth::check()){
            
            $ip_skip = ip_skip::where('id',$id)->delete();

            $notification = array(
                'messege'=>'IP skip Deleted Successfully',
                'alert-type'=>'error'
            );
            return back()->with($notification);
            
        }
    }

    public function dashboard_visit($id){

        if(Auth::check()){
            
            $user = User::where('id',$id)->first();
            Auth::login($user);

            return redirect('admin/dashboard');
            
        }
    }

    //---------------------------------- Skip Ip ------------------------------------



    
    public function view_qr(Request $request){

        if(Auth::check()){
            
 
            return view('admin/view_qr');
            
        }
    }

    public function print_qr_code(Request $request){

        if(Auth::check()){

            return view('admin/print_qr_code');
            
        }
    }
    public function showQRCode(Request $request){

      // Generate a simple QR code with the given data
      $qrCode = QrCode::format('png')->size(300)->generate('Your QR Code Data');

      // Return the image as a response
      return response($qrCode)->header('Content-Type', 'image/png');
  

    }

    public function generatePDF()
    {
            
        $pdf = PDF::loadView('admin.my_qr_code');
        
        return $pdf->download('MyQRCode.pdf');
    }
    public function spin_pi_clear(Request $request)
    {
        if ($request->delete_conformation == 'Delete') {
            // Fetch all Camping records created by the authenticated user
            $CampingRecords = Camping::where('created_by', Auth::user()->id)->get(); // Use `get()` instead of `all()`

            if ($CampingRecords->isNotEmpty()) {
                // Loop through each camping record and delete related SpinnerFormAccess entries
                foreach ($CampingRecords as $Camping) {
                    SpinnerFormAccess::where('campaign_id', $Camping->id)->delete();
                }

                $notification = array(
                    'messege' => 'Deleted successfully',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            } else {
                $notification = array(
                    'messege' => 'No campaign found',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        } else {
            $notification = array(
                'messege' => 'Please type Delete',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }


    public function change_spin_mode(Request $request){
  
        if(Auth::check()){
            
            $id = Auth::user()->id;
 
            $user = User::find($id);

            if ($request->spin_mode == 'on' || $request->spin_mode == '2') {
                $user->default_spinn = '2';
            } else {
                $user->default_spinn = '1';
            }
            
            $user->save();

            $notification = array(
                'messege'=>'Customer QR Flow Mode updated successfully',
                'alert-type'=>'success'
            );
            return back()->with($notification);

        }
    }

}
