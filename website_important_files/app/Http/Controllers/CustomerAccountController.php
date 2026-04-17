<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class CustomerAccountController extends Controller
{
    /**
     * Show customer account page
     */
    // CustomerAccountController.php
    public function index()
    {
        $user = Auth::user(); // Logged-in user

        // Load user orders
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->get();

        // Pass both $user and $orders to the view
        return view('customer.customer_account', compact('user', 'orders'));
    }
    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No authenticated user found');
        }

        $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // Update via query builder to avoid save/update errors
        User::where('id', $user->id)->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
