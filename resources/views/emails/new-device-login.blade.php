<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Sign-In Alert</title>
</head>
<body style="margin:0; padding:0; background-color:#f0fdf4; font-family: 'Segoe UI', Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4; padding: 32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius: 12px; overflow:hidden; box-shadow: 0 4px 16px rgba(16,185,129,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981, #0d9488); padding: 28px 32px;">
                            <span style="color:#ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.3px;">
                                Smart Attendance
                            </span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <h1 style="margin:0 0 12px; font-size: 18px; color:#065f46;">
                                New sign-in detected
                            </h1>
                            <p style="margin:0 0 20px; font-size: 14px; line-height: 1.6; color:#374151;">
                                Hi {{ $name }}, your account was just signed into from a device or location we haven't seen before.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="background:#f0fdf4; border: 1px solid #d1fae5; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px; font-size: 13px; color:#065f46;">
                                        <div style="margin-bottom: 8px;"><strong>Time:</strong> {{ $loggedInAt }}</div>
                                        <div style="margin-bottom: 8px;"><strong>IP address:</strong> {{ $ip }}</div>
                                        <div><strong>Device:</strong> {{ $userAgent }}</div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 24px; font-size: 14px; line-height: 1.6; color:#374151;">
                                If this was you, you can safely ignore this email. If you don't recognize this activity,
                                secure your account by resetting your password right away.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-radius: 8px; background: linear-gradient(135deg, #10b981, #0d9488);">
                                        <a href="{{ route('login') }}"
                                           style="display:inline-block; padding: 12px 24px; font-size: 14px; font-weight: 600; color:#ffffff; text-decoration:none;">
                                            Wasn't you? Reset your password
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 32px; background:#f9fafb; border-top: 1px solid #f3f4f6;">
                            <p style="margin:0; font-size: 12px; color:#9ca3af;">
                                This is an automated security alert from Smart Attendance. Please don't reply to this email.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>