<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\OrderInvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->items;
        $totalPrice = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return view('checkout', compact('user', 'cart', 'cartItems', 'totalPrice'));
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'pincode' => 'required|string|max:6',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        $address = Address::create([
            'user_id' => auth()->id(),
            'receiver_name' => $request->receiver_name,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
        ]);

     
        return redirect()->route('checkout.show')->with('selected_address', $address->id)
                                                  ->with('success', 'New address added successfully!');
    }

public function processCheckout(Request $request)
{
    $user = auth()->user();

    $cart = Cart::where('user_id', $user->id)->with('items.product')->first();
    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Validate the request input
    $request->validate([
        'shipping_address_id' => 'required',
        'paymentMethod' => 'required|string',
    ]);

    // Determine shipping address
    if ($request->shipping_address_id === 'user_address') {
        $shipping_address = $user->address . ', ' . $user->city . ', ' . $user->state . ' - ' . $user->zipcode;
        $shipping_label = 'Profile Address';
    } else {
        $address = Address::findOrFail($request->shipping_address_id);
        $shipping_address = $address->address . ', ' . $address->city . ', ' . $address->state . ' - ' . $address->pincode;
        $shipping_label = $address->receiver_name;
    }

    // Generate custom order number
    $today = Carbon::now();
    $prefix = 'NAT-' . $today->format('d-m-y');
    $orderCountToday = Order::whereDate('created_at', $today->toDateString())->count();
    $sequence = str_pad($orderCountToday + 1, 3, '0', STR_PAD_LEFT);
    $customOrderId = $prefix . '-' . $sequence;

    // Calculate totals
    $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
    $tax = $subtotal * 0.18;
    $total = $subtotal + $tax;


    $order = Order::create([
        'user_id' => $user->id,
        'order_number' => $customOrderId,
        'shipping_address' => $shipping_address,
        'shipping_label' => $shipping_label,
        'payment_method' => $request->paymentMethod,
        'subtotal' => $subtotal,
        'tax' => $tax,
        'total' => $total,
        'status' => $request->paymentMethod === 'online' ? 'paid' : 'Order Placed',
    ]);

    // Create order items
    foreach ($cart->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'total' => $item->price * $item->quantity,
        ]);
    }

    // Ensure invoices directory exists
    $invoiceDirectory = public_path('invoices');
    if (!file_exists($invoiceDirectory)) {
        mkdir($invoiceDirectory, 0755, true);
    }

    // Generate PDF invoice
    $pdf = Pdf::loadView('view-invoice', compact('order'));
    $pdfFileName = 'invoice-' . $order->order_number . '.pdf';
    $pdfPath = 'invoices/' . $pdfFileName;
    $fullPdfPath = public_path($pdfPath);
    $pdf->save($fullPdfPath);

    
    $order->invoice_path = $pdfPath;
    $order->save();

   
    Mail::to($user->email)->send(new OrderInvoiceMail($order, $fullPdfPath));

    // Clear cart
    $cart->items()->delete();
    $cart->delete();

    // Redirect to success
    return redirect()
        ->route('orders.success', $order->id)
        ->with('order_success', true)
        ->with('order_id', $order->id);
}


public function success($orderId)
{
       $user = auth()->user();
    $order = Order::with('items.product')->findOrFail($orderId);
    return view('checkout-success', compact('order'));
}

}
