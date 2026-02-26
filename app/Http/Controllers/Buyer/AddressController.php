<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('buyer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('buyer.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
            'city'    => 'required|string|max:100',
        ]);

        $isFirst = Auth::user()->addresses()->count() === 0;

        Address::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'city'       => $request->city,
            'is_default' => $isFirst, // first address = default
        ]);

        return redirect()->route('buyer.addresses.index')
            ->with('success', 'Address added successfully!');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);
        return view('buyer.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
            'city'    => 'required|string|max:100',
        ]);

        $address->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
        ]);

        return redirect()->route('buyer.addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted was default, make first remaining default
        if ($wasDefault) {
            Auth::user()->addresses()->first()?->update(['is_default' => true]);
        }

        return back()->with('success', 'Address deleted!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        // Remove all defaults
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set new default
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated!');
    }
}
