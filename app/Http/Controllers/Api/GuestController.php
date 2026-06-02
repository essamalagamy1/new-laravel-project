<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Auth\LoginUserAction;
use App\Actions\Api\Auth\RegisterUserAction;
use App\Actions\Api\Auth\ResetPasswordAction;
use App\Actions\Api\Auth\SendCodeAction;
use App\Actions\Api\Auth\SocialLoginAction;
use App\Actions\Api\Auth\VerifyCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SendCodeRequest;
use App\Http\Requests\Api\SocialLoginRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use Illuminate\Support\Facades\Response;

class GuestController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action)
    {
        $user = $action->execute($request->validated());
        $maskedPhone = substr_replace(
            $user->phone,
            str_repeat('*', max(strlen($user->phone) - 4, 0)),
            0,
            max(strlen($user->phone) - 4, 0)
        );

        return Response::created(__('lang.send_code_successfully_to', ['valu' => $maskedPhone]));
    }

    public function login(LoginRequest $request, LoginUserAction $action)
    {
        $data = $action->execute($request->validated());

        return Response::ok(__('lang.login_successfully'), $data);
    }

    public function socialLogin(SocialLoginRequest $request, SocialLoginAction $action)
    {
        $data = $action->execute($request->validated());

        return Response::ok(__('lang.login_successfully'), $data);
    }

    public function sendCode(SendCodeRequest $request, SendCodeAction $action)
    {
        $user = $action->execute($request->validated());
        $maskedPhone = substr_replace(
            $user->phone,
            str_repeat('*', max(strlen($user->phone) - 4, 0)),
            0,
            max(strlen($user->phone) - 4, 0)
        );

        return Response::ok(__('lang.send_code_successfully_to', ['valu' => $maskedPhone]));
    }

    public function verifyCode(VerifyCodeRequest $request, VerifyCodeAction $action)
    {
        $data = $action->execute($request->validated());

        return Response::ok(__('lang.verified_successfully'), $data);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action)
    {
        $data = $action->execute($request->validated());

        return Response::ok(__('lang.reset_password_successfully'), $data);
    }
}
