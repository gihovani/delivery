<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
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
        User::createWithAddress($this->getData($request, !$request->has('password')));
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('users.index');
    }

    private function getData(Request $request, $forcePassword = false)
    {
        $data = $request->all();
        if ($forcePassword) {
            $data['password'] = '12345678';
        }
        if (is_array($data['roles'])) {
            $data['roles'] = implode(',', $data['roles']);
        }
        return $data;
    }

    public function show(User $user)
    {
        return request()->ajax() ?
            $user :
            view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return request()->ajax() ?
            $user :
            view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($this->getData($request));
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            abort(405, __('Entity cannot be deleted.'));
        }

        $user->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
            redirect()->route('users.index');
    }
}
