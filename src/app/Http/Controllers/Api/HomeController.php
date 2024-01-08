<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Top\HomeResource;
use Illuminate\Http\Request;
use App\Business\HomeBusiness;

/**
 *  @OA\Tag(
 *      name="Home",
 *      description="Home API",
 * )
 *
 *  @OA\Schema(
 *      schema="banner",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          example="Image product of gacha",
 *      ),
 *      @OA\Property(
 *          property="link",
 *          type="string",
 *          example="http://127.0.0.1:8000/",
 *      ),
 *      @OA\Property(
 *          property="attachment",
 *          type="string",
 *          example="https://picsum.photos/200/300",
 *      ),
 *  ),
 * 
 * @OA\Schema(
 *      schema="gachaInfoHome",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Image product of gacha",
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          type="string",
 *          example="https://picsum.photos/200/300"
 *      ),
 *      @OA\Property(
 *          property="quantity",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="selling_price",
 *          type="float",
 *          example="1000.00",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Testtttt",
 *      ),
 *  )
 */
class HomeController extends Controller
{
    /**
     * @var  HomeBusiness
     */
    protected $homeBusiness;

    public function __construct(HomeBusiness $homeBusiness)
    {
        $this->homeBusiness = $homeBusiness;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/home",
     *      tags={"Home"},
     *      operationId="getInfoHomePage",
     *      summary="getInfoHomePage",
     *      @OA\Response(
     *          response=200,
     *          description="Information of banner, slide and gacha",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="visual",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/banner")
     *              ),
     *              @OA\Property(
     *                  property="banner",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/banner")
     *              ),
     *              @OA\Property(
     *                  property="new_arrivals",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/gachaInfoHome")
     *              ),
     *              @OA\Property(
     *                  property="favorites",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/gachaInfoHome")
     *              ),
     *              @OA\Property(
     *                  property="recommends",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/gachaInfoHome")
     *              ),
     *          )
     *      ),
     *  )
     */
    public function index(Request $request)
    {
        $data = $this->homeBusiness->getInfoHomePage($request->all());

        return response()->success(new HomeResource($data));
    }
}
