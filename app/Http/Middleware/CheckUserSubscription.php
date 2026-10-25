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

                    $availablePlans = Plan::where('admin_id', $adminId)
                        ->where('status', 'active')
                        ->orderBy('price', 'asc')
                        ->get();

                    if ($availablePlans->isEmpty()) {
                        $availablePlans = Plan::where('status', 'active')->orderBy('price', 'asc')->get();
                    }

                    View::share('subscriptionPlansForModal', $availablePlans);

                    // Whitelist routes allowed while expired
                    $allowedRoutes = [
                        'admin/billing',
                        'admin/dashboard',
                        'admin/logout',
                        'admin/subscription/*',
                        'admin/invoice/*',
                    ];

                    $isAllowed = false;
                    foreach ($allowedRoutes as $pattern) {
                        if ($request->is($pattern)) {
                            $isAllowed = true;
                            break;
                        }
                    }

                    // If requesting any blocked operational feature (campaigns, spinners, forms, settings, etc.)
                    if (!$isAllowed) {
                        if ($request->ajax() || $request->wantsJson()) {
                            return response()->json([
                                'success' => false,
                                'expired' => true,
                                'message' => 'Your subscription has expired. Please choose a plan and complete payment to continue.'
                            ], 403);
                        }

                        return redirect('admin/billing')->with([
                            'messege' => 'Your subscription is expired. Please select a plan and pay to continue using this feature.',
                            'alert-type' => 'error'
                        ]);
                    }
                }
            } else {
                View::share('isUserSubscriptionExpired', false);
            }
        }

        return $next($request);
    }
}
