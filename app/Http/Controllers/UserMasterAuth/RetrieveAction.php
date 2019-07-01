<?php

namespace App\Http\Controllers\UserMasterAuth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use KW\Application\Resources\UserAccountInfo\User\Auth\UserMaster as UserMasterResource;

final class RetrieveAction extends Controller
{
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function __invoke()
    {
        return new UserMasterResource($this->authManager->guard('users')->user());
    }
}
