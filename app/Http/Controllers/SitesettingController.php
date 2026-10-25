<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\User;
use App\Models\sitesetting;
use Illuminate\Support\Facades\Auth;

class SitesettingController extends Controller
{
    /**
     * Settings page for store / admin
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Admin does not have campaigns/spin wheels; only store users configure wheel settings
        if ($user->type == 'admin') {
            return redirect()->route('admin.dashboard')->with([
                'messege' => 'Wheel settings are only configurable by store users.',
                'alert-type' => 'info'
            ]);
        }

        $settings = sitesetting::getAllSettings($user->id);
        $spin_form_timing = $settings['spin_form_timing'] ?? 'after_spin';

        // Check if legacy row with background_music exists
        $legacy_sitesetting = sitesetting::where('user_id', $user->id)
            ->whereNotNull('background_music')
            ->first();

        return view('admin.sitesetting.index', compact('user', 'settings', 'spin_form_timing', 'legacy_sitesetting'));
    }

    /**
     * Backward-compatible route alias
     */
    public function sitesetting(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Save settings (key-value based)
     */
    public function save_settings(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->type == 'admin') {
            return back()->with([
                'messege' => 'Admin cannot set wheel settings.',
                'alert-type' => 'error'
            ]);
        }

        $userId = $user->id;

        // 1. Form timing: before_spin or after_spin
        if ($request->filled('spin_form_timing')) {
            $timing = in_array($request->spin_form_timing, ['before_spin', 'after_spin']) ? $request->spin_form_timing : 'after_spin';
            sitesetting::setSetting($userId, 'spin_form_timing', $timing);
        }

        // 2. Background music upload (optional)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('upload/');
            if (!file_exists($destinationPath)) {
                @mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $name);
            $document_link = URL('upload/' . $name);

            sitesetting::setSetting($userId, 'background_music', $document_link);
            sitesetting::setSetting($userId, 'background_music_status', $request->status ?? 'active');
        } elseif ($request->filled('status')) {
            sitesetting::setSetting($userId, 'background_music_status', $request->status);
        }

        $notification = array(
            'messege' => 'Settings saved successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    /**
     * Backward-compatible alias for add_sitesetting
     */
    public function add_sitesetting(Request $request)
    {
        return $this->save_settings($request);
    }
}
