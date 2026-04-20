<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:Credit Card,Cheque,VPP',
            'delivery_type' => 'required|in:normal,fast',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Generate UNIQUE 16-digit Order ID:
            // [1 digit delivery type] + [7 digit product ID] + [8 digit order number]
            // Note: Since an order can have multiple products, we'll use the FIRST product's ID for the ID format as per requirements.
            $firstProduct = reset($cart);
            $deliveryDigit = ($request->delivery_type == 'fast') ? '2' : '1';
            $productId = str_pad($firstProduct['product_id'], 7, '0', STR_PAD_LEFT);
            $orderNumber = str_pad(Order::count() + 1, 8, '0', STR_PAD_LEFT);
            $orderId = $deliveryDigit . substr($productId, 0, 7) . $orderNumber;

            $order = Order::create([
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_type' => $request->payment_type,
                'delivery_type' => $request->delivery_type,
                'status' => 'pending',
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $details['product_id'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // Update stock
                $product = Product::where('product_id', $details['product_id'])->first();
                $product->stock_quantity -= $details['quantity'];
                $product->save();
            }

            Payment::create([
                'order_id' => $orderId,
                'payment_type' => $request->payment_type,
                'amount' => $total,
                'status' => 'pending',
            ]);

            DB::commit();
            session()->forget('cart');

            return redirect()->route('customer.orders')->with('success', 'Order placed successfully! Order ID: ' . $orderId);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $order = Order::where('order_id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status == 'pending' || $order->status == 'cleared') {
            $order->status = 'cancelled';
            $order->save();
            return back()->with('success', 'Order cancelled successfully.');
        }

        return back()->with('error', 'Order cannot be cancelled as it is already dispatched.');
    }

    public function returnRequest(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Check if within 7 days
        if ($order->updated_at->diffInDays(now()) > 7) {
            return back()->with('error', 'Returns/Replacements are only allowed within 7 days.');
        }

        $order->status = 'return_requested';
        $order->save();

        return back()->with('success', 'Return requested successfully.');
    }
}
