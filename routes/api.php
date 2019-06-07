<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\ChildParent;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\Tag;
use KW\Infrastructure\Eloquents\Image;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\EventSchoolMaster;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Application\Resources\Book\KW\detail\Book as BookResource;
use KW\Application\Resources\Book\User\index\Book as BookIndexResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["prefix" => "v1", "middleware" => "schools"], function () {});
Route::group(["prefix" => "v1", "middleware" => "companies"], function () {});
Route::group(["prefix" => "v1", "middleware" => "api"], function () {
    /**
     * recommends, display api
     */
    Route::post("mail/test", function() {
        $userMaster = \KW\Infrastructure\Eloquents\UserMaster::find(1);
        $book = \KW\Infrastructure\Eloquents\Book::findOrFail('2600994d-5906-36cc-880e-52b9bf16dd43');
//        $userMaster->notify(new \KW\Infrastructure\Apis\Notifications\EventDetail\BookReceived($userMaster));
        $userMaster->notify(new \KW\Infrastructure\Apis\Notifications\Book\BookSuccessed($userMaster));
//        $book->notify(new \KW\Infrastructure\Apis\Notifications\EventDetail\BookCanceled($book));
//        $userMaster->notify(new \KW\Infrastructure\Apis\Notifications\EventDetail\BookFailed($userMaster));
    });

    /**
     * users api
     */
    Route::group(["prefix" => "users"], function () {
        /**
         * UserParent
         */
        Route::group(["prefix" => "user-parents"], function () {
            Route::post("", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@postUserParent');
            Route::get("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@getUserParent');
            Route::put("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@putUserParent');
            Route::delete("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@deleteUserParent');
            Route::get("/{user_parent_id}/children", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@getUserParentsChildren');
        });

        /**
         * UserChild
         */
        Route::group(["prefix" => "user-children"], function () {
            Route::post("", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@postUserChildren');
            Route::get("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@getUserChild');
            Route::put("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@putUserChild');
            Route::delete("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@deleteUserChild');
        });

        /**
         * ChildParent
         * 2019-05-19 must think of being important post, put, delete methods here
         */
        Route::group(["prefix" => "child-parents"], function () {
            Route::post("", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@postChildParent');
            Route::get("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@getChildParent');
            Route::put("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@putChildParent');
            Route::delete("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@deleteChildParent');
        });

        /**
         * EventDetail
         */
        Route::group(["prefix" => "event-details"], function () {
            Route::get("/{event_detail_id}", 'KW\Application\Controllers\User\EventDetail\EventDetailBaseController@getEventDetail');
        });

        /**
         * EventDetail
         */
        Route::group(["prefix" => "books"], function () {
            Route::get("users/{user_parent_id}", 'KW\Application\Controllers\User\Book\BookBaseController@getBooks');
            Route::put("/{book_id}", 'KW\Application\Controllers\Common\Book\BookBaseController@putBook');
        });


        /**
         * Search
         */
        Route::group(["prefix" => "search"], function () {
            Route::get("/date", function(Request $request) {
                $pattern = '/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/';
                $q = $request->input('q');

                // Simple Search
                if(preg_match($pattern, $q)) {
                    // EventDetailを検索する
                    return "preg_match successfully!";
                }
                else {
                    return explode(" ", $q);
                }
            });
            Route::get("/age", function() {});
            Route::get("/place", function() {});
            Route::get("/price", function() {});
            Route::get("/category", function() {});
            Route::get("/tag", function() {});
            Route::get("/school", function() {});
            Route::get("/review", function() {});
        });
    });

    /**
     * schools api
     */
    Route::group(["prefix" => "schools"], function () {
    });

    /**
     * organizations api
     */
    Route::group(["prefix" => "companies"], function () {
    });

    /**
     * kidsweekend api
     */
    Route::group(["prefix" => "kw"], function () {
        /**
         * UserParent
         */
        Route::group(["prefix" => "user-parents"], function () {
            Route::get("", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@getUserParents');
            Route::post("", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@postUserParent');
            Route::get("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@getUserParent');
            Route::put("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@putUserParent');
            Route::delete("/{user_parent_id}", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@deleteUserParent');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{user_parent_id}/user-children", 'KW\Application\Controllers\Common\UserParent\UserParentBaseController@getUserParentsChildren');
            Route::get("/{user_parent_id}/reviews", function($user_parent_id) {
                try {
                    return UserParent::findOrFail($user_parent_id)
                        ->reviews()
                        ->get();
                } catch (ModelNotFoundException $exception) {
                    return response()
                        ->json(['message' => $exception->getMessage()])
                        ->header('Content-Type', 'application/json')
                        ->setStatusCode(404);
                }
            });
        });

        /**
         * UserChild
         */
        Route::group(["prefix" => "user-children"], function () {
            Route::get("", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@getUserChildren');
            Route::post("", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@postUserChildren');
            Route::get("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@getUserChild');
            Route::put("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@putUserChild');
            Route::delete("/{user_child_id}", 'KW\Application\Controllers\Common\UserChild\UserChildBaseController@deleteUserChild');
        });

        /**
         * ChildParent
         */
        Route::group(["prefix" => "child-parents"], function () {
            Route::get("", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@getChildParents');
            Route::post("", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@postChildParent');
            Route::get("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@getChildParent');
            Route::put("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@putChildParent');
            Route::delete("/{child_parent_id}", 'KW\Application\Controllers\Common\ChildParent\ChildParentBaseController@deleteChildParent');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{child_parent_id}/event-details", function() {});
        });

        /**
         * EventMaster
         */
        Route::group(["prefix" => "event-masters"], function () {
            Route::get("", 'KW\Application\Controllers\Common\EventMaster\EventMasterBaseController@getEventMasters');
            Route::post("", 'KW\Application\Controllers\Common\EventMaster\EventMasterBaseController@postEventMasters');
            Route::get("/{event_master_id}", 'KW\Application\Controllers\Common\EventMaster\EventMasterBaseController@getEventMaster');
            Route::put("/{event_master_id}", 'KW\Application\Controllers\Common\EventMaster\EventMasterBaseController@putEventMaster');
            Route::delete("/{event_master_id}", 'KW\Application\Controllers\Common\EventMaster\EventMasterBaseController@deleteEventMaster');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/event-details", function() {});
        });

        /**
         * EventDetail
         */
        Route::group(["prefix" => "event-details"], function () {
            Route::get("", 'KW\Application\Controllers\KW\EventDetail\EventDetailBaseController@getEventDetails');
            Route::post("", 'KW\Application\Controllers\KW\EventDetail\EventDetailBaseController@postEventDetail');
            Route::get("/{event_detail_id}", 'KW\Application\Controllers\KW\EventDetail\EventDetailBaseController@getEventDetail');
            Route::put("/{event_detail_id}", 'KW\Application\Controllers\KW\EventDetail\EventDetailBaseController@putEventDetail');
            Route::delete("/{event_detail_id}", 'KW\Application\Controllers\KW\EventDetail\EventDetailBaseController@deleteEventDetail');

            /**
             * Relation API 2019-05-22 --
             */
            Route::group(["prefix" => "relations"], function () {
                // Only KW
                Route::get("/all", function() {
                    return EventDetail::all();
                });
                // More than General User
                Route::get("/{event_detail_id}/tags", function($event_detail_id) {
                    try {
                        return EventDetail::findOrFail($event_detail_id)
                            ->tags()
                            ->get();
                    } catch (ModelNotFoundException $exception) {
                        return response()
                            ->json(['message' => $exception->getMessage()])
                            ->header('Content-Type', 'application/json')
                            ->setStatusCode(404);
                    }
                });
                Route::get("/{event_detail_id}/images", function($event_detail_id) {
                    try {
                        return EventDetail::findOrFail($event_detail_id)
                            ->images()
                            ->get();
                    } catch (ModelNotFoundException $exception) {
                        return response()
                            ->json(['message' => $exception->getMessage()])
                            ->header('Content-Type', 'application/json')
                            ->setStatusCode(404);
                    }
                });
                Route::get("/{event_detail_id}", function($event_detail_id) {
                    try {
                        return EventDetail::with(['eventSchoolMaster'])
                            ->where('id', '=', $event_detail_id)
                            ->get();
                    } catch (ModelNotFoundException $exception) {
                        return response()
                            ->json(['message' => $exception->getMessage()])
                            ->header('Content-Type', 'application/json')
                            ->setStatusCode(404);
                    }
                });
                Route::get("/{event_detail_id}/child-parents", function($event_detail_id) {
                    try {
                        return EventDetail::findOrFail($event_detail_id)
                            ->childParents()
                            ->get();
                    } catch (ModelNotFoundException $exception) {
                        return response()
                            ->json(['message' => $exception->getMessage()])
                            ->header('Content-Type', 'application/json')
                            ->setStatusCode(404);
                    }
                });
                Route::get("/{event_detail_id}/reviews", function($event_detail_id) {
                    try {
                        return EventDetail::findOrFail($event_detail_id)
                            ->reviews()
                            ->get();
                    } catch (ModelNotFoundException $exception) {
                        return response()
                            ->json(['message' => $exception->getMessage()])
                            ->header('Content-Type', 'application/json')
                            ->setStatusCode(404);
                    }
                });
            });
        });

        /**
         * EventDetail
         */
        Route::group(["prefix" => "books"], function () {
            Route::get("", 'KW\Application\Controllers\Common\Book\BookBaseController@getBooks');
            Route::post("", 'KW\Application\Controllers\Common\Book\BookBaseController@postBooks');
            Route::get("/{book_id}", 'KW\Application\Controllers\Common\Book\BookBaseController@getBook');
            Route::put("/{book_id}", 'KW\Application\Controllers\Common\Book\BookBaseController@putBook');
            Route::delete("/{book_id}", 'KW\Application\Controllers\Common\Book\BookBaseController@deleteBook');

            Route::get("/users/{user_parent_id}", 'KW\Application\Controllers\KW\Book\BookBaseController@getBookByUserParentId');
            Route::get("/event-details/{event_detail_id}", 'KW\Application\Controllers\KW\Book\BookBaseController@getBookByEventDetailId');
            Route::get("test/users/{user_parent_id}", 'KW\Application\Controllers\User\Book\BookBaseController@getBooks');
            Route::get('test/{user_parent_id}', function($user_parent_id) {
                $userParent = UserParent::findOrFail($user_parent_id);
                $eventDetails = $userParent->books()->get();
                return BookResource::collection($eventDetails);
//                return $eventDetails;
            });
        });

        /**
         * SchoolMaster
         */
        Route::group(["prefix" => "school-masters"], function () {
            Route::get("", 'KW\Application\Controllers\Common\SchoolMaster\SchoolMasterBaseController@getSchoolMasters');
            Route::post("", 'KW\Application\Controllers\Common\SchoolMaster\SchoolMasterBaseController@postSchoolMasters');
            Route::get("/{school_master_id}", 'KW\Application\Controllers\Common\SchoolMaster\SchoolMasterBaseController@getSchoolMaster');
            Route::put("/{school_master_id}", 'KW\Application\Controllers\Common\SchoolMaster\SchoolMasterBaseController@putSchoolMaster');
            Route::delete("/{school_master_id}", 'KW\Application\Controllers\Common\SchoolMaster\SchoolMasterBaseController@deleteSchoolMaster');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{school_master_id}/category-masters", function() {});
            Route::get("/{school_master_id}/event-masters", function() {});
            Route::get("/{school_master_id}/school-admin-masters", function() {});
        });

        /**
         * SchoolAndMember
         */
        Route::group(["prefix" => "school-and-members"], function () {
            Route::get("", 'KW\Application\Controllers\Common\SchoolAndMember\SchoolAndMemberBaseController@getSchoolAndMembers');
            Route::post("", 'KW\Application\Controllers\Common\SchoolAndMember\SchoolAndMemberBaseController@postSchoolAndMembers');
            Route::get("/{school_and_member_id}", 'KW\Application\Controllers\Common\SchoolAndMember\SchoolAndMemberBaseController@getSchoolAndMember');
            Route::put("/{school_and_member_id}", 'KW\Application\Controllers\Common\SchoolAndMember\SchoolAndMemberBaseController@putSchoolAndMember');
            Route::delete("/{school_and_member_id}", 'KW\Application\Controllers\Common\SchoolAndMember\SchoolAndMemberBaseController@deleteSchoolAndMember');
        });

        /**
         * CompanyMaster
         */
        Route::group(["prefix" => "company-masters"], function () {
            Route::get("", 'KW\Application\Controllers\Common\CompanyMaster\CompanyMasterBaseController@getCompanyMasters');
            Route::post("", 'KW\Application\Controllers\Common\CompanyMaster\CompanyMasterBaseController@postCompanyMasters');
            Route::get("/{company_master_id}", 'KW\Application\Controllers\Common\CompanyMaster\CompanyMasterBaseController@getCompanyMaster');
            Route::put("/{company_master_id}", 'KW\Application\Controllers\Common\CompanyMaster\CompanyMasterBaseController@putCompanyMaster');
            Route::delete("/{company_master_id}", 'KW\Application\Controllers\Common\CompanyMaster\CompanyMasterBaseController@deleteCompanyMaster');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{company_master_id}/category-master", function() {});
            Route::get("/{company_master_id}/school-masters", function() {});
            Route::get("/{company_master_id}/company-admin-masters", function() {});
        });

        /**
         * CompanyAndMember
         */
        Route::group(["prefix" => "company-and-members"], function () {
            Route::get("", 'KW\Application\Controllers\Common\CompanyAndMember\CompanyAndMemberBaseController@getCompanyAndMembers');
            Route::post("", 'KW\Application\Controllers\Common\CompanyAndMember\CompanyAndMemberBaseController@postCompanyAndMembers');
            Route::get("/{company_and_member_id}", 'KW\Application\Controllers\Common\CompanyAndMember\CompanyAndMemberBaseController@getCompanyAndMember');
            Route::put("/{company_and_member_id}", 'KW\Application\Controllers\Common\CompanyAndMember\CompanyAndMemberBaseController@putCompanyAndMember');
            Route::delete("/{company_and_member_id}", 'KW\Application\Controllers\Common\CompanyAndMember\CompanyAndMemberBaseController@deleteCompanyAndMember');
        });

        /**
         * Reviews
         */
        Route::group(["prefix" => "reviews"], function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{review_id}", function() {});
            Route::put("/{review_id}", function() {});
            Route::delete("/{review_id}", function() {});
        });

        /**
         * Tag
         */
        Route::group(["prefix" => "tags"], function () {
            Route::get("", 'KW\Application\Controllers\Common\Tag\TagBaseController@getTags');
            Route::post("", 'KW\Application\Controllers\Common\Tag\TagBaseController@postTags');
            Route::get("/{tag_id}", 'KW\Application\Controllers\Common\Tag\TagBaseController@getTag');
            Route::put("/{tag_id}", 'KW\Application\Controllers\Common\Tag\TagBaseController@putTag');
            Route::delete("/{tag_id}", 'KW\Application\Controllers\Common\Tag\TagBaseController@deleteTag');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{tag_id}/event-details", function($tag_id) {
                return Tag::findOrFail($tag_id)
                    ->eventDetails()
                    ->get();
            });
        });

        /**
         * Taggable
         */
        Route::group(["prefix" => "taggables"], function () {
            Route::get("", 'KW\Application\Controllers\Common\Taggable\TaggableBaseController@getTaggables');
            Route::post("", 'KW\Application\Controllers\Common\Taggable\TaggableBaseController@postTaggables');
            Route::get("/{taggable_id}", 'KW\Application\Controllers\Common\Taggable\TaggableBaseController@getTaggable');
            Route::put("/{taggable_id}", 'KW\Application\Controllers\Common\Taggable\TaggableBaseController@putTaggable');
            Route::delete("/{taggable_id}", 'KW\Application\Controllers\Common\Taggable\TaggableBaseController@deleteTaggable');
        });

        /**
         * CategoryMaster
         */
        Route::group(["prefix" => "category-masters"], function () {
            Route::get("", 'KW\Application\Controllers\Common\CategoryMaster\CategoryMasterBaseController@getCategoryMasters');
            Route::post("", 'KW\Application\Controllers\Common\CategoryMaster\CategoryMasterBaseController@postCategoryMasters');
            Route::get("/{category_master_id}", 'KW\Application\Controllers\Common\CategoryMaster\CategoryMasterBaseController@getCategoryMaster');
            Route::put("/{category_master_id}", 'KW\Application\Controllers\Common\CategoryMaster\CategoryMasterBaseController@putCategoryMaster');
            Route::delete("/{category_master_id}", 'KW\Application\Controllers\Common\CategoryMaster\CategoryMasterBaseController@deleteCategoryMaster');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{category_master_id}/school-masters", function() {});
            Route::get("/{category_master_id}/event-masters", function() {});
        });

        /**
         * Sex
         */
        Route::group(["prefix" => "sexes"], function () {
            Route::get("", 'KW\Application\Controllers\Common\Sex\SexBaseController@getSexes');
            Route::post("", 'KW\Application\Controllers\Common\Sex\SexBaseController@postSexes');
            Route::get("/{sex_id}", 'KW\Application\Controllers\Common\Sex\SexBaseController@getSex');
            Route::put("/{sex_id}", 'KW\Application\Controllers\Common\Sex\SexBaseController@putSex');
            Route::delete("/{sex_id}", 'KW\Application\Controllers\Common\Sex\SexBaseController@deleteSex');
        });

        /**
         * Image
         */
        Route::group(["prefix" => "images"], function () {
            Route::get("", function() {
                return response()->json(Image::query()->select([
                    'id',
                    'target_type',
                    'target_id',
                    'filename',
                    'created_at',
                    'updated_at'
                ])->get());
            });
            Route::get("/{image_id}", function($image_id) {
                try {
                    return Image::where('id', $image_id)
                        ->select([
                            'id',
                            'target_type',
                            'target_id',
                            'filename',
                            'created_at',
                            'updated_at'
                        ])->firstOrFail();
                } catch (ModelNotFoundException $exception) {
                    return response()
                        ->json(['message' => $exception->getMessage()])
                        ->header('Content-Type', 'application/json')
                        ->setStatusCode(404);
                }
            });
            Route::put("/{image_id}", function(Request $request, $image_id) {
                try {
                    $image = Image::where('id', $image_id)->firstOrFail();
                    $image->filename = $request->json('filename');
                    $image->save();
                } catch (ModelNotFoundException $exception) {
                    return response()
                        ->json(['message' => $exception->getMessage()])
                        ->header('Content-Type', 'application/json')
                        ->setStatusCode(404);
                }
            });
            Route::delete("/{image_id}", function($image_id) {
                Image::query()->where('id', '=', $image_id)->delete();
            });

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{target_id}/schools", function() {});
            Route::get("/{target_id}/event-details", function() {});

        });

        /**
         * Role
         */
        Route::group(["prefix" => "roles"], function () {
            Route::get("", 'KW\Application\Controllers\Common\Role\RoleBaseController@getRoles');
            Route::post("", 'KW\Application\Controllers\Common\Role\RoleBaseController@postRoles');
            Route::get("/{role_id}", 'KW\Application\Controllers\Common\Role\RoleBaseController@getRole');
            Route::put("/{role_id}", 'KW\Application\Controllers\Common\Role\RoleBaseController@putRole');
            Route::delete("/{role_id}", 'KW\Application\Controllers\Common\Role\RoleBaseController@deleteRole');

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{role_id}", function() {});
            Route::get("/{role_id}/user-masters", function() {});
            Route::get("/{role_id}/school-admin-masters", function() {});
            Route::get("/{role_id}/company-admin-masters", function() {});
        });

        /**
         * EventPr
         */
        Route::group(["prefix" => "event-prs"], function () {
            Route::get("", 'KW\Application\Controllers\Common\EventPr\EventPrBaseController@getEventPrs');
            Route::post("", 'KW\Application\Controllers\Common\EventPr\EventPrBaseController@postEventPrs');
            Route::get("/{event_pr_id}", 'KW\Application\Controllers\Common\EventPr\EventPrBaseController@getEventPr');
            Route::put("/{event_pr_id}", 'KW\Application\Controllers\Common\EventPr\EventPrBaseController@putEventPr');
            Route::delete("/{event_pr_id}", 'KW\Application\Controllers\Common\EventPr\EventPrBaseController@deleteEventPr');
        });

        /**
         * Notifications
         */

        /**
         * Auth
         *
         * Login
         * Register
         * Password Reset
         */

        /**
         * UserMaster
         */
        Route::group(["prefix" => "user-masters"], function () {
            Route::post('/register', 'App\Http\Controllers\UserMasterAuth\RegisterController@register');
            Route::post('/login', 'App\Http\Controllers\UserMasterAuth\LoginController@login');
            Route::group(["middleware" => "auth:users"], function () {
                Route::get('/home', function() {
                    return 'You are authorized user';
                });
            });
            Route::post("password/email", "App\Http\Controllers\UserMasterAuth\ForgotPasswordController@sendResetLinkEmail");
            Route::post("password/reset/{token}", "App\Http\Controllers\UserMasterAuth\ResetPasswordController@reset");
            Route::post("email/ship/{user_master_id}", "App\Http\Controllers\UserMasterAuth\RegisterController@ship");

            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{user_master_id}", function() {});
            Route::put("/{user_master_id}", function() {});
            Route::delete("/{user_master_id}", function() {});

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{user_master_id}/roles", function() {});
        });

        /**
         * SchoolAdminMaster
         */
        Route::group(["prefix" => "school-admin-masters"], function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{school_admin_master_id}", function() {});
            Route::put("/{school_admin_master_id}", function() {});
            Route::delete("/{school_admin_master_id}", function() {});

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{school_admin_master_id}/roles", function() {});
        });

        /**
         * CompanyAdminMaster
         */
        Route::group(["prefix" => "company-admin-masters"], function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{company_admin_master_id}", function() {});
            Route::put("/{company_admin_master_id}", function() {});
            Route::delete("/{company_admin_master_id}", function() {});

            /**
             * Relation API 2019-05-22 --
             */
            Route::get("/{company_admin_master_id}/roles", function() {});
        });

        Route::group(["prefix" => "event-school-masters"], function() {
            Route::post("", function() {

            });
        });
    });
});
