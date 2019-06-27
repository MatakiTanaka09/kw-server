<?php

namespace App\Http\Controllers\UserMasterAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use KW\Infrastructure\Eloquents\UserMaster;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('throttle:6,1');
    }

    public function verify(Request $request)
    {
        $user = UserMaster::find($request->route('id'));
        if (!$user->email_verified_at) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return new JsonResponse('Email Verified');
        }
        return new JsonResponse('Email Verify Failed');
//        return $user;
    }

    public function resend(Request $request)
    {
        $user = UserMaster::where('email', $request->get('email'))->get()->first();
        if (!$user) {
            return new JsonResponse('No Such User');
        }
        if ($user->hasVerifiedEmail()) {
            return new JsonResponse('Already Verified User');
        }

        $user->sendEmailVerificationNotification();

        return new JsonResponse('Send Verify Email');
    }
}
