<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  @OA\Info(
 *      description="Gachapo API Document",
 *      version="1.0.0",
 *      title="API",
 *  )
 *
 *  @OA\PathItem(path="/api")
 *
 *  @OA\SecurityScheme(
 *      type="http",
 *      in="header",
 *      securityScheme="bearerAuth",
 *      scheme="bearer"
 *  )
 *
 *  @OA\Parameter(
 *      name="page",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="limit",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="sort_field",
 *      in="query",
 *  )
 *
 *  @OA\Parameter(
 *      name="sort_type",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="condition",
 *      in="query",
 *  )
 *
 *    @OA\Schema(
 *      schema="meta",
 *      @OA\Property(
 *          property="current_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="from",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="last_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="path",
 *          type="string",
 *          example="http://abc.com",
 *      ),
 *      @OA\Property(
 *          property="per_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="to",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="total",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 *
 *  @OA\Schema(
 *      schema="links",
 *      @OA\Property(
 *          property="first",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="last",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="prev",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="next",
 *          type="number",
 *          example=1,
 *      )
 *  )
 *
 *  @OA\Schema(
 *      schema="empty"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // System success code
    const CODE_SUCCESS_200 = 200;
    const CODE_SUCCESS_201 = 201;
    const CODE_SUCCESS_203 = 203;
    const CODE_SUCCESS_204 = 204;

    // System error code
    const CODE_ERROR_400 = 400;
    const CODE_ERROR_401 = 401;
    const CODE_ERROR_403 = 403;
    const CODE_ERROR_404 = 404;
    const CODE_ERROR_500 = 404;
}
