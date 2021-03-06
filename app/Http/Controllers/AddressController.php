<?php

namespace App\Http\Controllers;

use App\Address;
use App\Config;
use App\Http\Requests\AddressRequest;
use App\Libraries\DistanceMatrix;
use App\Libraries\Geocoder;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function distance(Address $address)
    {
        if ($address->is_google_distance) {
            return $address;
        }
        $address->longitude = 1;
        $address->save();
        $address->refresh();
        return ['encontrou' => 1, compact('address')];
    }

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
        $address = $user->addresses()->create($this->getData($request->all()));
        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => $message]) :
            redirect()
                ->route('addresses.index', $user)
                ->with('status', $message);
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

        $address->update($this->getData($request->all()));
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => $message]) :
            redirect()
                ->route('addresses.index', $user)
                ->with('status', $message);
    }

    public function destroy(User $user, Address $address)
    {
        $this->assertAddressUser($address, $user);

        $address->delete();
        $message = __('Entity successfully deleted.');
        return request()->ajax() ?
            response()
                ->json(['data' => $address, 'message' => $message]) :
            redirect()
                ->route('addresses.index', $user)
                ->with('status', $message);
    }

    private function getData($data)
    {
        if (isset($data['no-address'])) {
            $data['zipcode'] = Address::DEFAULT_ZIPCODE;
            $data['city'] = Address::DEFAULT_CITY;
            $data['neighborhood'] = Address::DEFAULT_NEIGHBORHOOD;
            $data['number'] = Address::DEFAULT_NUMBER;
            $data['state'] = Address::DEFAULT_STATE;
            $data['street'] = __(Address::DEFAULT_STREET);
            $data['complement'] = '';
        }
        return $data;
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
