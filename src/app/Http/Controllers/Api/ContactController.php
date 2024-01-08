<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\ContactBusiness;
use App\Http\Requests\Api\Contacts\CreateContactRequest;
use App\Http\Resources\Api\Contacts\ContactResource;

/**
 *  @OA\Tag(
 *      name="Contact",
 *      description="Contact API",
 * )
 *  @OA\Schema(
 *      schema="contact",
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Contact 1",
 *      ),
 *      @OA\Property(
 *          property="contact_type",
 *          type="integer",
 *          description="1: phone/電話で折り返してほしい, 2: email/メールで折り返してほしい",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="contact@example.com",
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          example="098883332"
 *      ),
 *      @OA\Property(
 *          property="inquiry_type",
 *          type="integer",
 *          description="1: 出展について、2: 資料請求、3: ガチャポについて、4: その他について",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="string",
 *          example="But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system"
 *      ),
 *  )
 */
class ContactController extends Controller
{
    /**
     * @var  ContactBusiness
     */
    protected $contactBusiness;

    public function __construct(ContactBusiness $contactBusiness)
    {
        $this->contactBusiness = $contactBusiness;
    }

    /**
     * Create a contact.
     *
     * @param  \App\Http\Requests\Api\Contacts\RegisterContactRequest $request
     * @return  \Illuminate\Http\Response
     *
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/contact",
     *      tags={"Contact"},
     *      operationId="registerContact",
     *      summary="registerContact",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/contact")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              example=1,
     *                          ),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/contact"),
     *                  }
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateContactRequest $request)
    {
        try {
            $result = $this->contactBusiness->create($request->all());

            return response()->success(new ContactResource($result));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }
}
