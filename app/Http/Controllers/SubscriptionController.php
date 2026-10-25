<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Plan;
use App\Models\Payment;
use App\Mail\PaymentSuccessUserMail;
use App\Mail\PaymentReceivedAdminMail;
use App\Mail\SubscriptionExpiredMail;
use GuzzleHttp\Client;

class SubscriptionController extends Controller
{
    /**
     * Configure dynamic SMTP before sending emails
     */
    protected function setupMailConfig()
    {
        try {
            $mail = DB::table('mail_configures')->first();
            if ($mail) {
                $config = [
                    'driver' => 'smtp',
                    'host' => $mail->mail_host,
                    'port' => $mail->mail_port,
                    'from' => ['address' => $mail->mail_from_address, 'name' => $mail->mail_from_name ?: 'PrizeWheel'],
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
                ];
                Config::set('mail', $config);
            }
        } catch (\Throwable $e) {
            \Log::error('SMTP Config setup failed: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     * 1. ADMIN: PLANS MANAGEMENT (Create, Edit, Delete, Toggle)
     * ========================================================================= */

    public function plans_index(Request $request)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            return redirect('admin/dashboard');
        }

        $plans = Plan::where('admin_id', $admin->id)
            ->withCount('users')
            ->orderBy('id', 'desc')
            ->get();

        $totalSubscribedUsers = User::where('admin_id', $admin->id)->whereNotNull('plan_id')->count();

        return view('admin.plans.index', compact('plans', 'admin', 'totalSubscribedUsers'));
    }

    public function plan_store(Request $request)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'spin_rounds_limit' => 'required|integer',
            'campaigns_limit' => 'required|integer',
        ]);

        $plan = Plan::create([
            'admin_id' => $admin->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'spin_rounds_limit' => $request->spin_rounds_limit,
            'campaigns_limit' => $request->campaigns_limit,
            'has_ip_skip' => $request->has('has_ip_skip') ? 1 : 0,
            'has_whatsapp' => $request->has('has_whatsapp') ? 1 : 0,
            'has_custom_branding' => $request->has('has_custom_branding') ? 1 : 0,
            'features_list' => $request->features_list,
            'status' => $request->get('status', 'active'),
            'is_popular' => $request->has('is_popular') ? 1 : 0,
        ]);

        return redirect('admin/plans')->with([
            'messege' => 'Subscription Plan "' . $plan->name . '" created successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function plan_update(Request $request, $id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $plan = Plan::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'spin_rounds_limit' => 'required|integer',
            'campaigns_limit' => 'required|integer',
        ]);

        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'spin_rounds_limit' => $request->spin_rounds_limit,
            'campaigns_limit' => $request->campaigns_limit,
            'has_ip_skip' => $request->has('has_ip_skip') ? 1 : 0,
            'has_whatsapp' => $request->has('has_whatsapp') ? 1 : 0,
            'has_custom_branding' => $request->has('has_custom_branding') ? 1 : 0,
            'features_list' => $request->features_list,
            'status' => $request->get('status', 'active'),
            'is_popular' => $request->has('is_popular') ? 1 : 0,
        ]);

        return redirect('admin/plans')->with([
            'messege' => 'Plan updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function plan_delete($id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $plan = Plan::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
        $plan->delete();

        return redirect('admin/plans')->with([
            'messege' => 'Plan deleted successfully.',
            'alert-type' => 'warning'
        ]);
    }

    public function plan_toggle_status($id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $plan = Plan::where('id', $id)->where('admin_id', $admin->id)->firstOrFail();
        $plan->status = ($plan->status === 'active') ? 'inactive' : 'active';
        $plan->save();

        return response()->json([
            'success' => true,
            'status' => $plan->status,
            'message' => 'Plan status changed to ' . ucfirst($plan->status)
        ]);
    }

    /* =========================================================================
     * 2. ADMIN: RAZORPAY INDIVIDUAL CREDENTIALS
     * ========================================================================= */

    public function razorpay_settings_page()
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            return redirect('admin/dashboard');
        }

        return view('admin.plans.razorpay_settings', compact('admin'));
    }

    public function razorpay_settings_update(Request $request)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $request->validate([
            'razorpay_key_id' => 'nullable|string|max:255',
            'razorpay_key_secret' => 'nullable|string|max:255',
        ]);

        $admin->razorpay_key_id = trim($request->razorpay_key_id);
        if ($request->filled('razorpay_key_secret')) {
            $admin->razorpay_key_secret = trim($request->razorpay_key_secret);
        }
        $admin->razorpay_enabled = $request->has('razorpay_enabled') ? 1 : 0;
        $admin->save();

        return redirect('admin/razorpay_settings')->with([
            'messege' => 'Razorpay payment gateway credentials updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /* =========================================================================
     * 3. ADMIN: PAYMENTS OVERSIGHT & DETAILED ANALYTICS WITH FILTERS
     * ========================================================================= */

    public function admin_payments_index(Request $request)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            return redirect('admin/dashboard');
        }

        $query = Payment::where('admin_id', $admin->id)->with(['user', 'plan']);

        // Filter by Date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by User
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by Plan
        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by keyword (payment id, order id, store name)
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function($q) use ($s) {
                $q->where('payment_unique_id', 'like', "%$s%")
                  ->orWhere('razorpay_payment_id', 'like', "%$s%")
                  ->orWhere('plan_name', 'like', "%$s%")
                  ->orWhereHas('user', function($uq) use ($s) {
                      $uq->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%");
                  });
            });
        }

        $payments = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();

        // Stat calculations
        $totalRevenue = Payment::where('admin_id', $admin->id)->where('status', 'success')->sum('amount');
        $thisMonthRevenue = Payment::where('admin_id', $admin->id)->where('status', 'success')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('amount');
        $totalCount = Payment::where('admin_id', $admin->id)->count();
        $successCount = Payment::where('admin_id', $admin->id)->where('status', 'success')->count();
        $pendingCount = Payment::where('admin_id', $admin->id)->where('status', 'pending')->count();

        // Dropdown lists for filters
        $usersList = User::where('admin_id', $admin->id)->orderBy('name', 'asc')->get(['id', 'name', 'email']);
        $plansList = Plan::where('admin_id', $admin->id)->orderBy('name', 'asc')->get(['id', 'name']);

        return view('admin.plans.payments', compact(
            'payments', 'totalRevenue', 'thisMonthRevenue', 'totalCount',
            'successCount', 'pendingCount', 'usersList', 'plansList'
        ));
    }

    /* =========================================================================
     * 4. ADMIN: EXTRA ACCESS OVERRIDE (ABOVE PLANNING)
     * ========================================================================= */

    public function grant_extra_access(Request $request, $userId)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $user = User::where('id', $userId)->where('admin_id', $admin->id)->firstOrFail();

        $request->validate([
            'new_expiry_date' => 'nullable|date',
            'extra_spin_rounds' => 'nullable|integer|min:0',
            'extra_campaigns_limit' => 'nullable|integer|min:0',
        ]);

        if ($request->filled('new_expiry_date')) {
            $user->expiry_date = $request->new_expiry_date;
        }

        if ($request->has('extra_spin_rounds')) {
            $user->extra_spin_rounds = (int)$request->extra_spin_rounds;
        }

        if ($request->has('extra_campaigns_limit')) {
            $user->extra_campaigns_limit = (int)$request->extra_campaigns_limit;
        }

        // Custom feature access overrides
        $customAccess = [
            'allow_ip_skip' => $request->has('override_ip_skip') ? 1 : 0,
            'allow_whatsapp' => $request->has('override_whatsapp') ? 1 : 0,
            'allow_branding' => $request->has('override_branding') ? 1 : 0,
            'admin_note' => $request->get('override_note', ''),
        ];
        $user->custom_access_override = json_encode($customAccess);
        $user->save();

        return back()->with([
            'messege' => 'Custom access & limits successfully updated for ' . $user->name . '!',
            'alert-type' => 'success'
        ]);
    }

    /* =========================================================================
     * 5. ADMIN: TRIGGER EXPIRED SUBSCRIPTION EMAIL MANUALLY
     * ========================================================================= */

    public function send_expiry_alert($userId)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403);
        }

        $user = User::where('id', $userId)->where('admin_id', $admin->id)->firstOrFail();

        if (empty($user->email)) {
            return back()->with([
                'messege' => 'User does not have a registered email address.',
                'alert-type' => 'error'
            ]);
        }

        try {
            $this->setupMailConfig();
            Mail::to($user->email)->send(new SubscriptionExpiredMail($user));

            return back()->with([
                'messege' => 'Subscription expiry alert sent successfully to ' . $user->email . '.',
                'alert-type' => 'success'
            ]);
        } catch (\Throwable $e) {
            return back()->with([
                'messege' => 'Failed to send email: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /* =========================================================================
     * 6. USER: BILLING & SUBSCRIPTION DASHBOARD
     * ========================================================================= */

    public function user_billing_page()
    {
        $user = Auth::user();
        if ($user->type === 'admin') {
            return redirect('admin/plans');
        }

        // Get plans from the user's admin
        $adminId = $user->admin_id;
        if (!$adminId) {
            $firstAdmin = User::where('type', 'admin')->first();
            $adminId = $firstAdmin ? $firstAdmin->id : 1;
        }

        $plans = Plan::where('admin_id', $adminId)
            ->where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();

        // If no plans found under their direct admin, fall back to any active plans
        if ($plans->isEmpty()) {
            $plans = Plan::where('status', 'active')->orderBy('price', 'asc')->get();
        }

        $currentPlan = $user->plan_id ? Plan::find($user->plan_id) : null;
        $paymentsHistory = Payment::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $totalPaymentsCount = $paymentsHistory->count();
        $successfulPaymentsCount = $paymentsHistory->where('status', 'success')->count();
        $totalAmountSpent = $paymentsHistory->where('status', 'success')->sum('amount');
        $pendingPaymentsCount = $paymentsHistory->where('status', 'pending')->count();

        $adminRazorpayConfigured = false;
        $adminUser = User::find($adminId);
        if ($adminUser && !empty($adminUser->razorpay_key_id) && !empty($adminUser->razorpay_key_secret) && $adminUser->razorpay_enabled) {
            $adminRazorpayConfigured = true;
        }

        return view('admin.plans.user_billing', compact(
            'user', 'plans', 'currentPlan', 'paymentsHistory',
            'adminUser', 'adminRazorpayConfigured',
            'totalPaymentsCount', 'successfulPaymentsCount',
            'totalAmountSpent', 'pendingPaymentsCount'
        ));
    }

    /* =========================================================================
     * 7. USER: CREATE RAZORPAY ORDER
     * ========================================================================= */

    public function create_razorpay_order(Request $request)
    {
        $user = Auth::user();
        if ($user->type === 'admin') {
            return response()->json(['success' => false, 'message' => 'Admins cannot purchase plans.']);
        }

        $request->validate([
            'plan_id' => 'required|integer|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        // Determine admin credentials
        $admin = $user->admin ?: User::find($plan->admin_id);
        if (!$admin || empty($admin->razorpay_key_id) || empty($admin->razorpay_key_secret)) {
            // Check super admin fallback
            $superAdmin = User::where('type', 'admin')->whereNotNull('razorpay_key_id')->where('razorpay_enabled', 1)->first();
            if ($superAdmin) {
                $admin = $superAdmin;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Online payment is currently unavailable. Please contact your administrator to configure payment details.'
                ], 422);
            }
        }

        $amountInPaise = (int)round($plan->price * 100);
        $orderReceipt = 'RCPT_' . strtoupper(Str::random(10));

        try {
            $client = new Client([
                'base_uri' => 'https://api.razorpay.com/v1/',
                'auth' => [$admin->razorpay_key_id, $admin->razorpay_key_secret],
                'timeout' => 15,
            ]);

            $response = $client->post('orders', [
                'json' => [
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'receipt' => $orderReceipt,
                    'notes' => [
                        'user_id' => (string)$user->id,
                        'user_email' => (string)$user->email,
                        'plan_id' => (string)$plan->id,
                        'plan_name' => (string)$plan->name,
                        'admin_id' => (string)$admin->id,
                    ]
                ]
            ]);

            $orderData = json_decode($response->getBody()->getContents(), true);

            // Record pending payment
            $payment = Payment::create([
                'payment_unique_id' => $orderReceipt,
                'admin_id' => $admin->id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'amount' => $plan->price,
                'currency' => 'INR',
                'razorpay_order_id' => $orderData['id'],
                'status' => 'pending',
                'billing_details' => json_encode([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]),
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $orderData['id'],
                'razorpay_key' => $admin->razorpay_key_id,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'plan_name' => $plan->name,
                'plan_description' => $plan->duration_days . ' Days Access - Prize Wheel Subscription',
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone ?: '',
                'payment_id' => $payment->id,
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            \Log::error('Razorpay Order ClientException: ' . $errBody);
            $parsed = json_decode($errBody, true);
            $msg = $parsed['error']['description'] ?? 'Razorpay connection error: ' . $e->getMessage();
            return response()->json(['success' => false, 'message' => $msg], 400);
        } catch (\Throwable $e) {
            \Log::error('Razorpay Order Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to create payment order: ' . $e->getMessage()
            ], 500);
        }
    }

    /* =========================================================================
     * 8. USER: VERIFY RAZORPAY SIGNATURE & ACTIVATE SUBSCRIPTION
     * ========================================================================= */

    public function verify_razorpay_payment(Request $request)
    {
        $user = Auth::user();
        if ($user->type === 'admin') {
            return response()->json(['success' => false, 'message' => 'Admins cannot execute user payment verification.']);
        }

        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'payment_id' => 'required|integer|exists:payments,id',
        ]);

        $payment = Payment::where('id', $request->payment_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $plan = Plan::findOrFail($payment->plan_id);
        $admin = User::findOrFail($payment->admin_id);

        // Security: Verify HMAC-SHA256 signature with Admin's Secret Key
        $expectedSignature = hash_hmac(
            'sha256',
            $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
            $admin->razorpay_key_secret
        );

        if (!hash_equals($expectedSignature, $request->razorpay_signature)) {
            $payment->status = 'failed';
            $payment->notes = 'Signature verification mismatch';
            $payment->save();

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: Invalid Razorpay cryptographic signature.'
            ], 400);
        }

        // Signature is 100% verified! Calculate new subscription expiry date
        $currentExpiry = $user->expiry_date;
        $today = date('Y-m-d');

        if (!empty($currentExpiry) && strtotime($currentExpiry) >= strtotime($today)) {
            // User renewed early: extend from existing expiry date
            $newExpiry = date('Y-m-d', strtotime($currentExpiry . ' +' . $plan->duration_days . ' days'));
        } else {
            // User was expired: extend from today
            $newExpiry = date('Y-m-d', strtotime($today . ' +' . $plan->duration_days . ' days'));
        }

        // Update payment record
        $payment->update([
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
            'status' => 'success',
            'expiry_extended_to' => $newExpiry,
            'notes' => 'Razorpay payment verified successfully.',
        ]);

        // Update user subscription state & limits
        $user->plan_id = $plan->id;
        $user->expiry_date = $newExpiry;
        $user->last_renewed_at = now();
        $user->account_type = 'renew';

        // Add plan spin rounds if limited, or set unlimited
        if ($plan->spin_rounds_limit > 0) {
            $user->spin_whell_round = (int)($user->spin_whell_round ?? 0) + $plan->spin_rounds_limit;
        }

        $user->save();

        // Dispatch Email Notifications (User Receipt + Admin Revenue Alert)
        try {
            $this->setupMailConfig();

            // 1. Send receipt to User
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new PaymentSuccessUserMail($payment, $user, $plan));
            }

            // 2. Send revenue alert to Admin
            if (!empty($admin->email)) {
                Mail::to($admin->email)->send(new PaymentReceivedAdminMail($payment, $user, $plan, $admin));
            }
        } catch (\Throwable $e) {
            \Log::error('Payment notification emails failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment successful! Your account is renewed until ' . date('d M Y', strtotime($newExpiry)) . '.',
            'new_expiry' => date('d M Y', strtotime($newExpiry)),
            'plan_name' => $plan->name,
            'redirect' => url('admin/dashboard'),
        ]);
    }

    /* =========================================================================
     * 9. INVOICE / RECEIPT VIEW
     * ========================================================================= */

    public function invoice_view($paymentId)
    {
        $currentUser = Auth::user();
        $payment = Payment::with(['user', 'plan', 'admin'])->findOrFail($paymentId);

        // Security check: Only the paying user or their admin can view
        if ($currentUser->type !== 'admin' && $payment->user_id !== $currentUser->id) {
            abort(403, 'Unauthorized access to invoice.');
        }

        return view('admin.plans.invoice', compact('payment'));
    }
}
