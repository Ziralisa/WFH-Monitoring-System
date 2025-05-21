<!DOCTYPE html>
<html>
<head>
    <title>You're Invited!</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

                <!-- Logo -->
                    <tr>
            
                    </tr>
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #4A90E2; padding: 20px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">You're Invited!</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #555;">Hello,</p>

                            <p style="font-size: 16px; color: #555;">
                                <strong>WFH Monitoring System</strong> is inviting you to join the platform. We’re thrilled to have you on board!
                            </p>

                            <p style="font-size: 16px; color: #555;">Click the button below to accept the invitation and get started:</p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('/sign-up?token=' . $invitation->token) }}" 
                                   style="background-color: #4A90E2; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: bold; display: inline-block;">
                                    Accept Invitation
                                </a>
                            </p>

                            <p style="font-size: 14px; color: #999; text-align: center;">
                                This link will expire on 
                                @if ($invitation->expires_at)
                                    <strong>{{ $invitation->expires_at->format('d M Y, h:i A') }}</strong>
                                @else
                                    <em>Expiration date not set</em>.
                                @endif
                            </p>

                            <p style="font-size: 16px; color: #555;">Looking forward to working with you!</p>

                            <p style="font-size: 16px; color: #555;">Warm regards,<br><strong>WFH Monitoring System Team</strong></p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f0f0f0; text-align: center; padding: 15px; font-size: 12px; color: #999;">
                            &copy; {{ date('Y') }} WFH Monitoring System. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
