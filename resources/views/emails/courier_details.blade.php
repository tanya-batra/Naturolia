<!DOCTYPE html>
<html>
<head>
    <title>Courier Details Updated</title>
</head>
<body>
    <h1>Order Courier Details Updated</h1>
    <p>Dear {{ $order->user->name }},</p>
    <p>Your order <strong>{{ $order->order_number }}</strong> has been updated with courier details.</p>
    <ul>
        <li><strong>Courier Name:</strong> {{ $order->courier_name }}</li>
        <li><strong>Tracking Number:</strong> {{ $order->tracking_number }}</li>
        <li><strong>Courier Link:</strong> <a href="{{ $order->courier_link }}">{{ $order->courier_link }}</a></li>
    </ul>
    <p>You can track your shipment using the above link.</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>
