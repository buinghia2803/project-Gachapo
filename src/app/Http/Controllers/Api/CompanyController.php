<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Business\CompanyBusiness;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Companies\CreateCompanyRequest;
use App\Http\Resources\Api\Companies\CompanyResource;

use function PHPUnit\Framework\isNull;

/**
 *  @OA\Tag(
 *      name="Company",
 *      description="Company API",
 * )
 *  @OA\Schema(
 *      schema="company",
 *      @OA\Property(
 *          property="company",
 *          type="string",
 *          example="Company 1",
 *      ),
 *      @OA\Property(
 *          property="company_furigana",
 *          type="string",
 *          example="こんにちは",
 *      ),
 *      @OA\Property(
 *          property="person_manager",
 *          type="string",
 *          example="Manager",
 *      ),
 *      @OA\Property(
 *          property="person_manager_furigana",
 *          type="string",
 *          example="れつか"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          example="098883332"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="company@example.com"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="Gachapo123"
 *      ),
 *      @OA\Property(
 *          property="company_information",
 *          type="string",
 *          example="But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system"
 *      ),
 *      @OA\Property(
 *          property="company_address",
 *          type="string",
 *          example="東京都港区麻布台1丁目9番地12号"
 *      ),
 *      @OA\Property(
 *          property="registered_copy_attachment",
 *          type="string",
 *          example="https://picsum.photos/200"
 *      ),
 *      @OA\Property(
 *          property="site_url",
 *          type="string",
 *          example="https://picsum.photos/200"
 *      ),
 *      @OA\Property(
 *          property="consent_document",
 *          type="string",
 *          example="https://picsum.photos/200"
 *      ),
 *  )
 *
 */
class CompanyController extends Controller
{

    /**
     * @var  CompanyBusiness
     */
    protected $companyBusiness;

    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Create a company.
     *
     * @param  \App\Http\Requests\Api\Companies\RegisterCompanyRequest $request
     * @return  \Illuminate\Http\Response
     *
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/company",
     *      tags={"Company"},
     *      operationId="registerCompany",
     *      summary="registerCompany",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/company")
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
     *                          @OA\Property(
     *                             property="status_two_step_verification",
     *                             description="0: Un Active, 1: Active",
     *                             type="integer",
     *                             example=0
     *                         ),
     *                         @OA\Property(
     *                             property="status_notifice",
     *                             description="0: Un Active, 1: Active",
     *                             type="integer",
     *                             example=0
     *                         ),
     *                         @OA\Property(
     *                             property="status",
     *                             description="0:temporary account, 1: deactivate/ 無効, 2: active/有効, 3: blacklist/ブラックリスト, 4: withdrawal/退会",
     *                             type="integer",
     *                             example=0
     *                         ),
     *                         @OA\Property(
     *                             property="status_approve",
     *                             description="1: Waiting for approval/承認待ち, 2: Disapproved/非承認, 3: Approved/承認",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="bank_name",
     *                             type="string",
     *                             example="TPBank"
     *                         ),
     *                         @OA\Property(
     *                             property="branch_name",
     *                             type="string",
     *                             example="Hà Nội"
     *                         ),
     *                         @OA\Property(
     *                             property="bank_code",
     *                             type="string",
     *                             example="TPB"
     *                         ),
     *                         @OA\Property(
     *                             property="branch_code",
     *                             type="string",
     *                             example="TPBVVNVX"
     *                         ),
     *                         @OA\Property(
     *                             property="bank_type",
     *                             type="string",
     *                             example="TPBVVNVX"
     *                         ),
     *                         @OA\Property(
     *                             property="bank_number",
     *                             type="string",
     *                             example="003894447"
     *                         ),
     *                         @OA\Property(
     *                             property="bank_holder",
     *                             type="string",
     *                             example="GhZd0thPJyGDPT1"
     *                         ),
     *                         @OA\Property(
     *                             property="commission",
     *                             type="numeric",
     *                             example=1000
     *                         ),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/company"),
     *                  }
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateCompanyRequest $request)
    {
        try {
            // check file upload null
            if (!$request->file('registered_copy_attachment')) {
                return response()->failure('', 400, ['errors' => ['registered_copy_attachment' => ['この項目は必須です。']]], FILE_ERROR_STATUS);
            }
            // check size file upload > 20MB
            if (($request->file('registered_copy_attachment')->getSize() / pow(1024, 2)) > 20) {
                return response()->failure('', 400, ['errors' => ['registered_copy_attachment' => ['※最大アップロードサイズ：20MB']]], FILE_ERROR_STATUS);
            }
            $conds = array_merge($request->all(), [
                'status_two_step_verification' => DEFAULT_STATUS_COMPANY,
                'status_notifice' => DEFAULT_STATUS_COMPANY,
                'status' => DEFAULT_STATUS_COMPANY,
                'status_approve' => DEACTIVATE,
            ]);

            $result = $this->companyBusiness->create($conds);

            return response()->success(new CompanyResource($result));
        } catch (\Exception $e) {
            return response()->failure($e->getMessage());
        }
    }
}
