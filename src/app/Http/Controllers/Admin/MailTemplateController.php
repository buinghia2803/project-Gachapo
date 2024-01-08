<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FlashMessageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MailTemplate\CreateRequest;
use App\Business\MailTemplateBusiness;
use Illuminate\Support\Facades\DB;
use Exception;

class MailTemplateController extends Controller
{

    protected $mailTemplateBusiness;

    public function __construct(MailTemplateBusiness $mailTemplateBusiness)
    {
        $this->mailTemplateBusiness = $mailTemplateBusiness;
    }

    public function index(Request $request)
    {
        $templates = $this->mailTemplateBusiness->getListMailTemplate();
        $templatesTypeInfo = $this->mailTemplateBusiness->getTypeInfo();
        $currentType = $request->type ?? MAIL_TEMPLATES_REGISTRATION;

        return view('admin.mail-templates.index', compact('templatesTypeInfo', 'templates', 'currentType'));
    }

    public function store(CreateRequest $request)
    {
        $this->mailTemplateBusiness->createSessionTab($request);
        if ($request->validated()) {
            DB::beginTransaction();
            try {
                $this->mailTemplateBusiness->store($request);
                FlashMessageHelper::setMessage(
                    request(),
                    config('options.messages.type.success'),
                    __('messages.CM001_L006')
                );
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                FlashMessageHelper::setMessage(
                    request(),
                    config('options.messages.type.error'),
                    __('messages.MT001_MSG003')
                );
            }
            return redirect()->back();
        }
    }
}
