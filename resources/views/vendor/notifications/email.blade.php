<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $actionText ?? 'Notification' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #45871B;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .code {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 30px 0;
        }
        .support-text a {
            color: #45871B;
            text-decoration: none;
        }
        .footer a {
            color: #45871B;
            text-decoration: none;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details th, .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .order-details th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f0f2f5;padding:70px 0;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    <tr>
                        <td align="center" style="background-color: #45871B; padding: 40px 20px;">
                            <div style="display: inline-block; padding: 10px 20px; border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 5px;">
                                <img src="https://mightyolu.com/images/logo/logo.png" width="70px" height="70px" alt="Logo">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 40px;">
                            @if ($actionText === 'Reset Password')
                                <h1 style="font-size: 24px; font-weight: bold; margin-top: 0; margin-bottom: 20px;">Reset Password</h1>
                                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">We received a request to reset your password for your {{ config('app.name') }} Account. Click the button below to reset your password.</p>
                                <a href="{{ $actionUrl }}" class="button code">Reset Password</a>
                                <p class="support-text" style="font-size: 14px; color: #555; margin-top: 20px;">If you need more information or assistance, check out our help center or send an email to <a href="mailto:info@mightyolu.com">info@mightyolu.com</a></p>
                            @elseif ($actionText === 'Verify Email Address')
                                <h1 style="font-size: 24px; font-weight: bold; margin-top: 0; margin-bottom: 20px;">Welcome to {{ config('app.name') }}!</h1>
                                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">We're excited to have you on board. Please click the button below to confirm your email address and complete your registration.</p>
                                <a href="{{ $actionUrl }}" class="button code">Confirm Email</a>
                            @elseif ($actionText === 'New Order Notification')
                                <h1 style="font-size: 24px; font-weight: bold; margin-top: 0; margin-bottom: 20px;">New Order Notification</h1>
                                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">A new order has been placed by {{ $userName ?? 'a user' }}.</p>
                                @if (isset($orderDetails) && !empty($orderDetails))
                                    <div class="order-details" style="margin-top: 20px; text-align: left; border-top: 1px solid #eee; padding-top: 20px;">
                                        <p><strong>Order Details:</strong></p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orderDetails as $detail)
                                                    <tr>
                                                        <td>{{ $detail['product_name'] }}</td>
                                                        <td>{{ $detail['quantity'] }}</td>
                                                        <td>${{ number_format($detail['price'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No order details available.</p>
                                @endif
                                <a href="{{ $actionUrl }}" class="button code" style="margin-top: 20px;">View Order</a>
                            @else
                                <h1 style="font-size: 24px; font-weight: bold; margin-top: 0; margin-bottom: 20px;">{{ $actionText ?? 'Notification' }}</h1>
                                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">This is a notification from {{ config('app.name') }}.</p>
                                <a href="{{ $actionUrl }}" class="button">View Details</a>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" class="footer" style="padding: 20px; font-size: 12px; color: #0f0f0f;">
                &copy; {{ date('Y') }} <a style="color: #45871B"  href="{{ url('/') }}">{{ config('app.name') }}</a>. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
