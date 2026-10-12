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

            $presentDate = date('Y-m-d');
            
            $query = Camping::with(['user', 'spinners'])->withCount(['spinners', 'spinnerForms']);

            // If user is a store/client, restrict to their own campaigns
            if (Auth::user()->type == 'user') {
                $query->where('campings.created_by', Auth::user()->id);
            }

            // Expiry condition: end_date in the past
            $query->whereDate('campings.end_date', '<', $presentDate);

            // Filters
            $start_date = $request->start_date ?? '';
            $end_date = $request->end_date ?? '';
            $store_id = $request->store_id ?? '';
            $search = $request->search ?? '';
            $status_filter = $request->status_filter ?? 'all';

            if(!empty($start_date)){
                $query->whereDate('campings.start_date', '>=', $start_date);
            }
            if(!empty($end_date)){
                $query->whereDate('campings.end_date', '<=', $end_date);
            }
            if(!empty($store_id)){
                $query->where('campings.created_by', $store_id);
            }
            if($status_filter != 'all' && !empty($status_filter)){
                $query->where('campings.status', $status_filter);
            }
            if(!empty($search)){
                $query->where(function($q) use ($search) {
                    $q->where('campings.campaign_name', 'like', "%{$search}%")
                      ->orWhere('campings.title', 'like', "%{$search}%")
                      ->orWhere('campings.sub_title', 'like', "%{$search}%")
                      ->orWhereHas('user', function($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('phone', 'like', "%{$search}%");
                      });
                });
            }

            $camping = $query->orderBy('campings.end_date', 'desc')->get();

            // Calculate comprehensive KPIs & analytics across all expired campaigns
            $totalExpired = $camping->count();
            $totalLeads = $camping->sum('spinner_forms_count');
            $totalQuota = $camping->sum('total_form');
            $totalSpinsAllocated = $camping->sum('number_of_total_spinn');
            $totalSlicesConfigured = $camping->sum('spinners_count');
            $uniqueStoresCount = $camping->pluck('created_by')->unique()->count();

            // Expired in last 30 days
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            $recentlyExpired = $camping->filter(function($c) use ($thirtyDaysAgo) {
                return $c->end_date >= $thirtyDaysAgo;
            })->count();

            // All stores for admin dropdown filter
            $allStores = Auth::user()->type == 'admin'
                ? User::where('type', 'user')->select('id', 'name', 'email')->orderBy('name')->get()
                : collect();

            return view('user.camping.expired_camping_list', compact(
                'camping', 'totalExpired', 'totalLeads', 'totalQuota', 'totalSpinsAllocated',
                'totalSlicesConfigured', 'uniqueStoresCount', 'recentlyExpired',
                'start_date', 'end_date', 'store_id', 'search', 'status_filter', 'allStores'
            ));
        }

        return redirect('/login');
    }

    public function add_camping_page(){

        if(Auth::check()){
            return view('user.camping.create');
        }
    }

    
    public function downloadCampaignPdf(Request $request){

        if(Auth::check()){
            $id = $request->checkbox;
            if ($id != null) {
                if (Auth::user()->type == 'admin') {
                    $array['camping'] = Camping::whereIn('id', $id)->get();
                } else {
                    $array['camping'] = Camping::whereIn('id', $id)->where('created_by', Auth::user()->id)->get();
                }
                $pdf = PDF::loadView('user.camping.campingPdf', $array);
            
                return $pdf->download('campaign.pdf');
            } else {
                return back();
            }
        }

        return redirect('/login');
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
            $user_id = Auth::user()->id;

            $spinsCount = Spinner::where('camping_id', $id)->count();
            if ($spinsCount > 0) {
                $notification = array(
                    'messege' => "Cannot delete campaign: It has {$spinsCount} prize spin(s) configured. Please delete the spins first.",
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
            
            $camping = Camping::where('id',$id)->delete();

            $notification = array(
                'messege'=>'Campaign Deleted Successfully',
                'alert-type'=>'success'
            );
            return back()->with($notification);
            
        }
    }

    public function set_single_active_campaign(Request $request){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $campaign_id = $request->campaign_id;

            $target = Camping::where('id', $campaign_id)->where('created_by', $user_id)->first();
            if(!$target){
                return response()->json(['status' => false, 'message' => 'Campaign not found or access denied.'], 404);
            }

            // At a time, only 1 campaign can be active: Deactivate all other campaigns of this user
            Camping::where('created_by', $user_id)->update(['status' => 'inactive']);

            // Set chosen campaign as active
            $target->status = 'active';
            $target->save();

            return response()->json([
                'status' => true,
                'message' => 'Campaign "' . $target->campaign_name . '" is now the only active campaign!',
                'active_id' => $target->id,
                'active_name' => $target->campaign_name
            ]);
        }
        return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
    }
}
