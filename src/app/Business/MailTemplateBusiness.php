<?php

namespace App\Business;
use App\Helpers\UploadHelper;
use App\Repositories\MailTemplateRepository;

class MailTemplateBusiness extends BaseBusiness
{
    protected $mailTemplateRepository;

    public function __construct(MailTemplateRepository $mailTemplateRepository)
    {
        $this->mailTemplateRepository = $mailTemplateRepository;
    }

    public function getListMailTemplate()
    {
        return $this->mailTemplateRepository->getListMailTemplate();
    }

    public function getTypeInfo()
    {
        return [
            [
                'type' => MAIL_TEMPLATES_REGISTRATION,
                'name' => '仮登録',
            ],
            [
                'type' => MAIL_TEMPLATES_COMPLETED_MEMBERSHIP_REGISTRATION,
                'name' => '完了した会員登録',
            ],
            [
                'type' => MAIL_TEMPLATES_PASSWORD_RESET,
                'name' => 'パスワードの再設定',
            ],
            [
                'type' => MAIL_TEMPLATES_NOTIFICATION_OF_RESERVATION_COMPLETION,
                'name' => '予約完了のお知らせ',
            ],
            [
                'type' => MAIL_TEMPLATES_TEMPORARY_REGISTRATION_OF_COMPANY,
                'name' => '企業の仮登録',
            ],
            [
                'type' => MAIL_TEMPLATES_REPLY_REVIEW,
                'name' => '返信レビュー',
            ],
            [
                'type' => MAIL_TEMPLATES_APPROVE_THE_COMPANY,
                'name' => '会社を承認する',
            ],
            [
                'type' => MAIL_TEMPLATES_DISAPPROVE_THE_COMPANY,
                'name' => '会社を非承認する',
            ],
            [
                'type' => MAIL_TEMPLATES_WITHDRAWAL,
                'name' => '退会',
            ],
            [
                'type' => MAIL_TEMPLATES_DELIVERY,
                'name' => '配送',
            ],
            [
                'type' => MAIL_TEMPLATES_RESERVATION_CANCELLATION_NOTICE,
                'name' => '予約キャンセルのお知らせ',
            ],
        ];
    }

    public function createSessionTab($request)
    {
        $request->session()->flash(SESSION_TEMPLATE_MAIL_TAB, $request->type);
    }

    public function store($request)
    {
        $dataMailTemplate = $this->makeDataMailTemplate($request);
        $this->mailTemplateRepository->store($dataMailTemplate);
    }

    protected function makeDataMailTemplate($request)
    {
        $attachment = null;
        if ($request->attachment) {
            try {
                $imageUrl = UploadHelper::doUploadS3($request->attachment);
                if ($imageUrl) {
                    $attachment = UploadHelper::getUrlImage($imageUrl);
                }
            } catch (\Exception $e) {
                \Log::error('Error at Line:' . $e->getLine() . ' on file ' . $e->getFile() . '. Message:' . $e->getMessage());
            }
        } else if ($request->old_attachment) {
            $attachment = $request->old_attachment;
        } else {
            $attachment = null;
        }

        return [
            'type' => $request->type,
            'subject' => $request->subject,
            'cc' => implode(",", $request->cc ?: []),
            'bcc' => implode(",", $request->bcc ?: []),
            'content' => $request->content,
            'attachment' => $attachment,
        ];
    }

    public function getMailTemplateByType($type)
    {
        return $this->mailTemplateRepository->getMailTemplateByType($type);
    }
}
