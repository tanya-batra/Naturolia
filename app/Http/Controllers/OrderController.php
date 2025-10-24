<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderStatusUpdated;
use App\Mail\CourierDetailsUpdated;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
public function pending()
{
    $orders = Order::with('items.product', 'user')
        ->whereNotIn('status', ['completed', 'delivered']) 
        ->get();

    return view('Admin.pending-order', compact('orders'));
}

public function orderStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|string|in:packed,courier,delivered,cancelled',
    ]);

    // Check if trying to change to 'courier' status without courier details
    if ($request->status === 'courier' && !$order->courier_name) {
        return back()->withErrors('Please add courier details before changing status to courier.');
    }

    $oldStatus = $order->status;
    $order->status = $request->status;
    $order->save();

    if ($oldStatus !== $request->status) {
        Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
    }

    return back()->with('success', 'Order status updated successfully.');
}
public function saveCourierDetails(Request $request, Order $order)
{
    $request->validate([
        'courier_name' => 'required|string|max:255',
        'tracking_number' => 'required|string|max:255',
        'courier_link' => 'required|max:255',
    ]);

    $order->courier_name = $request->courier_name;
    $order->tracking_number = $request->tracking_number;
    $order->courier_link = $request->courier_link;
    $order->save();

  
    Mail::to($order->user->email)->send(new CourierDetailsUpdated($order));

    return redirect()->back()->with('success', 'Courier details saved and email sent successfully.');
}
  public function completed()
{
    $orders = Order::with('items.product', 'user')
        ->whereIn('status', ['delivered', 'completed'])
        ->get();

    return view('Admin.completed-order', compact('orders'));
}
public function allOrders()
{
    $orders = Order::with('items.product', 'user')->get(); 
    return view('Admin.all-order', compact('orders'));
}
public function track(Order $order)
{
   
    return view('track-shipment', compact('order'));
}

}
