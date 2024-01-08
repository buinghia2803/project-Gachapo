<?php

namespace App\Http\Controllers\Admin;

use App\Business\UserBusiness;
use App\Business\ImageBusiness;
use App\Helpers\ImageHelper;
use App\Business\PageBusiness;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Auth;

class AdminController extends Controller
{
    protected $userBusiness;
    protected $imageBusiness;
    protected PageBusiness $pageBusiness;

    public function __construct(
        UserBusiness $userBusiness,
        ImageBusiness $imageBusiness,
        PageBusiness $pageBusiness
    ) {
        $this->userBusiness = $userBusiness;
        $this->imageBusiness = $imageBusiness;
        $this->pageBusiness = $pageBusiness;
    }

    public function index()
    {
        $staticPageList = $this->pageBusiness->list(['sort_type' => ASC, 'status' => STATIC_PAGE_PUBLIC])->toArray()['data'];
        Session::put('static_page', array_chunk($staticPageList, 4));
        return view('admin.home');
    }

    public function showProfile(Request $request, $id)
    {
        $admin = $this->userBusiness->findById($id);
        $userImage = $this->imageBusiness->getAvatarByUser($id);

        if (!$admin) {
            return abort(404);
        }
        return view('admin.profile', compact('admin', 'userImage'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate(
            [
                'name'                  => 'required|max:255',
                'email'                 => 'required|email|unique:users,email,' . $id,
                'password'              => 'nullable|max:16|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                'password_confirmation' => [
                    Rule::requiredIf($request->get('password') !== null),
                    'nullable',
                    'min:8',
                    'max:16',
                    'same:password'
                ],
            ],
            [
                'name.required'                  => __('messages.CM_MSG001'),
                'name.max'                       => __('messages.CU_MSG001'),
                'email.required'                 => __('messages.CM_MSG001'),
                'email.email'                    => __('messages.CU_MSG008'),
                'email.unique'                   => __('messages.CU_MSG002'),
                'password.max'                   => __('messages.CU_MSG003'),
                'password.min'                   => __('messages.CU_MSG004'),
                'password.regex'                 => __('messages.CU_MSG010'),
                'password_confirmation.required' => __('messages.CM_MSG001'),
                'password_confirmation.max'      => __('messages.UM_MSG003'),
                'password_confirmation.min'      => __('messages.UM_MSG004'),
                'password_confirmation.same'     => __('messages.UM_MSG002'),
            ]
        );
        $input = $request->all();
        $user = $this->userBusiness->findById($id);
        if (!$user) {
            return abort(404);
        }
        $currentImage = $this->imageBusiness->getAvatarByUser($id);
        if ($currentImage) {
            $oldUploadedImages = ['avatar' => $currentImage->image];
        } else {
            $oldUploadedImages = [];
        }

        $uploadedImages = [];
        $imageUrl = '';

        DB::beginTransaction();
        try {
            $data = [
                'name' => $input['name'],
                'email' => $input['email'],
            ];
            if (isset($input['password'])) {
                $data['password'] = Hash::make($input['password']);
            }
            if (isset($input['avatar'])) {
                $imageData = [
                    'item_id' => $id,
                    'type' => USER_IMAGE_TYPE,
                    'is_avatar' => SET_AS_AVATAR
                ];
                $imageUrl = $uploadedImages['avatar'] = UploadHelper::doUpload($input['avatar'], 'uploads/', $imageData)[0];
            }
            $this->userBusiness->update($id, $data);

            DB::commit();
            // Unlink old image
            if ($imageUrl && !empty($oldUploadedImages)) {
                ImageHelper::unlinkImages($oldUploadedImages);
            }

            return redirect()->back()->with([
                'success' => __('messages.CC_MSG007')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error at Line:' . $e->getLine() . ' on file ' . $e->getFile() . '. Message:' . $e->getMessage());
            // Unlink new image if update failed
            ImageHelper::unlinkImages($uploadedImages);
        }
    }
}
