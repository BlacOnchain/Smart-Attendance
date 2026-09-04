<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7f5; font-family: 'Inter', Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #059669, #0d9488); padding: 32px 40px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 20px; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 2px;">Smart Attendance</h1>
                            <p style="color: #ccfbf1; font-size: 14px; margin: 6px 0 0 0;">Secure Account Verification</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="font-size: 22px; font-weight: 700; color: #0f172a; margin-top: 0;">Password Reset Request</h2>
                            <p style="font-size: 15px; line-height: 1.6; color: #475569; margin-bottom: 24px;">
                                You requested to reset your password for your Smart Attendance account. Use the secure 6-digit verification code below to complete the process. This code will expire in <strong>10 minutes</strong>.
                            </p>

                            <!-- OTP Code Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center" style="background-color: #f0fdf4; border: 2px dashed #059669; border-radius: 16px; padding: 24px;">
                                        <span style="font-family: monospace; font-size: 36px; font-weight: 800; color: #065f46; letter-spacing: 8px;">{{ $otp }}</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; line-height: 1.6; color: #64748b; margin-top: 24px;">
                                If you did not request a password reset, please ignore this email or contact support if you have concerns.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="font-size: 12px; color: #94a3b8; margin: 0;">
                                &copy; {{ date('Y') }} Smart Attendance System. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>