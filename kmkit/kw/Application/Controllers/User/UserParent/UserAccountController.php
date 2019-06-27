<?php

namespace KW\Application\Controllers\User\UserParent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use KW\Application\Requests\UserParent\User\UserAccount as UserAccountRequest;
use KW\Application\Requests\UserChild\User\UserChild as UserChildRequest;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Application\Controllers\User\UserChild\UserChildBaseController;

class UserAccountController extends Controller
{
    /**
     * @var UserChildBaseController
     */
    private $userChildController;
    private $userParentController;

    /**
     * UserAccountController constructor.
     * @param UserChildBaseController $userChildController
     * @param \KW\Application\Controllers\User\UserParent\UserParentBaseController $userParentController
     */
    public function __construct(
        UserChildBaseController $userChildController,
        UserParentBaseController $userParentController
    ) {
        $this->userChildController = $userChildController;
        $this->userParentController = $userParentController;
    }

    public function postUserAccount(
        UserAccountRequest $userAccountRequest,
        UserParent $userParent
    ) {
        $user_parent_id = $this->userParentController->postUserParent($userAccountRequest, $userParent);
        $this->userChildController->postUserChildren($userAccountRequest, $user_parent_id);
        return UserAccountController::receiveResponse();
    }

    private static function receiveResponse()
    {
        return response()->json([
            'result' => 'ok',
        ], Response::HTTP_OK);
    }
}
