<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }

        $response = back()->with('status', __($status));

        // Dev fallback: show reset link in UI when mail is not sent externally.
        $mailer = Config::get('mail.default');
        if (!app()->runningUnitTests() && in_array($mailer, ['log', 'array'], true)) {
            $user = User::query()->where('email', $request->string('email')->toString())->first();

            if ($user) {
                $token = Password::broker()->createToken($user);
                $resetLink = route('password.reset', [
                    'token' => $token,
                    'email' => $user->email,
                ]);

                $response->with('reset_link_preview', $resetLink);
            }
        }

        return $response;
    }
}
