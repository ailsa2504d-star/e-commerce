<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $recentOrders = Order::where('user_id', Auth::id())->latest()->take(5)->get();
        return view('customer.dashboard', compact('recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('customer.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::where('order_id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('customer.order-details', compact('order'));
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
