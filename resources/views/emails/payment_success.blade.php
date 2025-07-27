<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0; }
        .container { background: #fff; margin: 40px auto; padding: 30px; max-width: 600px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);}
        h2 { color: #27ae60; }
        .details { margin-top: 20px; }
        .footer { margin-top: 40px; font-size: 13px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Successful!</h2>
        <p>Dear {{ $user->name ?? 'Customer' }},</p>
        <p>Thank you for your payment. Your transaction has been processed successfully.</p>
        <div class="details">
            <strong>Amount Paid:</strong> {{ $amount ?? 'N/A' }}<br>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($paid_at ?? now())->diffForHumans() }}<br>
            <strong>Order Items:</strong>
            <ul>
                @foreach($orderItems as $item)
                    <li>{{ $item->product->title }} (x{{ $item->quantity }}) - {{ $item->price }}</li>
                @endforeach
            </ul>
        </div>
        <p>If you have any questions, feel free to contact our support team.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>