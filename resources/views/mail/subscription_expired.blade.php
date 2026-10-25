<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired - Prize Wheel</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6fb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6fb; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 36px 30px; text-align: center;">
                            <div style="display: inline-block; background: rgba(255,255,255,0.2); padding: 8px 18px; border-radius: 50px; margin-bottom: 12px;">
                                <span style="font-size: 13px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase;">
                                    ⚠️ SUBSCRIPTION EXPIRED
                                </span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;">
                                Your Plan Has Ended
                            </h1>
                            <p style="color: rgba(255,255,255,0.95); font-size: 15px; margin: 8px 0 0 0;">
                                Renew now to restore customer spins, QR campaigns, and leads.
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <p style="font-size: 16px; color: #334155; margin: 0 0 18px 0; line-height: 1.6;">
                                Hi <strong>{{ $user->name ?? 'Valued Partner' }}</strong>,
                            </p>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 20px 0; line-height: 1.6;">
                                Your Prize Wheel store subscription has expired as of <strong>{{ $user->expiry_date ? date('d M Y', strtotime($user->expiry_date)) : 'today' }}</strong>.
                            </p>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 24px 0; line-height: 1.6;">
                                To prevent disruption to your customer prize wheel, review collection, and customer inquiries, please choose a plan and complete your renewal.
                            </p>

                            <!-- Notice Box -->
                            <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 20px; margin-bottom: 28px;">
                                <h4 style="margin: 0 0 8px 0; color: #991b1b; font-size: 15px; font-weight: 700;">
                                    🔒 Account Status: Paused
                                </h4>
                                <ul style="margin: 0; padding-left: 20px; color: #7f1d1d; font-size: 14px; line-height: 1.6;">
                                    <li>Store digital wheel spins are paused.</li>
                                    <li>Customer lead submissions are held.</li>
                                    <li>Dashboard management is locked until renewal.</li>
                                </ul>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 32px 0 24px 0;">
                                <a href="{{ $renewUrl ?: url('admin/billing') }}" style="display: inline-block; background: #ff6b00; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 700; padding: 15px 38px; border-radius: 10px; box-shadow: 0 4px 14px rgba(255,107,0,0.35);">
                                    Choose Plan & Renew Now →
                                </a>
                            </div>

                            <p style="font-size: 13px; color: #94a3b8; text-align: center; margin: 24px 0 0 0;">
                                Questions about renewing? Contact your platform admin or reply directly to this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 13px; color: #94a3b8;">
                                © {{ date('Y') }} Prize Wheel Platform. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
