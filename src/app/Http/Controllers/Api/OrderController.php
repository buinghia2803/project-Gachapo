<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\OrderBusiness;
use App\Http\Resources\Api\Orders\OrderResource;
use App\Models\Order;

/**
 *  @OA\Tag(
 *      name="Order",
 *      description="Order API",
 * )
 *  @OA\Schema(
 *      schema="order",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="gacha_id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="coupon_id",
 *          type="integer",
 *          example=2,
 *      ),
 *      @OA\Property(
 *          property="coupon_price",
 *          type="integer",
 *          example=4000
 *      ),
 *      @OA\Property(
 *          property="quantity",
 *          type="integer",
 *          example="2"
 *      ),
 *      @OA\Property(
 *          property="gacha_price",
 *          type="integer",
 *          example=5000
 *      ),
 *      @OA\Property(
 *          property="address_delivery",
 *          type="string",
 *          example="東京都文京区湯島2丁目18番12号"
 *      ),
 *      @OA\Property(
 *          property="date_of_shipment",
 *          type="string",
 *          example="2022/01/01"
 *      ),
 *  )
 *
 */
class OrderController extends Controller
{
    /**
     * @var  OrderBusiness
     */
    protected $orderBusiness;

    public function __construct(OrderBusiness $orderBusiness)
    {
        $this->orderBusiness = $orderBusiness;
    }

    /**
     * Order list.
     *
     * @param AuthRequest $request
     * @return UserCreditCardResource
     *
     *  @OA\Get(
     *      path="/api/order",
     *      tags={"Order"},
     *      operationId="getOrderList",
     *      summary="getOrderList",
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
     *                  @OA\Items(ref="#/components/schemas/order")
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
        try {
            $results = $this->orderBusiness->list($request->all());

            return response()->success(OrderResource::collection($results));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }


    /**
     * Get static page by type
     *
     *  @OA\Get(
     *      path="/api/order/{id}",
     *      tags={"Order"},
     *      operationId="getOrderById",
     *      summary="getOrderById",
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
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="address_delivery",
     *                      type="string",
     *                      example="2305792  岩手県杉山市南区斉藤町小林2-7-3 ハイツ村山104号"
     *                  ),
     *                  @OA\Property(
     *                      property="coupon_price",
     *                      type="integer",
     *                      example="1000"
     *                  ),
     *                  @OA\Property(
     *                      property="date_of_shipment",
     *                      type="string",
     *                      example="2022-03-12 00:00:00"
     *                  ),
     *                  @OA\Property(
     *                      property="gacha_id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="gacha_price",
     *                      type="integer",
     *                      example=1000
     *                  ),
     *                  @OA\Property(
     *                      property="quantity",
     *                      type="integer",
     *                      example=100
     *                  ),
     *                  @OA\Property(
     *                  property="review",
     *                      allOf={
     *                          @OA\Schema(ref="#/components/schemas/review"),
     *                          @OA\Schema(
     *                              @OA\Property(
     *                                  property="company_name",
     *                                  type="string",
     *                                  example="喜嶋 美加子"
     *                              ),
     *                              @OA\Property(
     *                                  property="company_furigana",
     *                                  type="string",
     *                                  example="三宅 春香"
     *                              ),
     *                          ),
     *                      }
     *                  ),
     *                  @OA\Property(
     *                      property="gacha",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="image_url",
     *                          type="string",
     *                          example="https://picsum.photos/200/300"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="https://picsum.photos/200/300"
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Getted",
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
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function show($id)
    {
        $result = $this->orderBusiness->detail($id);

        return response()->success(new OrderResource($result));
    }

    /**
     * Event review gacha of user.
     *
     *  @OA\Post(
     *      path="/api/order/review",
     *      tags={"Order"},
     *      operationId="createReviewForOrder",
     *      summary="createReviewForOrder",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="id of order",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="order_id",
     *                  type="integer",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="content",
     *                  type="integer",
     *                  example="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
     *              ),
     *              @OA\Property(
     *                  property="rating",
     *                  type="string",
     *                  example="3.99",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="create review for order",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/review"
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function createReviewOrder(Request $request)
    {
        try {
            $result = $this->orderBusiness->createReview($request->all());

            return response()->success($result->only('id', 'order_id', 'content', 'rating', 'status'), self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }

    /**
     * get order by user id
     *
     *  @OA\Get(
     *      path="/api/order-by-user-id",
     *      tags={"Order"},
     *      operationId="getOrderByUserId",
     *      summary="getOrderByUserId",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example=1,
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="data for order",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/review"
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getOrderByUserId(Request $request)
    {
        try {
            $result = $this->orderBusiness->getOrderByUserId($request->all());

            return response()->success($result->only('id', 'order_id', 'content', 'rating', 'status'), self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }
}
