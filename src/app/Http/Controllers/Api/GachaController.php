<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Business\GachaBusiness;
use App\Http\Resources\Api\Gachas\GachaResource;
use App\Http\Resources\Api\Gachas\GachaFavoriteResource;
use App\Http\Requests\Api\Gachas\GachaRequest;
use App\Http\Requests\Api\Gachas\BuyGachaRequest;
use Illuminate\Http\Request;
use App\Models\Gacha;

/**
 *  @OA\Tag(
 *      name="Gacha",
 *      description="Gacha API",
 * )
 *  @OA\Schema(
 *      schema="gacha",
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="example",
 *      ),
 *      @OA\Property(
 *          property="category_id",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="company_id",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="selling_price",
 *          type="float",
 *          example="1000.00",
 *      ),
 *      @OA\Property(
 *          property="discounted_price",
 *          type="integer",
 *          example="400",
 *      ),
 *      @OA\Property(
 *          property="discounted_percent",
 *          type="integer",
 *          example="10",
 *      ),
 *      @OA\Property(
 *          property="postage",
 *          type="integer",
 *          example="200",
 *      ),
 *      @OA\Property(
 *          property="status_apply_discounts",
 *          description="1: apply/適用する, 2: not apply/適用しない",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="status_operation",
 *          description="1: 稼働する, 0: 停止するき",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          description="1: pending-wait for approve/保留中, 2: approved/承認, 3: disapproval/否認",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="period_start",
 *          type="string",
 *          example="2022/03/10 09:49:43",
 *      ),
 *      @OA\Property(
 *          property="period_end",
 *          type="string",
 *          example="2022/03/20 09:49:43",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
 *      ),
 *      @OA\Property(
 *          property="quantity",
 *          type="integer",
 *          example=10,
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          type="string",
 *          example="https://picsum.photos/200/300",
 *      ),
 *  )
 *
 *  @OA\Schema(
 *      schema="review",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="order_id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="integer",
 *          example="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
 *      ),
 *      @OA\Property(
 *          property="rating",
 *          type="string",
 *          example="3.99",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="integer",
 *          example=2,
 *      ),
 *  ),
 *  @OA\Schema(
 *      schema="product",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="gacha_id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="integer",
 *          example="Lorem Ipsum",
 *      ),
 *      @OA\Property(
 *          property="quantity",
 *          type="string",
 *          example="3",
 *      ),
 *      @OA\Property(
 *          property="attachment",
 *          type="string",
 *          example="https://picsum.photos/200/300",
 *      ),
 *      @OA\Property(
 *          property="reward_percent",
 *          type="integer",
 *          example="2022-03-23 09:55:16",
 *      ),
 *      @OA\Property(
 *          property="reward_type",
 *          type="string",
 *          example="A賞",
 *      ),
 *      @OA\Property(
 *          property="reward_status",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="integer",
 *          example=1,
 *      ),
 *  )
 */
class GachaController extends Controller
{

    /**
     * @var  GachaBusiness
     */
    protected $gachaBusiness;

    public function __construct(GachaBusiness $gachaBusiness)
    {
        $this->gachaBusiness = $gachaBusiness;
    }

    /**
     * Login user.
     *
     * @param AuthRequest $request
     * @return GachaResource
     *
     *  @OA\Get(
     *      path="/api/gacha",
     *      tags={"Gacha"},
     *      operationId="getListGachaByFilter",
     *      summary="getListGachaByFilter",
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *      @OA\Parameter(ref="#/components/parameters/limit"),
     *      @OA\Parameter(ref="#/components/parameters/sort_field"),
     *      @OA\Parameter(ref="#/components/parameters/sort_type"),
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *      ),
     *      @OA\Parameter(
     *          name="keyword",
     *          in="query",
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          description="1: recommend, 2:favorite: 3: new arrival",
     *          in="query",
     *      ),
     *      @OA\Parameter(
     *          name="category_ids[]",
     *          in="query",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(type="integer")
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price_types[]",
     *          description=" 1:'０～１０００', 2:'１００１～２５００', 3:'２５０１～５０００', 4:'５００１～１００００', 5:'１０００１～'",
     *          in="query",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(type="integer")
     *          )
     *      ),
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
     *                                property="id",
     *                                type="integer",
     *                                example=1
     *                              )
     *                            ),
     *                          @OA\Schema(ref="#/components/schemas/gacha"),
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
     *  )
     */
    public function index(Request $request)
    {
        $defaultConds = ['status' => GACHA_APPROVED];
        if (isset($request->type)) {
            if ((int)$request->type == FAVORITE_TYPE) {
                $defaultConds['sort_field'] = 'orders_count';
                $defaultConds['sort_type'] = DESC;
            } else {
                $defaultConds['sort_field'] = 'created_at';
                $defaultConds['sort_type'] = DESC;
            }
        }
        $conditions = array_merge($request->all(), $defaultConds);

        $list = $this->gachaBusiness->list($conditions);

        return response()->success(GachaResource::collection($list));
    }

    /**
     * Get Gacha by id with 1 image is newest
     *
     * @param App\Models\GaCha $gacha
     *
     *  @OA\Post(
     *      path="/api/gacha/buy/{id}",
     *      tags={"Gacha"},
     *      operationId="buyGacha",
     *      summary="buyGacha",
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
     *                  property="user_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="coupon_code",
     *                  type="string",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="quantity",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="amount",
     *                  type="numeric",
     *                  example="1000"
     *              ),
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
     *                      property="D賞",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              example=1,
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              example="Product 1",
     *                          ),
     *                          @OA\Property(
     *                              property="attachment",
     *                              type="string",
     *                              example="https://picsum.photos/200/300",
     *                          ),
     *                          @OA\Property(
     *                              property="reward_type",
     *                              type="string",
     *                              example="D賞",
     *                          ),
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="A賞",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              example=1,
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              example="Product 1",
     *                          ),
     *                          @OA\Property(
     *                              property="attachment",
     *                              type="string",
     *                              example="https://picsum.photos/200/300",
     *                          ),
     *                          @OA\Property(
     *                              property="reward_type",
     *                              type="string",
     *                              example="A賞",
     *                          ),
     *                      )
     *                  ),
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function buyGacha(BuyGachaRequest $request, Gacha $gacha)
    {
        $data = $this->gachaBusiness->buyGacha($gacha, $request->all());

        return response()->success($data);
    }

    /**
     * Get Gacha by id with 1 image is newest
     *
     * @param App\Models\GaCha $gacha
     *
     *  @OA\Get(
     *      path="/api/gacha/{id}/reviews/",
     *      tags={"Gacha"},
     *      operationId="getGachaReviewList",
     *      summary="getGachaReviewList",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id of gacha",
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
     *                  property="avg_rating",
     *                  type="numeric",
     *                  example="4.060000"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/review"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="company_name",
     *                              type="string",
     *                              example="喜嶋 美加子"
     *                          ),
     *                          @OA\Property(
     *                              property="company_furigana",
     *                              type="string",
     *                              example="三宅 春香"
     *                          ),
     *                      ),
     *                  }
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function getListGachaReview(Request $request, $id)
    {
        $data = $this->gachaBusiness->getListGachaReview($id, $request->all());

        return response()->success($data);
    }

    /**
     * Get Gacha by id with 1 image is newest
     *
     * @param App\Models\GaCha $gacha
     *
     *  @OA\Get(
     *      path="/api/gacha-by-id/{id}",
     *      tags={"Gacha"},
     *      operationId="getGachaById",
     *      summary="getGachaById",
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
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/gacha"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="images",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(
     *                                      property="id",
     *                                      type="integer",
     *                                      example=3,
     *                                  ),
     *                                  @OA\Property(
     *                                      property="gacha_id",
     *                                      type="integer",
     *                                      example=1,
     *                                  ),
     *                                  @OA\Property(
     *                                      property="attachment",
     *                                      type="string",
     *                                      example="https://picsum.photos/200/300",
     *                                  ),
     *                              )
     *                          )
     *                      ),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="product",
     *                              type="array",
     *                              @OA\Items(
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1,
     *                                 ),
     *                                 @OA\Property(
     *                                     property="name",
     *                                     type="string",
     *                                     example="Product 1",
     *                                 ),
     *                                 @OA\Property(
     *                                     property="attachment",
     *                                     type="string",
     *                                     example="https://picsum.photos/200/300",
     *                                 ),
     *                                 @OA\Property(
     *                                     property="reward_type",
     *                                     type="string",
     *                                     example="A賞",
     *                                 ),
     *                              ),
     *                          ),
     *                      )
     *                  }
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getGachaById($id)
    {
        $data = $this->gachaBusiness->getGachaById($id);

        return response()->success($data);
    }

    /**
     * Event like gacha of user.
     *
     *  @OA\Post(
     *      path="/api/favorite/like",
     *      tags={"Gacha"},
     *      operationId="likeGacha",
     *      summary="likeGacha",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="gacha_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Like a gacha",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Property(
     *                      property="status",
     *                      type="string",
     *                      example="false"
     *                  ),
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function eventLikeGacha(Request $request)
    {
        $result = $this->gachaBusiness->eventLikeGacha($request->all());

        return response()->success(['status' => $result]);
    }

    /**
     * Event unlike gacha of user.
     *
     *  @OA\Post(
     *      path="/api/favorite/unlike",
     *      tags={"Gacha"},
     *      operationId="unLikeGacha",
     *      summary="unLikeGacha",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="gacha_id",
     *                  type="integer",
     *                  example="1"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Unlike a gacha",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Property(
     *                      property="status",
     *                      type="string",
     *                      example="false"
     *                  ),
     *              ),
     *          ),
     *      ),
     *      security={
     *          {"bearerAuth": {}}
     *      }
     *  )
     */
    public function eventUnLikeGacha(Request $request)
    {
        $result = $this->gachaBusiness->eventUnLikeGacha($request->all());

        return response()->success(['status' => $result]);
    }

    /**
     * Get Gacha by id with 1 image is newest
     *
     *  @OA\Get(
     *      path="/api/gacha/favorite/list",
     *      tags={"Gacha"},
     *      operationId="getListGachaFavoritesByUserId",
     *      summary="getListGachaFavoritesByUserId",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
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
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Gacha 1",
     *                      ),
     *                      @OA\Property(
     *                          property="image_url",
     *                          type="string",
     *                          example="https://picsum.photos/200/300",
     *                      ),
     *                      @OA\Property(
     *                          property="status_operation",
     *                          description="1: 稼働する, 0: 停止するき",
     *                          type="integer",
     *                          example="1",
     *                      ),
     *                      @OA\Property(
     *                          property="period_start",
     *                          type="string",
     *                          example="2022/03/10 09:49:43",
     *                      ),
     *                      @OA\Property(
     *                          property="period_end",
     *                          type="string",
     *                          example="2022/03/20 09:49:43",
     *                      ),
     *                  ),
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
    public function getListGachaFavoritesByUserId(Request $request)
    {
        try {
            $results = $this->gachaBusiness->getListGachaFavoritesByUserId($request->all());

            if (!empty($results)) {
                return response()->success(GachaFavoriteResource::collection($results));
            } else {
                return response()->success(GachaFavoriteResource::collection([]));
            }
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }
}
