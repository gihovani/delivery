<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Model;
use App\User;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function autocomplete(Request $request)
    {
        if ($request->ajax()) {
            $customerRole = User::ROLE_CUSTOMER;
            $query = Model::onlyNumbers($request->input('q'));
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
        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => new UserResource($user), 'message' => $message]) :
            redirect()
                ->route('users.index')
                ->with('status', $message);
    }

    private function getData(Request $request, $forcePassword = false)
    {
        $data = $request->all();
        if (isset($data['no-email']) && isset($data['telephone'])) {
            $data['email'] = Model::onlyNumbers($data['telephone']).User::DEFAULT_EMAIL;
        }
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
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => $message]) :
            redirect()
                ->route('users.index')
                ->with('status', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            abort(405, __('Entity cannot be deleted.'));
        }

        $user->delete();
        $message = __('Entity successfully deleted.');
        return request()->ajax() ?
            response()
                ->json(['data' => $user, 'message' => $message]) :
            redirect()
                ->route('users.index')
                ->with('status', $message);
    }
}
