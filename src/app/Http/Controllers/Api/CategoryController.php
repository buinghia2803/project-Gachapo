<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Business\CategoryBusiness;
use App\Http\Resources\Api\Categories\CategoryResource;


/**
 *  @OA\Tag(
 *      name="Filter",
 *      description="Filter API",
 * )
 *  @OA\Schema(
 *      schema="category",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Category 1",
 *      ),
 *      @OA\Property(
 *          property="slug",
 *          type="string",
 *          example="Slug 1",
 *      ),
 *  )
 */
class CategoryController extends Controller
{
    /**
     * @var  CategoryBusiness
     */
    protected $categoryBusiness;

    public function __construct(CategoryBusiness $categoryBusiness)
    {
        $this->categoryBusiness = $categoryBusiness;
    }

    /**
     * Page list.
     *
     * @param AuthRequest $request
     * @return UserCreditCardResource
     *
     *  @OA\Get(
     *      path="/api/category",
     *      tags={"Filter"},
     *      operationId="getListOfSearchTerms",
     *      summary="getListOfSearchTerms",
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/category")
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function index()
    {
        $conditions = ['limit' => 0];

        $list = $this->categoryBusiness->list($conditions);

        return CategoryResource::collection($list);
    }
}
