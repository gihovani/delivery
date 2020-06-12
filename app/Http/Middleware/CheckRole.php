<?php

namespace App\Http\Middleware;

class CheckRole extends Authenticate
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        if ($request->user() && $request->user()->hasRole($guards)) {
            return;
        }

        $this->unauthenticated($request, $guards);
    }

}
