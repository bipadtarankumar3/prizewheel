<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;

use Hash;
use Session;
use App\Models\User;
use App\Models\Spinner;
use App\Models\SpinnerForm;
use App\Models\BikeModel;
use App\Models\Camping;
use Illuminate\Support\Facades\Auth;

use Response;
use PDF;

class SpinnerController extends Controller
{
    
    public function spinner_list(Request $request){

        if(Auth::check()){

            $where = '1=1';
            $user_id = Auth::user()->id;

            if(isset($request))
            {
                if(!empty($request->start_date))
                {
                    $where .= " and  date(spinners.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if(!empty($request->end_date))
                {
                    $where .= " and  date(spinners.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }
            }

            // Optional direct filter by campaign_id
            $filterCampingId = $request->campaign_id ?? null;
            if(!empty($filterCampingId)){
                $where .= " and spinners.camping_id = " . intval($filterCampingId);
                $array['filterCampingId'] = $filterCampingId;
            }

            $array['Spinner'] = Spinner::select('spinners.*','campings.campaign_name as c_name','campings.title as c_title')
            ->leftJoin('campings','campings.id','spinners.camping_id')
            ->where('spinners.created_by', $user_id)
            ->whereRaw($where)
            ->orderBy('id','desc')
            ->get();

            // Paginated campaigns - 6 per page with pagination
            $campings = Camping::where('created_by', $user_id)
                ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
                ->orderBy('id', 'desc')
                ->paginate(6);

            foreach ($campings as $camp) {
                $cSpinners = Spinner::where('camping_id', $camp->id)->where('created_by', $user_id)->get();
                $camp->spinners_count = $cSpinners->count();
                $camp->active_spinners_count = $cSpinners->where('status', 'active')->count();
                $camp->total_quantity = $cSpinners->sum('value');
                $camp->total_forms_joined = SpinnerForm::where('camping_id', $camp->id)->count();
            }

            $array['campings'] = $campings;

            // Global metrics and counts (Enforce strictly 1 active campaign)
            $allUserCampings = Camping::where('created_by', $user_id)->get();
            $allCampIds = $allUserCampings->pluck('id')->toArray();
            $allUserSpinners = Spinner::where('created_by', $user_id)->get();

            $allActive = $allUserCampings->where('status', 'active');
            if ($allActive->count() > 1) {
                // Keep only the single latest active campaign, deactivate all others
                $activeCamp = $allActive->sortByDesc('id')->first();
                Camping::where('created_by', $user_id)->where('id', '!=', $activeCamp->id)->update(['status' => 'inactive']);
                foreach ($campings as $camp) {
                    $camp->status = ($camp->id == $activeCamp->id) ? 'active' : 'inactive';
                }
            } else {
                $activeCamp = $allActive->first();
            }

            $array['totalCampaignsCount'] = $allUserCampings->count();
            $array['activeCampaignsCount'] = $activeCamp ? 1 : 0;
            $array['activeCampaign'] = $activeCamp;
            $array['totalSpinnersCount'] = $allUserSpinners->count();
            $array['totalStockQty'] = $allUserSpinners->sum('value');
            $array['totalFormsCount'] = SpinnerForm::whereIn('camping_id', $allCampIds)->count();

            return view('user.spinner.list', $array);
        }
    }

    
    
    public function downloadSpinnerPdf(Request $request){

        if(Auth::check()){
                //dd($request->all());
                $id = $request->checkbox;
            if ($id != null) {

                $array['Spinner'] = Spinner::select('spinners.*','campings.campaign_name as c_name','campings.title as c_title')
                    ->leftJoin('campings','campings.id','spinners.camping_id')
                    ->whereIn('spinners.id',$id )
                    ->where('spinners.created_by',Auth::user()->id)
                    ->get();
                $pdf = PDF::loadView('user.spinner.spinnerPdf', $array);
        
            return $pdf->download('spinner.pdf');
            } else {
                return back();
            }
                  
        }
    }


    public function add_spinner_page(){

        if(Auth::check()){
            $camping = Camping::where('created_by',Auth::user()->id)->get();
            return view('user.spinner.create',compact('camping'));
        }
    }

    public function spinner_form(Request $request){

        if(Auth::check()){
            $camping = Camping::where('created_by',Auth::user()->id)->get();
            $selected_camping_id = $request->camping_id ?? '';
            return view('user.spinner.form',compact('camping', 'selected_camping_id'));
        }
    }

    public function add_spinner(Request $request){

        //dd($request->all());

        if(Auth::check()){
            
            if ($request->id !='') {

                $spinner = Spinner::find($request->id);

                if ($spinner) {
                    // Handle file upload if provided
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $name = time() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('upload/');
                        $file->move($destinationPath, $name);
                        $spinner->image = URL('upload/' . $name); // Update image only if file is uploaded
                    }
                
                    // Update only if fields are provided
                    if ($request->name !== null && $request->name !== '') {
                        $spinner->name = $request->name;
                    }
                    if (isset($request->value) && $request->value !== '') { // Accepts 0 but skips empty values
                        $spinner->value = $request->value;
                    }
                    if (isset($request->chances) && $request->chances !== '') { // Accepts 0 but skips empty values
                        $spinner->chances = $request->chances;
                    }
                    if ($request->color !== null && $request->color !== '') {
                        $spinner->color = $request->color;
                    }
                    if (isset($request->skip) && $request->skip !== '') { // Accepts 0 but skips empty values
                        $spinner->skip = $request->skip;
                    }
                    if ($request->camping_id !== null && $request->camping_id !== '') {
                        $spinner->camping_id = $request->camping_id;
                    }
                    if (isset($request->status) && $request->status !== '') { // Accepts 0 but skips empty values
                        $spinner->status = $request->status;
                    }
                
                    // Always set created_by to the current user
                    $spinner->created_by = Auth::user()->id;
                
                    // Save changes to the spinner
                    $spinner->save();
                
                    // Update the total spinner value in the Camping table
                    $TotalSpinner = Spinner::where('camping_id', $request->camping_id)->sum('value');
                    Camping::where('id', $request->camping_id)->update(['total_form' => $TotalSpinner]);
                
                    // Return success notification
                    return Response::json([
                        'message' => 'Spinner updated successfully',
                        'alert-type' => 'success',
                    ]);
                } else {
                    // Spinner not found
                    return Response::json([
                        'message' => 'Spinner not found',
                        'alert-type' => 'error',
                    ]);
                }

            } else {

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

                Spinner::create([
                    'name' => $request->name,
                    'image' => $document_link,
                    'value' => $request->value,
                    'chances' => $request->chances,
                    'color' => $request->color,
                    'skip' => $request->skip,
                    'camping_id' => $request->camping_id,
                    'created_by' => Auth::user()->id,
                    'status' => $request->status
                ]);

                $TotalSpinner = Spinner::where('camping_id',$request->camping_id)->sum('value');
                $CampingUpdate = Camping::where('id',$request->camping_id)->update(['total_form'=>$TotalSpinner]);

                $notification = array(
                    'messege'=>'Spinner inserted successfully',
                    'alert-type'=>'success'
                );
                return Response::json($notification);

            }
            


        }
    }

    
    public function edit_spinner($id){

        if(Auth::check()){
            $Spinner = Spinner::where('id',$id)->first();
            $camping = Camping::where('created_by',Auth::user()->id)->where('status','active')->get();
            return view('user.spinner.form',compact('Spinner','id','camping'));
        }
    }

    public function delete_spinner($id){

        if(Auth::check()){
            
            $Spinner = Spinner::where('id',$id)->delete();

            $notification = array(
                'messege'=>'Spinner Deleted Successfully',
                'alert-type'=>'error'
            );
            return back()->with($notification);
            
        }
    }



    // Spinner form ------------------------
    public function spinner_form_camping_list(Request $request){

        if(Auth::check()){

            $query = Camping::with(['user', 'spinners'])->withCount(['spinners', 'spinnerForms']);

            // If store user, restrict to their own campaigns
            if (Auth::user()->type == 'user') {
                $query->where('campings.created_by', Auth::user()->id);
            }

            // Filters
            $start_date = $request->start_date ?? '';
            $end_date = $request->end_date ?? '';
            $store_id = $request->store_id ?? '';
            $search = $request->search ?? '';
            $status_filter = $request->status_filter ?? 'all'; // all, active, expired

            $today = date('Y-m-d');

            if(!empty($start_date)){
                $query->whereDate('campings.start_date', '>=', $start_date);
            }
            if(!empty($end_date)){
                $query->whereDate('campings.end_date', '<=', $end_date);
            }
            if(!empty($store_id)){
                $query->where('campings.created_by', $store_id);
            }

            if($status_filter == 'active'){
                $query->where('campings.status', 'active')->whereDate('campings.end_date', '>=', $today);
            } elseif($status_filter == 'expired'){
                $query->where(function($q) use ($today) {
                    $q->where('campings.status', 'inactive')->orWhereDate('campings.end_date', '<', $today);
                });
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

            $camping = $query->orderBy('campings.id', 'desc')->get();

            // Total KPIs across displayed campaigns
            $totalCampaigns = $camping->count();
            $totalLeads = $camping->sum('spinner_forms_count');
            $totalQuota = $camping->sum('total_form');
            $totalSpinsAllocated = $camping->sum('number_of_total_spinn');
            $totalSlicesConfigured = $camping->sum('spinners_count');
            $activeCampaignsCount = $camping->filter(function($c) use ($today) {
                return $c->status == 'active' && $c->end_date >= $today;
            })->count();
            $expiredCampaignsCount = $camping->filter(function($c) use ($today) {
                return $c->status == 'inactive' || $c->end_date < $today;
            })->count();

            // Telemetry counts for leads verification
            $campIds = $camping->pluck('id')->toArray();
            $totalScreenshots = SpinnerForm::whereIn('camping_id', $campIds)
                ->whereNotNull('schreenshot')
                ->where('schreenshot', '!=', '')
                ->count();
            $totalPrizesAwarded = SpinnerForm::whereIn('camping_id', $campIds)
                ->whereNotNull('spinner_id')
                ->count();

            $uniqueStoresCount = $camping->pluck('created_by')->unique()->count();

            // Store list for Super Admin dropdown
            $allStores = Auth::user()->type == 'admin'
                ? User::where('type', 'user')->select('id', 'name', 'email')->orderBy('name')->get()
                : collect();

            return view('user.spinner_form.list', compact(
                'camping', 'totalCampaigns', 'totalLeads', 'totalQuota', 'totalSpinsAllocated',
                'totalSlicesConfigured', 'activeCampaignsCount', 'expiredCampaignsCount',
                'totalScreenshots', 'totalPrizesAwarded', 'uniqueStoresCount',
                'start_date', 'end_date', 'store_id', 'search', 'status_filter', 'allStores'
            ));
        }

        return redirect('/login');
    }

    public function downloadFormCampingPdf(Request $request){

        if(Auth::check()){
            $id = $request->checkbox;
            if ($id != null) {
                if (Auth::user()->type == 'admin') {
                    $array['camping'] = Camping::whereIn('id', $id)->get();
                } else {
                    $array['camping'] = Camping::where('created_by', Auth::user()->id)->whereIn('id', $id)->get();
                }
                $pdf = PDF::loadView('user.spinner_form.campingFormPdf', $array);
                return $pdf->download('campingFormPdf.pdf');
            } else {
                return back();
            }
        }

        return redirect('/login');
    }

    public function spinner_form_list(Request $request, $id){

        if(Auth::check()){

            $where = '1=1';

            if(isset($request))
            {
                if(!empty($request->start_date))
                {
                    $where .= " and  date(spinner_forms.created_at) >=  '$request->start_date'" ;
                    $array['start_date'] = $request->start_date;
                }
                if(!empty($request->end_date))
                {
                    $where .= " and  date(spinner_forms.created_at) <=  '$request->end_date'" ;
                    $array['end_date'] = $request->end_date ;
                }
                if(!empty($request->search))
                {
                    $search = addslashes($request->search);
                    $where .= " and (spinner_forms.name like '%{$search}%' or spinner_forms.phone like '%{$search}%' or spinner_forms.email like '%{$search}%' or spinner_forms.whatsapp_number like '%{$search}%')" ;
                    $array['search'] = $request->search;
                }
            }

            $array['id'] = $id;
            $array['camping'] = Camping::with('user')->find($id);

            $array['SpinnerForm'] = SpinnerForm::
            select(
                'spinner_forms.id',
                'spinner_forms.name',
                'spinner_forms.email',
                'spinner_forms.whatsapp_number',
                'spinner_forms.phone',
                'spinner_forms.address',
                'spinner_forms.schreenshot',
                'spinner_forms.spinner_id',
                'spinner_forms.camping_id',
                'spinner_forms.bike_model_id',
                'spinner_forms.mac_address',
                'spinner_forms.status',
                'spinner_forms.created_at',
                'bike_models.name as bike_name',
                'spinners.name as spinner_name',
                )
            ->leftJoin('bike_models','bike_models.id','spinner_forms.bike_model_id')
            ->leftJoin('spinners','spinners.id','spinner_forms.spinner_id')
            ->where('spinner_forms.camping_id',$id)
            ->whereRaw($where)
            ->orderBy('spinner_forms.id','desc')
            ->get();

            // Computed KPI metrics
            $array['totalLeads'] = $array['SpinnerForm']->count();
            $array['totalWinners'] = $array['SpinnerForm']->filter(function($i) { return !empty($i->spinner_name); })->count();
            $array['totalProofs'] = $array['SpinnerForm']->filter(function($i) { return !empty($i->schreenshot); })->count();
            $array['totalWhatsapp'] = $array['SpinnerForm']->filter(function($i) { return !empty($i->whatsapp_number); })->count();

            return view('user.spinner_form.spinner_form_list',$array);
        }
    }

            
    public function downloadSpinnerFormListPdf(Request $request){

        if(Auth::check()){
                //dd($request->all());
                $id = $request->checkbox;
                $campaign_id = $request->campaign_id;
            if ($id != null) {
                $array['SpinnerForm'] = SpinnerForm::
                    select(
                        'spinner_forms.id',
                        'spinner_forms.name',
                        'spinner_forms.email',
                        'spinner_forms.whatsapp_number',
                        'spinner_forms.phone',
                        'spinner_forms.address',
                        'spinner_forms.schreenshot',
                        'spinner_forms.spinner_id',
                        'spinner_forms.camping_id',
                        'spinner_forms.bike_model_id',
                        'spinner_forms.mac_address',
                        'spinner_forms.status',
                        'spinner_forms.created_at',
                        'bike_models.name as bike_name',
                        'spinners.name as spinner_name',
                        )
                    ->leftJoin('bike_models','bike_models.id','spinner_forms.bike_model_id')
                    ->leftJoin('spinners','spinners.id','spinner_forms.spinner_id')
                    ->where('spinner_forms.camping_id',$campaign_id)
                    ->whereIn('spinner_forms.id',$id)
                    ->get();

                    $customPaper = array(0,0,720,1440);

                    $array['camping'] = Camping::where('id',$campaign_id)->first();
            $pdf = PDF::loadView('user.spinner_form.spinnerFormListPdf', $array)->setPaper($customPaper,'portrait');
        
            return $pdf->download('spinnerFormList.pdf');
            } else {
                return back();
            }
                  
        }
    }


    public function delete_spinner_form_list($id){

        if(Auth::check()){
            $SpinnerForm = SpinnerForm::where('id',$id)->delete();
            
            $notification = array(
                'messege'=>'Spinner Form List Deleted Successfully',
                'alert-type'=>'error'
            );
            return back()->with($notification);
        }
    }

    public function spinner_form_details($id){

        if(Auth::check()){

            $where = "spinner_forms.id='$id'";
            $array['SpinnerForm'] = SpinnerForm::
            select(
                'spinner_forms.id',
                'spinner_forms.name',
                'spinner_forms.email',
                'spinner_forms.whatsapp_number',
                'spinner_forms.phone',
                'spinner_forms.address',
                'spinner_forms.schreenshot',
                'spinner_forms.spinner_id',
                'spinner_forms.camping_id',
                'spinner_forms.bike_model_id',
                'spinner_forms.mac_address',
                'spinner_forms.status',
                'spinner_forms.created_at',
                'bike_models.name as bike_name',
                'spinners.name as spinner_name',
                )
            ->leftJoin('bike_models','bike_models.id','spinner_forms.bike_model_id')
            ->leftJoin('spinners','spinners.id','spinner_forms.spinner_id')
            ->whereRaw($where)
            ->first();
            
            return view('user.spinner_form.spinner_form_details',$array);
        }
    }

}
