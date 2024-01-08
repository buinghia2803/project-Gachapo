<?php

namespace App\Business;

use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Auth;

class CompanyBusiness extends BaseBusiness
{
    protected CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        parent::__construct($companyRepository);
        $this->companyRepository = $companyRepository;
    }

    public function getListStatus()
    {
        return $this->companyRepository->getListStatus();
    }

    public function getListStatusApprove()
    {
        return $this->companyRepository->getListStatusApprove();
    }

    public function create($data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            if (isset($data['registered_copy_attachment']) && $data['registered_copy_attachment']) {
                $imageUrl = UploadHelper::doUploadS3($data['registered_copy_attachment']);
                if ($imageUrl) {
                    $data['registered_copy_attachment'] = 'uploads/' . $imageUrl;
                } else {
                    $data['registered_copy_attachment'] = '';
                }
            }

            return $this->companyRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->companyRepository->update($data, $id);
    }
    /**
   * Event Update Profile.
   * @param collection $data
   *
   * @return collection
   */
    public function updateProfile($data, $id)
    {
        if (isset($data['registered_copy_attachment']) && $data['registered_copy_attachment']) {
            $imageUrl = UploadHelper::doUploadS3($data['registered_copy_attachment']);
            $imageLink = '';
            if ($imageUrl) {
                $imageLink = UploadHelper::getUrlImage($imageUrl);
            }
            $data['registered_copy_attachment'] = $imageLink;
        }
        
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->companyRepository->updateProfile($data, $id);
    }

    /*
    * Forgot password company
    */
    public function sendResetLinkEmail($request)
    {
        return $this->companyRepository->sendResetLinkEmail($request);
    }

    /*
    * Show reset form company
    */
    public function showResetForm($token, $email)
    {
        return $this->companyRepository->showResetForm($token, $email);
    }

    /*
    * reset company
    */
    public function rest($request, $token)
    {
        return $this->companyRepository->rest($request, $token);
    }

    /*
    * Get gachaID by company
    */
    public function getGachaIdsByCompany()
    {
        return $this->companyRepository->getGachaIdsByCompany();
    }

    /*
    * Get gachaID by company
    */
    public function sendWithdrawalCompanyEmail ()
    {
        return $this->companyRepository->withdrawal ();
    }
}
