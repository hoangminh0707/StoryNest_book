<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác minh email</title>
</head>
<body style="background-color: #f4f4f4; padding: 40px 0; font-family: Arial, sans-serif;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="text-align: center; padding: 30px 0;">
                {{-- Thay bằng logo của bạn --}}
                <img src="https://i.ibb.co/WpKLtySw/download.jpg" alt="Website Logo" height="50">
            </td>
        </tr>
        <tr>
            <td style="padding: 0 40px 30px;">
                <h2 style="text-align: center; color: #333;">Xác minh địa chỉ email</h2>
                <p style="text-align: center; color: #555;">
                    Chào <strong>{{ $user->name }}</strong>,<br>
                    Nhấn nút bên dưới để xác minh địa chỉ email của bạn.
                </p>
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $verificationUrl }}" style="
                        background-color: #3490dc;
                        color: white;
                        text-decoration: none;
                        padding: 12px 24px;
                        border-radius: 6px;
                        font-weight: bold;
                        display: inline-block;
                    ">
                        Xác minh Email
                    </a>
                </div>
                <p style="text-align: center; color: #999;">
                    Nếu bạn không yêu cầu tạo tài khoản, bạn có thể bỏ qua email này.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 12px; color: #888;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
