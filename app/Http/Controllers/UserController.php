<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\User;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function autocomplete(Request $request)
    {
        if ($request->ajax()) {
            $customerRole = User::ROLE_CUSTOMER;
            $query = $this->onlyNumbers($request->input('q'));
            $user = User::where('telephone', 'LIKE', "%{$query}%")
                ->where('roles', 'LIKE', "%{$customerRole}%")
                ->get();
            return UserResource::collection($user);
        }
        return redirect()->route('users.index');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(User::latest())
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $user = User::createWithAddress($this->getData($request, !$request->has('password')));
        return request()->ajax() ?
            response()
                ->json(['data' => new UserResource($user), 'message' => __('Entity saved successfully.')]) :
            redirect()->route('users.index');
    }

    private function getData(Request $request, $forcePassword = false)
    {
        $data = $request->all();
        if ($forcePassword) {
            $data['password'] = '12345678';
        }
        if (isset($data['roles']) && is_array($data['roles'])) {
            $data['roles'] = implode(',', $data['roles']);
        }
        return $data;
    }

    public function show(User $user)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => __('Show Data')]) :
            view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => __('Edit Data')]) :
            view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($this->getData($request));
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => __('Entity updated successfully.')]) :
            redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            abort(405, __('Entity cannot be deleted.'));
        }

        $user->delete();
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => __('Entity successfully deleted.')]) :
            redirect()->route('users.index');
    }
}
