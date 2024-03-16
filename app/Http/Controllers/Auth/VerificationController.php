<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        if (
            $request->route('id') == $request->user()->getKey() &&
            hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))
        ) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('user.index')->with('success', 'Email already verified.');
            }
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
            return redirect()->route('user.index')->with('success', 'Email verified successfully.');
        }
        return redirect()->route('user.index')->with('error', 'Invalid verification link.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('user.index')->with('success', 'Email already verified.');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification email sent.');
    }
}
