<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Payment Notification - Admin</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6fb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6fb; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); padding: 36px 30px; text-align: center;">
                            <div style="display: inline-block; background: rgba(255,255,255,0.2); padding: 8px 18px; border-radius: 50px; margin-bottom: 12px;">
                                <span style="font-size: 13px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase;">
                                    💰 NEW REVENUE RECEIVED
                                </span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;">
                                ₹{{ number_format($payment->amount, 2) }} Credited
                            </h1>
                            <p style="color: rgba(255,255,255,0.95); font-size: 15px; margin: 8px 0 0 0;">
                                A store user has subscribed to a plan via Razorpay.
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <p style="font-size: 16px; color: #334155; margin: 0 0 18px 0; line-height: 1.6;">
                                Hi <strong>{{ $admin->name ?? 'Admin' }}</strong>,
                            </p>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 24px 0; line-height: 1.6;">
                                Great news! <strong>{{ $user->name ?? 'A client' }}</strong> has completed a successful payment for their Prize Wheel plan.
                            </p>

                            <!-- Transaction Details Box -->
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 28px;">
                                <h3 style="margin: 0 0 14px 0; color: #0f172a; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Transaction & Store Details
                                </h3>
                                <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 14px;">
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; width: 140px;">Store Name:</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 700;">{{ $user->name ?? 'N/A' }} (ID: #{{ $user->id }})</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Store Email:</td>
                                        <td style="padding: 6px 0; color: #0f172a;">{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Plan Selected:</td>
                                        <td style="padding: 6px 0; color: #4f46e5; font-weight: 700;">{{ $payment->plan_name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Amount Paid:</td>
                                        <td style="padding: 6px 0; color: #10b981; font-weight: 800; font-size: 16px;">₹{{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Payment ID:</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 600;">{{ $payment->razorpay_payment_id ?: $payment->payment_unique_id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">New Expiry Date:</td>
                                        <td style="padding: 6px 0; color: #ea580c; font-weight: 700;">
                                            {{ $payment->expiry_extended_to ? date('d M Y', strtotime($payment->expiry_extended_to)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Time:</td>
                                        <td style="padding: 6px 0; color: #0f172a;">{{ date('d M Y, h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 32px 0 24px 0;">
                                <a href="{{ url('admin/payments') }}" style="display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 700; padding: 14px 34px; border-radius: 10px; box-shadow: 0 4px 14px rgba(79,70,229,0.35);">
                                    View All Payments in Admin →
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                                © {{ date('Y') }} Prize Wheel Platform. Admin Notification.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
