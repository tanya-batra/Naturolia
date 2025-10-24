@component('mail::message')
# Order Status Updated

Hello {{ $order->user->name }},

Your order **#{{ $order->order_number }}** status has been updated to:

**{{ ucfirst($order->status) }}**



Thanks,<br>
{{ config('app.name') }}
@endcomponent
