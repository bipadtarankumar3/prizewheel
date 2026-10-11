<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Prize Wheel</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6fb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6fb; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%); padding: 36px 30px; text-align: center;">
                            <div style="display: inline-block; background: rgba(255,255,255,0.2); padding: 10px 18px; border-radius: 50px; margin-bottom: 12px;">
                                <span style="font-size: 14px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px; text-transform: uppercase;">
                                    🎡 PRIZE WHEEL PLATFORM
                                </span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 800; letter-spacing: -0.5px;">
                                Welcome to Prize Wheel!
                            </h1>
                            <p style="color: rgba(255,255,255,0.9); font-size: 15px; margin: 8px 0 0 0;">
                                Your gamified customer engagement hub is ready.
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <p style="font-size: 16px; color: #334155; margin: 0 0 18px 0; line-height: 1.6;">
                                Hi <strong>{{ $user->name ?? 'Valued Customer' }}</strong>,
                            </p>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 24px 0; line-height: 1.6;">
                                Thank you for creating an account with <strong>Prize Wheel</strong>! You now have full access to set up custom digital spin wheels, run viral marketing campaigns, and collect verified customer leads.
                            </p>

                            <!-- Account Details Box -->
                            <div style="background-color: #fff7ed; border: 1px solid rgba(255,107,0,0.25); border-radius: 12px; padding: 20px; margin-bottom: 28px;">
                                <h3 style="margin: 0 0 12px 0; color: #9a3412; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Account Summary
                                </h3>
                                <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 14px;">
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; width: 140px;">Registered Name:</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 600;">{{ $user->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Registered Email:</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 600;">{{ $user->email }}</td>
                                    </tr>
                                    @if(!empty($user->name_url))
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Your Wheel URL:</td>
                                        <td style="padding: 6px 0; color: #ea580c; font-weight: 700;">
                                            {{ url('u/' . $user->name_url) }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">Access Status:</td>
                                        <td style="padding: 6px 0; color: #16a34a; font-weight: 700;">Active Free Trial</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0 20px 0;">
                                <a href="{{ url('admin/dashboard') }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%); color: #ffffff; font-weight: 700; font-size: 15px; text-decoration: none; padding: 14px 34px; border-radius: 10px; box-shadow: 0 6px 20px rgba(255,107,0,0.35);">
                                    Access Your Dashboard &rarr;
                                </a>
                            </div>

                            <p style="font-size: 13.5px; color: #64748b; line-height: 1.5; margin: 24px 0 0 0; text-align: center;">
                                Need help getting started? Simply reply to this email or contact support.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                                &copy; {{ date('Y') }} Prize Wheel Platform. All rights reserved.<br>
                                This is an automated notification sent to {{ $user->email }}.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
