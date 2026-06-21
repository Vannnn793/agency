<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        $defaultRoute = match ($user->role) {
            'admin' => route('admin.dashboard', absolute: false),
            'company' => $user->isVerified()
                ? route('company.dashboard', absolute: false)
                : route('company.pending', absolute: false),
            default => '/',
        };

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($defaultRoute.'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended($defaultRoute.'?verified=1');
    }
}

