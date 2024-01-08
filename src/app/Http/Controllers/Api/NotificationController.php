<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Notifications\NotificationResource;
use App\Business\NotificationBusiness;
use App\Models\Notification;

/**
 *  @OA\Tag(
 *      name="Notification",
 *      description="Notification API",
 * )
 *  @OA\Schema(
 *      schema="notification",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          example="Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
 *      ),
 *      @OA\Property(
 *          property="start_time",
 *          type="string",
 *          example="20/10/2021",
 *      ),
 *      @OA\Property(
 *          property="end_time",
 *          type="string",
 *          example="20/03/2022"
 *      ),
 *      @OA\Property(
 *          property="attachment",
 *          type="string",
 *          example="https://picsum.photos/200/300"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="integer",
 *          description="1: user/個人向け, 2: company/企業向け",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="integer",
 *          description="1: publish/公開, 2: unpublish/非公開",
 *          example=1
 *      ),
 *  )
 */
class NotificationController extends Controller
{
  /**
   * @var  NotificationBusiness
   */
  protected $pageBusiness;

  public function __construct(NotificationBusiness $pageBusiness)
  {
    $this->pageBusiness = $pageBusiness;
  }

  /**
   * Notification list.
   *
   * @param AuthRequest $request
   * @return UserCreditCardResource
   *
   *  @OA\Get(
   *      path="/api/user/notification",
   *      tags={"Notification"},
   *      operationId="getNotificationList",
   *      summary="getNotificationList",
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
   *                    @OA\Property(
   *                        property="id",
   *                        type="integer",
   *                        example=1,
   *                    ),
   *                    @OA\Property(
   *                        property="title",
   *                        type="string",
   *                        example="Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
   *                    ),
   *                    @OA\Property(
   *                        property="start_time",
   *                        type="string",
   *                        example="20/10/2021",
   *                    ),
   *                    @OA\Property(
   *                        property="end_time",
   *                        type="string",
   *                        example="20/03/2022"
   *                    ),
   *                    @OA\Property(
   *                        property="attachment",
   *                        type="string",
   *                        example="https://picsum.photos/200/300"
   *                    ),
   *                 )
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
    $conditions = array_merge($request->all(), ['type' => NOTIFICATION_TYPE_USER]);

    $list = $this->pageBusiness->list($conditions);

    return NotificationResource::collection($list);
  }

  /**
   * Get notification detail by id.
   *
   * @param  \App\Models\Notification $notification
   * @return  \Illuminate\Http\Response
   *
   *  @OA\Get(
   *      path="/api/user/notification/{id}",
   *      tags={"Notification"},
   *      operationId="getNotificeById",
   *      summary="getNotificeById",
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
   *                        property="id",
   *                        type="integer",
   *                        example=1,
   *                    ),
   *                    @OA\Property(
   *                        property="title",
   *                        type="string",
   *                        example="Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
   *                    ),
   *              ),
   *          ),
   *      ),
   *    security={
   *          {"bearerAuth": {}}
   *      }
   *  )
   */
  public function getNotificeById(Notification $notification)
  {
    return response()->success(new NotificationResource($notification));
  }
}
