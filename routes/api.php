<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\EventDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(["prefix" => "v1", "middleware" => "api"], function () {
    /**
     * users api
     */
    Route::prefix('users')->group(function () {

    });

    /**
     * schools api
     */
    Route::prefix('schools')->group(function () {
    });

    /**
     * organizations api
     */
    Route::prefix('orgs')->group(function () {
    });

    /**
     * kidsweekend api
     */
    Route::prefix('kw')->group(function () {
        /**
         * UserParent
         */
        Route::prefix("user-parents")->group(function () {
            Route::get("", function() {
                return response()->json(UserParent::query()->select([
                    'id',
                    'user_master_id',
                    'sex_id',
                    'icon',
                    'full_name',
                    'full_kana',
                    'tel',
                    'zip_code1',
                    'zip_code2',
                    'state',
                    'city',
                    'address1',
                    'address2'
                ])->get());
            });
            Route::post("", function(Request $request, UserParent $userParent) {
                $request->validate([
                    'user_master_id' => 'required',
                    'icon' => '',
                    'sex_id' => 'required',
                    'full_name' => 'required',
                    'full_kana' => 'required',
                    'tel' => 'required',
                    'zip_code1' => 'required',
                    'zip_code2' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'address1' => 'required',
                    'address2' => ''
                ]);
                $userParent->user_master_id = $request->json('user_master_id');
                $userParent->sex_id         = $request->json('sex_id');
                $userParent->icon           = $request->json('icon');
                $userParent->full_name      = $request->json('full_name');
                $userParent->full_kana      = $request->json('full_kana');
                $userParent->tel            = $request->json('tel');
                $userParent->zip_code1      = $request->json('zip_code1');
                $userParent->zip_code2      = $request->json('zip_code2');
                $userParent->state          = $request->json('state');
                $userParent->city           = $request->json('city');
                $userParent->address1       = $request->json('address1');
                $userParent->address2       = $request->json('address2');
                $userParent->save();
            });
            Route::get("/{user_parent_id}", function($user_parent_id) {
                return UserParent::query()
                    ->where('id', '=', $user_parent_id)
                    ->select([
                        'id',
                        'user_master_id',
                        'sex_id',
                        'icon',
                        'full_name',
                        'full_kana',
                        'tel',
                        'zip_code1',
                        'zip_code2',
                        'state',
                        'city',
                        'address1',
                        'address2'
                    ])
                    ->first();
            });
            Route::put("/{user_parent_id}", function(Request $request, $user_parent_id) {
                /**
                 * @var UserParent $user_parent
                 */
                try {
                    $userParent = UserParent::where('id', $user_parent_id)->firstOrFail();
                    $userParent->sex_id  = $request->json('sex_id');
                    $userParent->icon      = $request->json('icon');
                    $userParent->full_name = $request->json('full_name');
                    $userParent->full_kana = $request->json('full_kana');
                    $userParent->tel       = $request->json('tel');
                    $userParent->zip_code1 = $request->json('zip_code1');
                    $userParent->zip_code2 = $request->json('zip_code2');
                    $userParent->state     = $request->json('state');
                    $userParent->city      = $request->json('city');
                    $userParent->address1  = $request->json('address1');
                    $userParent->address2  = $request->json('address2');
                    $userParent->save();
                } catch (ModelNotFoundException $exception) {
                    return response()
                        ->json(['message' => $exception->getMessage()])
                        ->header('Content-Type', 'application/json')
                        ->setStatusCode(404);
                }
            });
            Route::delete("/{user_parent_id}", function($user_parent_id) {
                UserParent::query()->where('id', '=', $user_parent_id)->delete();
            });
        });

        /**
         * UserChild
         */
        Route::prefix("user-children")->group(function () {
            Route::get("", function() {
                return response()->json(UserChild::query()->select([
                    'id',
                    'sex_id',
                    'icon',
                    'first_kana',
                    'last_kana',
                    'birth_day'
                ])->get());
            });
            Route::post("", function(Request $request, UserChild $userChild) {
                $request->validate([
                    'icon' => '',
                    'sex_id' => 'required',
                    'first_kana' => 'required',
                    'last_kana' => 'required',
                    'birth_day' => 'required'
                ]);
                $userChild->sex_id      = $request->json('sex_id');
                $userChild->icon        = $request->json('icon');
                $userChild->first_kana  = $request->json('first_kana');
                $userChild->last_kana   = $request->json('last_kana');
                $userChild->birth_day   = $request->json('birth_day');
                $userChild->save();
            });
            Route::get("/{user_child_id}", function($user_child_id) {
                return UserChild::query()
                    ->where('id', '=', $user_child_id)
                    ->select([
                        'id',
                        'sex_id',
                        'icon',
                        'first_kana',
                        'last_kana',
                        'birth_day'
                    ])
                    ->first();
            });
            Route::put("/{user_child_id}", function(Request $request, $user_child_id) {
                /**
                 * @var UserParent $user_parent
                 */
                try {
                    $userParent = UserChild::where('id', $user_child_id)->firstOrFail();
                    $userParent->sex_id  = $request->json('sex_id');
                    $userParent->icon      = $request->json('icon');
                    $userParent->first_kana = $request->json('first_kana');
                    $userParent->last_kana = $request->json('last_kana');
                    $userParent->birth_day       = $request->json('birth_day');
                    $userParent->save();
                } catch (ModelNotFoundException $exception) {
                    return response()
                        ->json(['message' => $exception->getMessage()])
                        ->header('Content-Type', 'application/json')
                        ->setStatusCode(404);
                }
            });
            Route::delete("/{user_child_id}", function($user_child_id) {
                UserParent::query()->where('id', '=', $user_child_id)->delete();
            });
        });

        /**
         * EventMaster
         */
        Route::prefix("event-masters")->group(function () {
            Route::get("", function() {
                return response()->json(EventMaster::query()->select([
                    'id',
                    'school_master_id',
                    'category_master_id',
                    'title',
                    'detail'
                ])->get());
            });
            Route::post("", function() {});
            Route::get("/{event_master_id}", function() {});
            Route::put("/{event_master_id}", function() {});
            Route::delete("/{event_master_id}", function() {});
        });

        /**
         * EventDetail
         */
        Route::prefix("event-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{event_detail_id}", function() {});
            Route::put("/{event_detail_id}", function() {});
            Route::delete("/{event_detail_id}", function() {});
        });

        /**
         * Book
         */
        Route::prefix("books")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{book_id}", function() {});
            Route::put("/{book_id}", function() {});
            Route::delete("/{book_id}", function() {});
        });

        /**
         * SchoolMaster
         */
        Route::prefix("school-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{school_master_id}", function() {});
            Route::put("/{school_master_id}", function() {});
            Route::delete("/{school_master_id}", function() {});
        });

        /**
         * CompanyMaster
         */
        Route::prefix("company-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{school_master_id}", function() {});
            Route::put("/{school_master_id}", function() {});
            Route::delete("/{school_master_id}", function() {});
        });

        /**
         * Reviews
         */
        Route::prefix("reviews")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{review_id}", function() {});
            Route::put("/{review_id}", function() {});
            Route::delete("/{review_id}", function() {});
        });

        /**
         * Tags
         */
        Route::prefix("tags")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{tag_id}", function() {});
            Route::put("/{tag_id}", function() {});
            Route::delete("/{tag_id}", function() {});
        });

        /**
         * CategoryMaster
         */
        Route::prefix("category-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{category_master_id}", function() {});
            Route::put("/{category_master_id}", function() {});
            Route::delete("/{category_master_id}", function() {});
        });

        /**
         * Sex
         */
        Route::prefix("sexes")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{sex_id}", function() {});
            Route::put("/{sex_id}", function() {});
            Route::delete("/{sex_id}", function() {});
        });

        /**
         * Search
         */
        Route::prefix("search")->group(function () {
            Route::get("/date", function() {});
            Route::get("/age", function() {});
            Route::get("/place", function() {});
            Route::get("/price", function() {});
            Route::get("/category", function() {});
            Route::get("/tag", function() {});
            Route::get("/school", function() {});
            Route::get("/review", function() {});
        });

        /**
         * ChildParent
         */
        Route::prefix("child-parents")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{child_parent_id}", function() {});
            Route::put("/{child_parent_id}", function() {});
            Route::delete("/{child_parent_id}", function() {});
        });

        /**
         * SchoolAndMember
         */
        Route::prefix("school-and-members")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{school_and_member_id}", function() {});
            Route::put("/{school_and_member_id}", function() {});
            Route::delete("/{school_and_member_id}", function() {});
        });


        /**
         * CompanyAndMember
         */
        Route::prefix("company-and-members")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{company_and_member_id}", function() {});
            Route::put("/{company_and_member_id}", function() {});
            Route::delete("/{company_and_member_id}", function() {});
        });

        /**
         * Image
         */
        Route::prefix("images")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{image_id}", function() {});
            Route::put("/{image_id}", function() {});
            Route::delete("/{image_id}", function() {});
        });

        /**
         * Taggable
         */
        Route::prefix("taggables")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{taggables_id}", function() {});
            Route::put("/{taggables_id}", function() {});
            Route::delete("/{taggables_id}", function() {});
        });

        /**
         * UserMaster
         */
        Route::prefix("user-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{user_master_id}", function() {});
            Route::put("/{user_master_id}", function() {});
            Route::delete("/{user_master_id}", function() {});
        });

        /**
         * SchoolAdminMaster
         */
        Route::prefix("school-admin-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{school_admin_master_id}", function() {});
            Route::put("/{school_admin_master_id}", function() {});
            Route::delete("/{school_admin_master_id}", function() {});
        });

        /**
         * CompanyAdminMaster
         */
        Route::prefix("company-admin-masters")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{company_admin_master_id}", function() {});
            Route::put("/{company_admin_master_id}", function() {});
            Route::delete("/{company_admin_master_id}", function() {});
        });

        /**
         * Role
         */
        Route::prefix("roles")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{role_id}", function() {});
            Route::put("/{role_id}", function() {});
            Route::delete("/{role_id}", function() {});
        });

        /**
         * RoleRelation
         */
        Route::prefix("role-relations")->group(function () {
            Route::get("", function() {});
            Route::post("", function() {});
            Route::get("/{role_relation_id}", function() {});
            Route::put("/{role_relation_id}", function() {});
            Route::delete("/{role_relation_id}", function() {});
        });
    });
});
