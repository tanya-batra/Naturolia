@component('mail::message')
# Thank you for your order, {{ $order->user->name }}!

Your order **#{{ $order->order_number }}** has been placed successfully.

**Order Total:** ₹{{ number_format($order->total, 2) }}

We’ve attached your invoice PDF to this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
