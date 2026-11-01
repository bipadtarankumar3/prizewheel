<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Plan;
use App\Models\User;

class CheckUserSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->type === 'user') {
                $isExpired = $user->isExpired();

                // Share status and available plans with all views
                View::share('isUserSubscriptionExpired', $isExpired);

                if ($isExpired) {
                    $adminId = $user->admin_id;
                    if (!$adminId) {
                        $firstAdmin = User::where('type', 'admin')->first();
                        $adminId = $firstAdmin ? $firstAdmin->id : 1;
                    }

                    $adminUser = $user->admin ?: User::find($adminId);
                    if (!$adminUser) {
                        $adminUser = User::where('type', 'admin')->first();
                    }
                    $isOnlinePaymentEnabled = $adminUser && !empty($adminUser->razorpay_key_id) && !empty($adminUser->razorpay_key_secret) && (bool)$adminUser->razorpay_enabled;
                    View::share('isOnlinePaymentEnabled', $isOnlinePaymentEnabled);

                    $availablePlans = Plan::where('admin_id', $adminId)
                        ->where('status', 'active')
                        ->orderBy('price', 'asc')
                        ->get();

                    if ($availablePlans->isEmpty()) {
                        $availablePlans = Plan::where('status', 'active')->orderBy('price', 'asc')->get();
                    }

                    View::share('subscriptionPlansForModal', $availablePlans);
                }
            } else {
                View::share('isUserSubscriptionExpired', false);
            }
        }

        return $next($request);
    }
}
