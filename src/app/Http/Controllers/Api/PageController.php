<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Resources\Api\Pages\PageResource;
use App\Business\PageBusiness;

/**
 *  @OA\Tag(
 *      name="Static Page",
 *      description="Static Page API",
 * )
 *  @OA\Schema(
 *      schema="staticPage",
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
 *          property="slug",
 *          type="string",
 *          description="To identify the static page",
 *          example="Term",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="integer",
 *          description="1: publish/公開, 2: unpublish/非公開, 3:draft/下書き",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="integer",
 *          description="1: プライバシーポリシー登録, 2: 特定商取引に関する表記登録, 3: 利用規約登録, 4: 資金決済法に関する表記登録, 5: コンプライアンスポリシー登録",
 *          example=1
 *      ),
 *  )
 */
class PageController extends Controller
{
    /**
     * @var  PageBusiness
     */
    protected $pageBusiness;

    public function __construct(PageBusiness $pageBusiness)
    {
        $this->pageBusiness = $pageBusiness;
    }

    /**
     * Page list.
     *
     * @param AuthRequest $request
     * @return UserCreditCardResource
     *
     *  @OA\Get(
     *      path="/api/page",
     *      tags={"Static Page"},
     *      operationId="getPageList",
     *      summary="getPageList",
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
     *                  @OA\Items(ref="#/components/schemas/staticPage")
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
        $conditions = array_merge($request->all(), ['sort_type' => ASC, 'status' => STATIC_PAGE_PUBLIC]);

        $list = $this->pageBusiness->list($conditions);

        return PageResource::collection($list);
    }


    /**
     * Get static page by type
     *
     *  @OA\Get(
     *      path="/api/page/{type}",
     *      tags={"Static Page"},
     *      operationId="getPageWithType",
     *      summary="getPageWithType",
     *      @OA\Parameter(
     *          name="type",
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
     *                      property="message",
     *                      type="string",
     *                      example="An authorization code has been sent to your email address."
     *                  )
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
     *                      example="This e-mail address is not registered."
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getPageWithType($type)
    {
        try {
            $conds = [
                'type' => $type
            ];

            $page = $this->pageBusiness->findByCondition($conds)->first();

            return response()->success($page);
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }
}
