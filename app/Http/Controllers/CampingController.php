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
use Illuminate\Support\Facades\Auth;
use PDF;

class CampingController extends Controller
{
    public function camping_list(Request $request){

        if(Auth::check()){

            $where = '1=1';
            $user_id = Auth::user()->id;

            if(isset($request))
            {
                if(!empty($request->start_date))
                {
                    $where .= " and  date(campings.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if(!empty($request->end_date))
                {
                    $where .= " and  date(campings.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }
            }

            $campings = Camping::where('created_by', $user_id)->whereRaw($where)->orderBy('id', 'desc')->get();

            foreach ($campings as $camp) {
                $forms = SpinnerForm::where('camping_id', $camp->id)->get();
                $camp->total_joined = $forms->count();
                
                // Detailed data types captured
                $camp->phone_count = $forms->filter(function($f){ return !empty($f->phone) || !empty($f->whatsapp_number); })->count();
                $camp->email_count = $forms->filter(function($f){ return !empty($f->email); })->count();
                $camp->receipt_count = $forms->filter(function($f){ return !empty($f->schreenshot); })->count();
                $camp->address_count = $forms->filter(function($f){ return !empty($f->address); })->count();
                $camp->model_count = $forms->filter(function($f){ return !empty($f->bike_model_id); })->count();
                $camp->unique_devices = $forms->pluck('mac_address')->filter()->unique()->count();
                
                // Prizes & slices data
                $camp->prizes_won_count = $forms->whereNotNull('spinner_id')->count();
                $camp->slices_count = Spinner::where('camping_id', $camp->id)->count();

                // Most won prize
                $prizeCounts = $forms->whereNotNull('spinner_id')->groupBy('spinner_id');
                if ($prizeCounts->count() > 0) {
                    $sortedPrizes = $prizeCounts->sortByDesc(function($grp){ return $grp->count(); });
                    $topGrp = $sortedPrizes->first();
                    if ($topGrp && $topGrp->first()) {
                        $spinnerObj = Spinner::find($topGrp->first()->spinner_id);
                        $camp->top_prize_name = $spinnerObj ? $spinnerObj->name : null;
                        $camp->top_prize_color = $spinnerObj ? ($spinnerObj->color ?: '#ff6b00') : '#ff6b00';
                        $camp->top_prize_count = $topGrp->count();
                    }
                } else {
                    $camp->top_prize_name = null;
                    $camp->top_prize_color = null;
                    $camp->top_prize_count = 0;
                }
            }

            $array['camping'] = $campings;

            // Summary metrics for futuristic stats banner
            $allCampIds = $campings->pluck('id')->toArray();
            $array['totalCampaignsCount'] = $campings->count();
            $array['activeCampaignsCount'] = $campings->where('status', 'active')->count();
            $array['totalParticipantsJoined'] = SpinnerForm::whereIn('camping_id', $allCampIds)->count();
            $array['totalPrizesAwarded'] = SpinnerForm::whereIn('camping_id', $allCampIds)->whereNotNull('spinner_id')->count();
            $array['totalVerifiedReceipts'] = SpinnerForm::whereIn('camping_id', $allCampIds)->whereNotNull('schreenshot')->where('schreenshot', '!=', '')->count();

            return view('user.camping.list', $array);
        }
    }
    public function expired_camping_list(Request $request){

        if(Auth::check()){

            $where = '1=1';

            if(isset($request))
            {
                
                if($request->start_date!='')
                {
                    $where .= " and  date(campings.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if($request->end_date!='')
                {

                    $where .= " and  date(campings.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }

            }

            $presentDate = date('Y-m-d');

            $array['camping'] = Camping::select('campings.*','users.name as user_name')
            ->leftJoin('users','users.id','campings.id')
            ->whereDate('end_date','<',$presentDate)
            ->whereRaw($where)
            ->get();
            // dd($user);
            return view('user.camping.expired_camping_list',$array);
        }
    }

    public function add_camping_page(){

        if(Auth::check()){
            return view('user.camping.create');
        }
    }

    
    public function downloadCampaignPdf(Request $request){

        if(Auth::check()){
                //dd($request->all());
                $id = $request->checkbox;
            if ($id != null) {
                $array['camping'] = Camping::whereIn('id',$id )->where('created_by',Auth::user()->id)->get();
            $pdf = PDF::loadView('user.camping.campingPdf', $array);
        
            return $pdf->download('campaign.pdf');
            } else {
                return back();
            }
                  
        }
    }

    public function add_camping(Request $request){

        ///dd($request->all());

        if(Auth::check()){
            
            if ($request->id !='') {

                Camping::where('id',$request->id)->update([
                    'campaign_name' => $request->campaign_name,
                    'title' => $request->title,
                    'title_status' => $request->title_status,
                    'sub_title' => $request->sub_title,
                    'sub_title_status' => $request->sub_title_status,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'validity_status' => $request->validity_status,
                    // 'total_form' => $request->total_form,
                    'spinner_time' => $request->spinner_time,
                    'number_of_total_spinn' => $request->number_of_total_spinn,
                    'created_by' => Auth::user()->id,
                    'status' => $request->status
                ]); 

                $camping = Camping::where('id',$request->id)->first();

                if ($camping) {

                    if (strtotime($request->end_date) > strtotime($camping->end_date)) {
                        Camping::where('id',$request->id)->update(['mail_send'=>'NO']); 
                    }
                    
                }

                
                $notification = array(
                    'messege'=>'Campaign Updated successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);
            } else {


                Camping::create([
                    'campaign_name' => $request->campaign_name,
                    'title' => $request->title,
                    'title_status' => $request->title_status,
                    'sub_title' => $request->sub_title,
                    'sub_title_status' => $request->sub_title_status,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'validity_status' => $request->validity_status,
                    // 'total_form' => $request->total_form,
                    'spinner_time' => $request->spinner_time,
                    'number_of_total_spinn' => $request->number_of_total_spinn,
                    'created_by' => Auth::user()->id,
                    'status' => $request->status
                ]);

                $notification = array(
                    'messege'=>'Campaign inserted successfully',
                    'alert-type'=>'success'
                );
                return back()->with($notification);

            }
            


        }
    }

    
    public function edit_camping($id){

        if(Auth::check()){
            $camping = Camping::where('id',$id)->first();
            // dd($camping);
            return view('user.camping.create',compact('camping','id'));
        }
    }

    public function delete_camping($id){

        if(Auth::check()){
            
            $camping = Camping::where('id',$id)->delete();

            $notification = array(
                'messege'=>'Campaign Deleted Successfully',
                'alert-type'=>'error'
            );
            return back()->with($notification);
            
        }
    }
}
