<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration Alert</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #cbd5e1;">
                    
                    <!-- Admin Alert Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 30px 28px; text-align: center; border-bottom: 4px solid #ff6b00;">
                            <span style="display: inline-block; background: rgba(255,107,0,0.2); color: #ff8c3a; padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 10px;">
                                🔔 NEW ACCOUNT CREATED
                            </span>
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 800;">
                                New User Registration Alert
                            </h1>
                            <p style="color: #94a3b8; font-size: 14px; margin: 6px 0 0 0;">
                                A new user just registered on Prize Wheel Platform.
                            </p>
                        </td>
                    </tr>

                    <!-- Details Table -->
                    <tr>
                        <td style="padding: 32px 28px;">
                            <p style="font-size: 15px; color: #334155; margin: 0 0 20px 0;">
                                Hello Administrator, here are the details of the newly registered user:
                            </p>

                            <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 14px; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                                <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569; width: 150px;">Full Name:</td>
                                    <td style="padding: 12px 16px; color: #0f172a; font-weight: 600;">{{ $user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569;">Email Address:</td>
                                    <td style="padding: 12px 16px; color: #0284c7; font-weight: 600;">
                                        <a href="mailto:{{ $user->email }}" style="color: #0284c7; text-decoration: none;">{{ $user->email }}</a>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569;">Phone Number:</td>
                                    <td style="padding: 12px 16px; color: #0f172a;">{{ !empty($user->phone) ? $user->phone : 'Not provided' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569;">Custom Wheel URL:</td>
                                    <td style="padding: 12px 16px; color: #ea580c; font-weight: 600;">
                                        @if(!empty($user->name_url))
                                            <a href="{{ url('u/' . $user->name_url) }}" target="_blank" style="color: #ea580c;">{{ url('u/' . $user->name_url) }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569;">Registration Time:</td>
                                    <td style="padding: 12px 16px; color: #0f172a;">{{ date('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #475569;">Account Plan:</td>
                                    <td style="padding: 12px 16px; color: #16a34a; font-weight: 700;">1-Day Free Trial (Active)</td>
                                </tr>
                            </table>

                            <!-- Admin Quick Action -->
                            <div style="text-align: center; margin: 30px 0 10px 0;">
                                <a href="{{ url('admin/sub_user_list') }}" target="_blank" style="display: inline-block; background: #0f172a; color: #ffffff; font-weight: 700; font-size: 14px; text-decoration: none; padding: 12px 28px; border-radius: 8px;">
                                    View Users in Admin Panel &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 18px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                                Automated admin system alert from Prize Wheel platform.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
