<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\UserBusiness;
use App\Business\UserCreditCardBusiness;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMailWeb;
use App\Jobs\SendMailTemplate;
use Illuminate\Support\Facades\Cache;

use App\Http\Requests\Api\Users\AuthRequest;
use App\Http\Requests\Api\Users\RegisterUserRequest;
use App\Http\Requests\Api\Users\UpdateUserRequest;
use App\Http\Requests\Api\Users\InfoShippingRequest;
use App\Http\Requests\Api\Cards\UserCreditCardRequest;

use App\Http\Resources\Api\Users\AuthResource;
use App\Http\Resources\Api\Users\RegisterUserResource;
use App\Http\Resources\Api\Users\UserListResource;
use App\Http\Resources\Api\Users\InfoShipping;
use App\Http\Resources\Api\Users\VerificationResource;
use App\Http\Resources\Api\Users\StatusNotificationResource;
use App\Http\Resources\Api\Users\UserProfileResource;
use App\Http\Resources\Api\Users\BasicUserInfoResource;
use App\Http\Resources\Api\Users\UserInfoResource;
use App\Http\Resources\Api\Cards\UserCreditCardResource;
use App\Http\Resources\Api\Gachas\GachaBrowsingHistoryResource;

/**
 *  @OA\Tag(
 *      name="User",
 *      description="User API",
 * )
 *
 *  @OA\Schema(
 *      schema="user",
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="example",
 *      ),
 *      @OA\Property(
 *          property="name_furigana",
 *          type="string",
 *          example="example",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="example@example.com",
 *      ),
 *      @OA\Property(
 *          property="birthday",
 *          type="string",
 *          example="2000/03/13",
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          example="0013-332-7783",
 *      ),
 *      @OA\Property(
 *          property="gender",
 *          type="number",
 *          description="1: Male(男性), 2: Female(女性), 3:other/その他",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="category_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="profession",
 *          type="string",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="address_first",
 *          type="string",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="address_second",
 *          type="string",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="address_type",
 *          type="number",
 *          description="Main address of delivery/配達の主な住所, 1: address_first, 2: address_second', default: 1",
 *          example="1",
 *      ),
 *  )
 *
 *  @OA\Schema(
 *      schema="has_password",
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="Gachapo123",
 *      ),
 *      @OA\Property(
 *          property="password_confirmation",
 *          type="string",
 *          example="Gachapo123",
 *      )
 *  )
 *
 *  @OA\Schema(
 *      schema="infoShipping",
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="address_type",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="address_first",
 *          type="string",
 *          example="石川県小松市里川町ナ部23番地",
 *      ),
 *      @OA\Property(
 *          property="address_second",
 *          type="string",
 *          example="石川県七尾市松百町8部3番地1号",
 *      )
 *  ),
 *
 *  @OA\Schema(
 *      schema="basicUserInfo",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Admin",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="********",
 *      ),
 *      @OA\Property(
 *          property="card_number",
 *          type="string",
 *          example="*********4242",
 *      ),
 *      @OA\Property(
 *          property="status_two_step_verification",
 *          type="integer",
 *          description="0: Un Active, 1: Active",
 *          example=0,
 *      ),
 *      @OA\Property(
 *          property="status_notifice",
 *          type="integer",
 *          description="0: Un Active, 1: Active",
 *          example="1",
 *      )
 *  ),
 *
 *  @OA\Schema(
 *      schema="auth",
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="admin@example.com",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="Gachapo123",
 *      ),
 *  )
 */
class UserController extends Controller
{

    /**
     * @var  UserBusiness
     */
    protected $userBusiness;

    public function __construct(
        UserBusiness $userBusiness,
        UserCreditCardBusiness $userCreditCardBusiness
    ) {
        $this->userBusiness = $userBusiness;
        $this->userCreditCardBusiness = $userCreditCardBusiness;
    }

    /**
     * Get user list.
     *
     * @param AuthRequest $request
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/user",
     *      tags={"User"},
     *      operationId="getUsers",
     *      summary="getUsers",
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *      @OA\Parameter(ref="#/components/parameters/limit"),
     *      @OA\Parameter(ref="#/components/parameters/sort_field"),
     *      @OA\Parameter(ref="#/components/parameters/sort_type"),
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      allOf={
     *                          @OA\Schema(
     *                              @OA\Property(
     *                                property="name",
     *                                type="string",
     *                                example="Gacha 1",
     *                            ),
     *                          ),
     *                          @OA\Schema(ref="#/components/schemas/user"),
     *                      }
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  ref="#/components/schemas/meta"
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  ref="#/components/schemas/links"
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function index(Request $request)
    {
        $conditions = $request->all();

        $this->userBusiness->list($conditions);

        $list = $this->userBusiness->list($conditions);

        return UserListResource::collection($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Users\RegisterUserRequest $request
     * @return  \Illuminate\Http\Response
     *
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/user",
     *      tags={"User"},
     *      operationId="registerUser",
     *      summary="registerUser",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                 @OA\Schema(ref="#/components/schemas/user"),
     *                 @OA\Schema(ref="#/components/schemas/has_password"),
     *                 @OA\Schema(
     *                      @OA\Property(
     *                          property="card_number",
     *                          type="string",
     *                          example="4001007020000002",
     *                      ),
     *                      @OA\Property(
     *                          property="security_code",
     *                          type="string",
     *                          example="441",
     *                      ),
     *                      @OA\Property(
     *                          property="user_id",
     *                          type="integer",
     *                          example=1,
     *                      ),
     *                      @OA\Property(
     *                          property="card_name",
     *                          type="string",
     *                          example="Admin",
     *                      ),
     *                      @OA\Property(
     *                          property="date_of_expiry",
     *                          type="string",
     *                          example="12/2025",
     *                      ),
     *                  )
     *              }
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/user"),
     *                      @OA\Schema(ref="#/components/schemas/card"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="fingerprint",
     *                              type="string",
     *                              example="7326"
     *                          ),
     *                      )
     *                  }
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(RegisterUserRequest $request)
    {
        try {
            $data =  null;
            $conds = $request->all();
            $exist = $this->userBusiness->getUserWithdraw($request->email);
            if (!$exist) {
                $expiredTime = now()->addHours(EXPIRED_MAIL_VERIFICATION_REGISTER)->timestamp;
                $scretkey = $this->userBusiness->encryptDecrypt(ENCRYPT, $expiredTime);

                $link = $request->headers->get('origin') . '/users/register-completed?email=' . $request->email . '&code=' . $scretkey;
                $conds['links'] = $link;
                $data = $this->userBusiness->createUserAndCard($conds);
            } else {
                $duration = $exist->deleted_at->diffInDays(Carbon::now());
                if ($duration > TWO_MONTH_WITHDRAW) {
                    $exist->restore();
                    $exist->update(['status' => ACTIVE]);
                    $data = $exist;
                }
            }

            return response()->success(new RegisterUserResource($data));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/user/{id}",
     *      tags={"User"},
     *      operationId="updateUser",
     *      summary="updateUser",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                 @OA\Schema(ref="#/components/schemas/user"),
     *                 @OA\Schema(ref="#/components/schemas/has_password"),
     *                 @OA\Schema(ref="#/components/schemas/card"),
     *                 @OA\Schema(
     *                      @OA\Property(
     *                          property="security_code",
     *                          type="string",
     *                          example="7326"
     *                      ),
     *                 )
     *              }
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  anyOf={
     *                      @OA\Schema(ref="#/components/schemas/user"),
     *                      @OA\Schema(ref="#/components/schemas/card"),
     *                      @OA\Schema(
     *                           @OA\Property(
     *                               property="fingerprint",
     *                               type="string",
     *                               example="example"
     *                           ),
     *                      )
     *                  }
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->all();

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }
            $this->userBusiness->updateModel($user, $data);

            return  response()->success(new RegisterUserResource($user));;
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/user/{id}",
     *      tags={"User"},
     *      operationId="deleteUser",
     *      summary="deleteUser",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Deleted",
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function destroy(User $user)
    {
        try {
            if ($user->id == auth()->guard('api')->user()->id) {
                return response()->failure('Cannot delete yourself', self::CODE_ERROR_403);
            }

            $this->userBusiness->destroy($user);

            return response()->success(null, self::CODE_SUCCESS_204);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Login user.
     *
     * @param AuthRequest $request
     * @return UserResource
     *
     *  @OA\Post(
     *      path="/api/login",
     *      tags={"User"},
     *      operationId="loginUser",
     *      summary="login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/auth"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="secret_key",
     *                          type="string",
     *                          description="if user active authentication two step then add secret_key to request body",
     *                          example="MU1Kb2R3L2lXUU8rbm1EWVNRUEM2QT09",
     *                      ),
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=1,
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="admid@example.com",
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="admin",
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      example=1,
     *                  ),
     *                  @OA\Property(
     *                      property="access_token",
     *                      description="Expired time is 24 hours.",
     *                      type="string",
     *                      example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODBhMWUzZDkwMTEwZDY3YWYzNzczZmM3Yjg5YTgxM2FjODBiNDZjY2VlYmE4NzMyNDAxNTFiMDU0NTViNjVhN2VkNjlhNjY3YzY1MzZjMGUiLCJpYXQiOjE2NDg0NDI0NDguMjA0ODc3LCJuYmYiOjE2NDg0NDI0NDguMjA0ODgyLCJleHAiOjE2Nzk5Nzg0NDguMTAwODc4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.U7Y2ZIGmjhfBYHJbKb-CfnT8VH1T0EJvD5qznHrjaiRHfE5cMUn1KS9WG6LBxnycDo8GeI70R3IV4guQ9Bj--FSSMSCgcJYAmnLAmBYInclLLqwOMde9N0N3Zvg8VBY8b2cWxh8A0M0eLszFsQmOb-5BXpZP0j-izddacIkJB4EkPBBua-TL_423A_N8hnj7li_2BaSWou1NFHa61xAO1ll4pFKRyZNgrbenDFY1wpSFJIkfYginxxk11CYogxreItuiwlGq5CDwcufozwJ0NFBh9CZKHB4dCvwhY6Akm8uvZuZ1fnruYkALn6aIjaEQX1PTySsH29YWN6eCRgGu_3tH2jApyOuzTtKewKM71h5TizmXPNN4-7ZJdjNBEhiRI-OOUruCgmAISPfmXXqKCO-G39ivfgfHqMa5iqd45Py2sd2oGdprdQyxqrm2VC6KPP_RwJ6NeBSDEd9FIPXvNU0DGF84sjjCmNdM-SlR0kQ6IxBnf-BbpeaKX4fyUvBsh_Nl2d1ATpUBoAp4B5WTpFRFBRT0w_GHVbqBs9d7U5Zvzyl94UcgEx_kg6c9gkOGZN9DYhFjmTHXo7UEJuyweJqRLrPhMFeFGD87nu8b7jWfk9TROxxhriuSyIaSC-Za12ePUfbeEO_6p4Yp4HWEcLLzLU83GwGQ-1DqZX8zJlks",
     *                  ),
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function login(AuthRequest $request)
    {
        $resCheck = [
            'status' => false
        ];

        if ($request->has('email') && $request->email) {
            if (!auth()->guard('login_api')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->failure('Email/Password is not matched', self::CODE_ERROR_401, null, 'username_password_unmatch');
            }
        }

        $user = auth()->guard('login_api')->user();

        if ($user) {
            switch ($user->status) {
                case DEACTIVATE:
                    return response()->failure("The account is not activated yet. Please activate!", self::CODE_ERROR_401, null, 'not_active');
                case BLACKLIST:
                    return response()->failure("You cannot login. Because you are on the blacklist!", self::CODE_ERROR_401, null, 'blacklist');
                case WITHDRAWAL:
                    return response()->failure("You have left the system in the last 2 months!", self::CODE_ERROR_401, null, 'withdrawal');
            }
        }

        // Universal 2nd Factor

        if ($request->secret_key) {
            $resCheck = $this->userBusiness->verify2ndFactor($request->secret_key);
            if (!$resCheck['status']) {
                return response()->failure($resCheck['message'] ?? '', self::CODE_ERROR_400, null, $resCheck['code']);;
            }
        }

        if ($user->status_two_step_verification && !$resCheck['status']) {
            $this->userBusiness->sendMail2ndFactor($user);
            return response()->success(['status' => true, 'code' => '2nd_factor', 'message' => 'An authorization code has been sent to your email address.']);
        }

        $this->userBusiness->updateToken(auth()->guard('login_api')->user());

        return response()->success(new AuthResource(auth()->guard('login_api')->user()));
    }

    /**
     * Logout user.
     *
     * @return Response
     *
     *  @OA\Post(
     *      path="/api/logout",
     *      tags={"User"},
     *      operationId="logoutUser",
     *      summary="logoutUser",
     *      @OA\Response(
     *          response=204,
     *          description="Logged out",
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function logout()
    {
        $user = auth()->guard('api')->user();

        $user->token()->revoke();

        return response()->success(null, self::CODE_SUCCESS_204);
    }

    /**
     * Get auth user info.
     *
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/auth/me",
     *      tags={"User"},
     *      operationId="getProfile",
     *      summary="getProfile",
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="admin"
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      example=1
     *                  ),
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getProfile()
    {
        $user = auth()->guard('api')->user();

        return response()->success(new UserProfileResource($this->userBusiness->getProfile($user)));
    }

    /**
     * Send mail reset password.
     *
     *  @OA\Get(
     *      path="/api/generate-link",
     *      tags={"User"},
     *      operationId="getGenerateLinkResetPW",
     *      summary="getGenerateLinkResetPW",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="An authorization code has been sent to your email address."
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="This e-mail address is not registered."
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getGenerateLinkResetPW(Request $request)
    {
        $user = $this->userBusiness->getActiveUserByEmail($request->email);

        if (!$user) {
            return response()->success(['message' => 'This e-mail address is not registered.', 'status' => FORGOT_PASSWORD['exists_email']]);
        }

        $secretKey = $this->userBusiness->createResetToken($request->email, $user);
        // $link = $request->headers->get('origin') . '/forgot-password/reset?email=' . $request->email . '&sk=' . $secretKey;
        $link = env('CLIENT_DOMAIN') . '/forgot-password/reset?email=' . $request->email . '&sk=' . $secretKey;
        SendMailTemplate::dispatch(MAIL_TEMPLATES_PASSWORD_RESET, $request->email, ['forgot_password_url' => $link]);

        return response()->success(['message' => 'An authorization code has been sent to your email address.']);
    }

    /**
     * Check secret key for password reset.
     *
     *  @OA\Post(
     *      path="/api/check-secret-key",
     *      tags={"User"},
     *      operationId="checkSecretKey",
     *      summary="checkSecretKey",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="example@example.com"
     *              ),
     *              @OA\Property(
     *                  property="secret_key",
     *                  type="string",
     *                  example="CYNY58UUSZ"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      description="1: Successfull, 0: Failure",
     *                      example=1
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Bad request"
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function checkSecretKey(Request $request)
    {
        try {
            $exist = $this->userBusiness->checkSecretKey($request->secret_key, $request->email);
            if ($exist) {
                return response()->success(['status' => 1], 200);
            } else {
                return response()->success(['status' => 0], 200);
            }
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Reset password.
     *
     *  @OA\Post(
     *      path="/api/password-reset",
     *      tags={"User"},
     *      operationId="passwordReset",
     *      summary="passwordReset",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/auth"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="password_confirmation",
     *                          type="string",
     *                          example="Gachapo123",
     *                      ),
     *                      @OA\Property(
     *                          property="secret_key",
     *                          type="string",
     *                          example="DF7END2BNC",
     *                      ),
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      description="1: Successfull, 0: Failure",
     *                      example=1
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Bad request"
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function passwordReset(Request $request)
    {
        try {
            $this->validate($request, [
                'secret_key' => 'string|min:10',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8'
            ]);
            $result = $this->userBusiness->passwordReset($request->only('secret_key', 'password'));
            if ($result) {
                $this->userBusiness->deleteSecretKey($request->secret_key);
            }

            return response()->success(['status' => $result]);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Get information shipping.
     *
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/user/{id}/get-info-shipping",
     *      tags={"User"},
     *      operationId="getInforShipping",
     *      summary="getInforShipping",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/infoShipping",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Getted"
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getInfoShipping(Request $request, User $user)
    {
        return response()->success(new InfoShipping($user));
    }

    /**
     * Update information shipping for user.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/user/{id}/update-info-shipping",
     *      tags={"User"},
     *      operationId="updateInfoShipping",
     *      summary="updateInfoShipping",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/infoShipping"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/infoShipping",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Bad Request.",
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function updateInfoShipping(InfoShippingRequest $request, User $user)
    {
        try {
            $data = $request->all();

            $this->userBusiness->updateInfoShipping($user, $data);

            return  response()->success(new InfoShipping($user));;
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Users\UserCreditCardRequest $request
     * @return  \Illuminate\Http\Response
     *
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/user/other-payment-method",
     *      tags={"User"},
     *      operationId="createOtherPaymentMethod",
     *      summary="createOtherPaymentMethod",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="customer_id",
     *                  type="string",
     *                  example="cus_LNvtvFSa1rFicF",
     *              ),
     *              allOf={
     *                 @OA\Schema(
     *                      @OA\Property(
     *                          property="card_number",
     *                          type="string",
     *                          example="4000056655665556",
     *                      ),
     *                      @OA\Property(
     *                          property="user_id",
     *                          type="integer",
     *                          example="1",
     *                      ),
     *                      @OA\Property(
     *                          property="security_code",
     *                          type="string",
     *                          example="7342"
     *                      ),
     *                      @OA\Property(
     *                          property="card_name",
     *                          type="string",
     *                          example="VISA",
     *                      ),
     *                      @OA\Property(
     *                          property="date_of_expiry",
     *                          type="string",
     *                          example="12/2025",
     *                      ),
     *                  ),
     *              },
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              allOf= {
     *                  @OA\Schema(ref="#/components/schemas/card"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="fingerprint",
     *                          type="string",
     *                          example="Example"
     *                      ),
     *                 )
     *              }
     *          )
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function createOtherPaymentMethod(UserCreditCardRequest $request)
    {
        try {
            $conds = $request->all();
            $data = $this->userCreditCardBusiness->create($conds);

            return response()->success(new UserCreditCardResource($data));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Get basic information for user.
     *
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/user/{id}/basic-user-info",
     *      tags={"User"},
     *      operationId="getInfoBaseOfUserByUserId",
     *      summary="getInfoBaseOfUserByUserId",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/basicUserInfo",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request."
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getInfoBaseOfUserByUserId(Request $request, User $user)
    {
        try {
            $user->load('creditCard');

            return response()->success(new BasicUserInfoResource($user));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Get basic information for user.
     *
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/user/{id}/user-info-by-type/{type}",
     *      tags={"User"},
     *      operationId="getInfoUserByUserIdAndType",
     *      summary="getInfoUserByUserIdAndType",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          description="1: RESPONSE_PROFILE, 3: RESPONSE_TWO_VERIFICATION, 4: RESPONSE_STATUS_NOTIFY, 5:RESPONSE_CARD_INFO",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Response for two verification",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="Response for two verification",
     *                 type="object",
     *                 @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="status_two_step_verification",
     *                      type="integer",
     *                      example=0
     *                  ),
     *                ),
     *             ),
     *
     *             @OA\Property(
     *                  property="Response for card info",
     *                  type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="user_id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="card_number",
     *                          type="string",
     *                          example="*********4242"
     *                      ),
     *                      @OA\Property(
     *                          property="card_name",
     *                          type="string",
     *                          example="MSB"
     *                      ),
     *                      @OA\Property(
     *                          property="date_of_expiry",
     *                          type="string",
     *                          example="05/2024"
     *                      ),
     *                  ),
     *             ),
     *
     *             @OA\Property(
     *                  property="Response for status notification",
     *                  type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="status_notifice",
     *                          type="integer",
     *                          example=0
     *                      ),
     *                  ),
     *             ),
     *             @OA\Property(
     *                  property="Response for user info",
     *                  type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="string",
     *                          example="Admin"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Admin"
     *                      ),
     *                      @OA\Property(
     *                          property="name_furigana",
     *                          type="string",
     *                          example="登録内容変更"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          example="admin@example.com"
     *                      ),
     *                      @OA\Property(
     *                          property="birthday",
     *                          type="string",
     *                          example="2000/03/03"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string",
     *                          example="0013-332-7783"
     *                      ),
     *                      @OA\Property(
     *                          property="gender",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="profession",
     *                          type="string",
     *                          example="Developer"
     *                      ),
     *                      @OA\Property(
     *                          property="address_first",
     *                          type="string",
     *                          example="東京都渋谷区道玄坂２丁目２５番地１２号"
     *                      ),
     *                      @OA\Property(
     *                          property="address_second",
     *                          type="string",
     *                          example="東京都文京区湯島2丁目18番12号"
     *                      ),
     *                      @OA\Property(
     *                          property="address_type",
     *                          type="integer",
     *                          description="Main address of delivery/配達の主な住所, 1: address_first, 2: address_second', default: 1",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="category_id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                  ),
     *             ),
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request."
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getInfoUserByUserIdAndType(User $user, $type)
    {
        try {
            switch ($type) {
                case RESPONSE_PROFILE:
                    return response()->success(new UserInfoResource($user));
                    break;
                case RESPONSE_TWO_VERIFICATION:
                    return response()->success(new VerificationResource($user));
                    break;
                case RESPONSE_STATUS_NOTIFY:
                    return response()->success(new StatusNotificationResource($user));
                    break;
                case RESPONSE_CARD_INFO:
                    $user->load('creditCard');
                    if (isset($user->creditCard)) {
                        return response()->success(new UserCreditCardResource($user->creditCard));
                    } else {
                        return response()->success(null, self::CODE_SUCCESS_204);
                    }
                    break;
                default:
                    return response()->success(null, self::CODE_SUCCESS_204);
                    break;
            }
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/user/{id}/type/{type}",
     *      tags={"User"},
     *      operationId="updateUserInfoByType",
     *      summary="updateUserInfoByType",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          in="path",
     *          description="1: RESPONSE_PROFILE, 3: RESPONSE_TWO_VERIFICATION, 4: RESPONSE_STATUS_NOTIFY, 5:RESPONSE_CARD_INFO",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                 @OA\Schema(ref="#/components/schemas/user"),
     *                 @OA\Schema(ref="#/components/schemas/has_password"),
     *                 @OA\Schema(ref="#/components/schemas/card"),
     *                 @OA\Schema(
     *                      @OA\Property(
     *                          property="security_code",
     *                          type="string",
     *                          example="7326"
     *                      ),
     *                      @OA\Property(
     *                          property="status_notifice",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="status_two_step_verification",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                 )
     *              }
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  anyOf={
     *                      @OA\Schema(ref="#/components/schemas/user"),
     *                      @OA\Schema(ref="#/components/schemas/card"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="fingerprint",
     *                              type="string",
     *                              example="Example"
     *                          ),
     *                      )
     *                  }
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function updateUserInfoByType(UpdateUserRequest $request, User $user)
    {
        $data = [];
        try {
            $type = $request->route('type');
            switch ($type) {
                case RESPONSE_PROFILE:
                    $data = $request->only([
                        'name', 'name_furigana', 'email',
                        'birthday', 'phone', 'gender', 'profession',
                        'address_first', 'address_second', 'address_type', 'category_id'
                    ]);
                    break;
                case RESPONSE_PASSWORD:
                    $data['password'] = bcrypt($request->password);
                    break;
                case RESPONSE_TWO_VERIFICATION:
                    $data['status_two_step_verification'] = $request->status_two_step_verification;
                    break;
                case RESPONSE_STATUS_NOTIFY:
                    $data['status_notifice'] = $request->status_notifice;
                    break;
                case RESPONSE_CARD_INFO:
                    $data = $request->only([
                        'card_number', 'security_code', 'card_name', 'date_of_expiry',
                    ]);
                    break;
            }
            if (!empty($data)) {
                $this->userBusiness->updateModel($user, $data);
            }

            return response()->success($data);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }


    /**
     * Event user leave.
     *
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/user/{id}/leave",
     *      tags={"User"},
     *      operationId="withdrawal",
     *      summary="withdrawal",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="boolean",
     *                      description="true: successful, false: failure",
     *                      example=true
     *                  )
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function withdrawal(User $user)
    {
        try {
            $data = [
                'status' => STATUS_TYPE_LEAVE
            ];
            $this->userBusiness->updateModel($user, $data);
            $status = $user->delete();

            return response()->success(['status' => $status], self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Verify for email verification.
     *
     * @param Request $request
     *
     *  @OA\Get(
     *      path="/api/user/verification",
     *      tags={"User"},
     *      operationId="registerCompletedUser",
     *      summary="registerCompletedUser",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="boolean",
     *                      example=true
     *                  ),
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function verificationCode(Request $request)
    {
        try {
            $time = (int) $this->userBusiness->encryptDecrypt(DECRYPT, $request->code);
            $sendMail = Cache::get($request->code);
            if ($time && $time > now()->timestamp && !$sendMail) {
                $this->userBusiness->sendMailRegisterCompleted($request->email);
                Cache::put($request->code, true, now()->addHours(24));

                return response()->success(['status' => true]);
            } else {
                if ($time && $time < now()->timestamp) {
                    return response()->success(['status' => false, 'message' => '確認リンクの有効期限が切れています。 アカウントを再登録してください。']);
                }
                return response()->success(['status' => false]);
            }
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Browsing history gacha of user.
     *
     * @param Request $request
     *
     *  @OA\Get(
     *      path="/api/user/browsing-history-gacha",
     *      tags={"User"},
     *      operationId="getBrowsingHistoryGacha",
     *      summary="getBrowsingHistoryGacha",
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="廣川 幹"
     *                      ),
     *                      @OA\Property(
     *                          property="period_start",
     *                          type="string",
     *                          example="2022-04-11 19:04:36"
     *                      ),
     *                      @OA\Property(
     *                          property="period_end",
     *                          type="string",
     *                          example="2022-04-01 19:04:36"
     *                      ),
     *                      @OA\Property(
     *                          property="selling_price",
     *                          type="string",
     *                          example=13604
     *                      ),
     *                      @OA\Property(
     *                          property="status_operation",
     *                          description="1: 稼働する, 0: 停止するき",
     *                          type="string",
     *                          example=1
     *                      ),
     *                  )
     *
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getBrowsingHistoryGacha(Request $request)
    {
        try {
            $user = auth()->guard('api')->user();
            $result = $this->userBusiness->getBrowsingHistoryGacha($user, $request->all());

            return response()->success(GachaBrowsingHistoryResource::collection($result), 200);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), 400);
        }
    }
}
