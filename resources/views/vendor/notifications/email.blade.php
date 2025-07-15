<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $actionText ?? 'Notification' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #555555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .break-all {
            word-break: break-all;
        }
        .order-details {
            margin-top: 20px;
            text-align: left;
        }
        .order-details ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($actionText === 'Verify Email Address')
            <h1>Welcome to Our {{ config('app.name') }}!</h1>
            <p>We're excited to have you on board. Please confirm your email address to complete your registration.</p>
            <a href="{{ $actionUrl }}" class="button">Confirm Email</a>
        @elseif ($actionText === 'Reset Password')
            <h1>Reset Your Password</h1>
            <p>Click the link below to reset your password:</p>
            <p><a href="{{ $actionUrl }}" class="break-all">{{ $actionUrl }}</a></p>
        @elseif ($actionText === 'New Order Notification')
            <h1>New Order Notification</h1>
            <p>A new order has been placed by {{ $userName ?? 'a user' }}.</p>
            @if (isset($orderDetails) && !empty($orderDetails))
                <div class="order-details">
                    <p><strong>Order Details:</strong></p>
                    <ul>
                        @foreach ($orderDetails as $detail)
                            <li>Product: {{ $detail['product_name'] }}, Quantity: {{ $detail['quantity'] }}, Price: ${{ $detail['price'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p>No order details available.</p>
            @endif
            <a href="{{ $actionUrl }}" class="button">View Orders</a>
        @else
            <h1>{{ $actionText ?? 'Notification' }}</h1>
            <p></p>
            <a class="button" href="{{ $actionUrl }}" class="break-all">{{ $actionUrl }}</a>
        @endif
    </div>
</body>
</html>