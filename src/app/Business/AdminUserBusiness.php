<?php
namespace App\Business;

use App\Repositories\AdminUserRepository;

class AdminUserBusiness extends BaseBusiness
{
    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->repository = $adminUserRepository;
    }

    public function getListRole()
    {
        $role_admins = \App\Models\Role::where('guard_name', ROLE_ADMIN)->get();
        $role_admins->map(function ($row) {
            if($row->name == ROLE_ADMIN) {
                $row->title = __('labels.ADM001_L005');
            } else {
                $row->title = __('labels.ADM001_L006');
            }
            return $row;
        });
        return $role_admins;
    }

    public function createRecord($params)
    {
        $params['password'] = \Hash::make($params['password']);
        $data = $this->create($params);
        return $data;
    }

    public function updateRecord($id, $params)
    {
        if (isset($params['password'])) {
            $params['password'] = \Hash::make($params['password']);
        } else {
            unset($params['password']);
        }
        $data = $this->update($id, $params);
        return $data;
    }
}
