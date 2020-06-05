<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests\AddressRequest;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function index(Request $request, User $user)
    {

        if ($request->ajax()) {
            return Datatables::eloquent($user->addresses())
                ->make(true);
        }

        return view('addresses.index', compact('user'));
    }

    public function create(User $user)
    {
        return view('addresses.create', compact('user'));
    }

    public function store(AddressRequest $request, User $user)
    {
        $address = $user->addresses()->create($request->all());
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => __('Entity saved successfully.')]) :
            redirect()->route('users.index');
    }

    public function show(User $user, Address $address)
    {
        $this->assertAddressUser($address, $user);

        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => __('Show Data')]) :
            view('addresses.show', compact('address'));
    }

    public function edit(User $user, Address $address)
    {
        $this->assertAddressUser($address, $user);

        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => __('Edit Data')]) :
            view('addresses.edit', compact('address'));
    }

    public function update(AddressRequest $request, User $user, Address $address)
    {
        $this->assertAddressUser($address, $user);

        $address->update($request->all());
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => __('Entity updated successfully.')]) :
            redirect()->route('addresses.index');
    }

    public function destroy(User $user, Address $address)
    {
        $this->assertAddressUser($address, $user);

        $address->delete();
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => __('Entity successfully deleted.')]) :
            redirect()->route('addresses.index');
    }

    /**
     * @param Address $address
     * @param User $user
     */
    public function assertAddressUser(Address $address, User $user): void
    {
        if ($address->user->id !== $user->id) {
            abort(404);
        }
    }
}
