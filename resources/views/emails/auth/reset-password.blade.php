<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            background: white;
            margin: 40px auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .icon {
            width: 64px;
            height: 64px;
            background: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #111827;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .button {
            display: inline-block;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: background-color 0.2s;
        }
        .button:hover {
            background: #4338ca;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .security-note {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            color: #92400e;
        }
        .security-note strong {
            color: #78350f;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
        .link-fallback {
            margin-top: 20px;
            padding: 15px;
            background: #f3f4f6;
            border-radius: 6px;
            font-size: 14px;
            word-break: break-all;
            color: #6b7280;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                border-radius: 4px;
            }
            .header {
                padding: 30px 20px;
            }
            .content {
                padding: 30px 20px;
            }
            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔑 Password Reset</h1>
            <p>Secure access to your account</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="icon">
                <svg width="32" height="32" fill="#3b82f6" viewBox="0 0 24 24">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                </svg>
            </div>

            <div class="greeting">Hello!</div>
            
            <div class="message">
                You are receiving this email because we received a password reset request for your account. 
                Click the button below to reset your password and regain access to your account.
            </div>

            <div class="button-container">
                <a href="{{ $actionUrl }}" class="button">Reset Password</a>
            </div>

            <div class="security-note">
                <strong>Security Notice:</strong> This password reset link will expire in {{ $count }} minutes. 
                If you did not request a password reset, no further action is required and you can safely ignore this email.
            </div>

            <div class="message">
                If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
            </div>

            <div class="link-fallback">
                {{ $actionUrl }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This email was sent from <strong>{{ config('app.name') }}</strong></p>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>