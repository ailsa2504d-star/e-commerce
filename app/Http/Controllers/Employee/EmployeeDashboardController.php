<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('employee.dashboard', compact('orders'));
    }

    public function showChangePassword()
    {
        return view('employee.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $employee = Auth::guard('employee')->user();

        if (!Hash::check($request->current_password, $employee->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $employee->password = Hash::make($request->new_password);
        $employee->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $order = Order::where('order_id', $id)->firstOrFail();
        $order->status = $request->status;
        $order->save();

        if ($request->status == 'dispatched') {
            Delivery::updateOrCreate(
                ['order_id' => $id],
                ['dispatch_date' => now(), 'status' => 'dispatched']
            );
        } elseif ($request->status == 'delivered') {
            Delivery::updateOrCreate(
                ['order_id' => $id],
                ['status' => 'delivered']
            );
        }

        return back()->with('success', 'Order status updated successfully.');
    }
}
