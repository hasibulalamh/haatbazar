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
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $addresses = $user->addresses()->latest()->get();
    return view('buyer.addresses.index', compact('addresses'));
}

public function store(Request $request)
{
    // ...validation...
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $isFirst = $user->addresses()->count() === 0;
    // ...
}

public function destroy(Address $address)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($address->user_id !== $user->id) abort(403);
    $wasDefault = $address->is_default;
    $address->delete();
    if ($wasDefault) {
        $user->addresses()->first()?->update(['is_default' => true]);
    }
    return back()->with('success', 'Address deleted!');
}

public function setDefault(Address $address)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if ($address->user_id !== $user->id) abort(403);
    $user->addresses()->update(['is_default' => false]);
    $address->update(['is_default' => true]);
    return back()->with('success', 'Default address updated!');
}
}
