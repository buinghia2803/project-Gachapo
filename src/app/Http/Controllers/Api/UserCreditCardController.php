<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Business\UserCreditCardBusiness;
use App\Http\Resources\Api\Cards\UserCreditCardResource;
use App\Http\Requests\Api\Cards\UserCreditCardRequest;
use Illuminate\Http\Request;
use App\Models\UserCreditCard;

/**
 *  @OA\Tag(
 *      name="Credit Card",
 *      description="Card Credit API",
 * )
 *  @OA\Schema(
 *      schema="card",
 *      @OA\Property(
 *          property="card_number",
 *          type="string",
 *          example="***********4242",
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="card_name",
 *          type="string",
 *          example="VISA",
 *      ),
 *      @OA\Property(
 *          property="date_of_expiry",
 *          type="string",
 *          example="12/2025",
 *      ),
 *  )
 */
class UserCreditCardController extends Controller
{

    /**
     * @var  UserCreditCardBusiness
     */
    protected $userCreditCardBusiness;

    public function __construct(UserCreditCardBusiness $userCreditCardBusiness)
    {
        $this->userCreditCardBusiness = $userCreditCardBusiness;
    }

    /**
     * User credit card list.
     *
     * @param AuthRequest $request
     * @return UserCreditCardResource
     *
     *  @OA\Get(
     *      path="/api/card",
     *      tags={"Credit Card"},
     *      operationId="getCards",
     *      summary="getCards",
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
     *                           @OA\Schema(ref="#/components/schemas/card"),
     *                          @OA\Schema(
     *                              @OA\Property(
     *                                  property="fingerprint",
     *                                  type="string",
     *                                  example="Example"
     *                              ),
     *                         )
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

        $list = $this->userCreditCardBusiness->list($conditions);

        return UserCreditCardResource::collection($list);
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
     *      path="/api/card",
     *      tags={"Credit Card"},
     *      operationId="storeCreditCard",
     *      summary="storeCreditCard",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="customer_id",
     *                  type="string",
     *                  example="cus_LNvtvFSa1rFicF",
     *              ),
     *              @OA\Property(
     *                  property="security_code",
     *                  type="string",
     *                  example="441",
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="card_name",
     *                  type="string",
     *                  example="Admin",
     *              ),
     *              @OA\Property(
     *                  property="date_of_expiry",
     *                  type="string",
     *                  example="12/2025",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/card"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="fingerprint",
     *                              type="string",
     *                              example="Example"
     *                          ),
     *                       )
     *                  }
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function store(UserCreditCardRequest $request)
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
     * Display the specified resource.
     *
     * @param  \App\Models\UserCreditCard  $userCreditCard
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/card/{id}",
     *      tags={"Credit Card"},
     *      operationId="showCreditCard",
     *      summary="showCreditCard",
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
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  allOf={
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
    public function show(UserCreditCard $card)
    {
        return new UserCreditCardResource($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Cards\UserCreditCardRequest $request
     * @param  \App\Models\UserCreditCard  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/card/{id}",
     *      tags={"Credit Card"},
     *      operationId="updateCreditCard",
     *      summary="updateCreditCard",
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
     *              @OA\Property(
     *                  property="customer_id",
     *                  type="string",
     *                  example="cus_LNvtvFSa1rFicF",
     *              ),
     *              @OA\Property(
     *                  property="card_number",
     *                  type="string",
     *                  example="4000056655665556",
     *              ),
     *              @OA\Property(
     *                  property="security_code",
     *                  type="string",
     *                  example="441",
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="card_name",
     *                  type="string",
     *                  example="Admin",
     *              ),
     *              @OA\Property(
     *                  property="date_of_expiry",
     *                  type="string",
     *                  example="12/2025",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  allOf={
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
    public function update(UserCreditCardRequest $request, UserCreditCard $card)
    {
        try {
            $data = $request->all();
            $this->userCreditCardBusiness->update($card, $data);

            return response()->success(new UserCreditCardResource($card));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserCreditCard  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/card/{id}",
     *      tags={"Credit Card"},
     *      operationId="deleteCreditCard",
     *      summary="deleteCreditCard",
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
    public function destroy(UserCreditCard $card)
    {
        try {
            $this->userCreditCardBusiness->destroy($card);

            return response()->success(null, self::CODE_SUCCESS_204);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), self::CODE_ERROR_400);
        }
    }
}
