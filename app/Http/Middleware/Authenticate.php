<?php

namespace App\Http\Middleware;

use App\Variables;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        $guard = "sanctum";

        if ($this->auth->guard($guard)->check()) {
            $this->auth->shouldUse($guard);

            if (empty($guards)) {
                return;
            }

            $user = auth()->user();
            $userRole = $user->role;
            $vars = new Variables();

            if ($userRole == $vars->admin) {
                return;
            }

            foreach ($guards as $guard) {
                if ($guard == $userRole) {
                    return;
                }
            }

            throw new AuthenticationException(
                'Unauthenticated.', $guards, route("noPermission")
            );
        }
        /*dd($guards);

        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }*/

        $this->unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('notLoggedIn');
    }
}
