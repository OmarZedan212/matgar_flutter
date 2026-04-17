<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellersController extends Controller
{
    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function edit($id)
    {
        $seller = Seller::findOrFail($id);

        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:50',
            'approved' => 'nullable|boolean',
        ]);

        // لو جاي من checkbox ممكن تكون null
        $data['approved'] = $request->has('approved') ? 1 : 0;

        $seller->update($data);

        return redirect()
            ->route('admin.sellers.index')
            ->with('success', 'Seller updated successfully.');
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();

        return redirect()
            ->route('admin.sellers.index')
            ->with('success', 'Seller deleted successfully.');
    }

    public function approve($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->approved = 1;
        $seller->save();

        return redirect()
            ->route('admin.sellers.index')
            ->with('success', 'Seller approved successfully.');
    }
}
