<?php

namespace App\Business;

use App\Repositories\ContactRepository;
use App\Repositories\AdminUserRepository;
use App\Jobs\SendMailtRegisterContactJob;

class ContactBusiness extends BaseBusiness
{
  protected ContactRepository $contactRepository;
  protected AdminUserRepository $adminRepository;

  public function __construct(ContactRepository $contactRepository, AdminUserRepository $adminRepository)
  {
    parent::__construct($contactRepository);
    $this->contactRepository = $contactRepository;
    $this->adminRepository = $adminRepository;
  }

  /**
   * Event create contact.
   * @param array $input
   * @return collection
   */
  public function create($input)
  {
    $admins = $this->adminRepository->findByCondition([])->get();
    foreach ($admins as $admin) {
      SendMailtRegisterContactJob::dispatch($admin->email, $input);
    }

    return $this->repository->create($input);
  }
}
