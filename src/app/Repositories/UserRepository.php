<?php


namespace App\Repositories;


use App\Models\User as UserApi;
use App\Models\UserHistory;
use App\Models\Gacha;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    protected GachaRepository $gachaRepository;
    protected $app;
    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app, GachaRepository $gachaRepository)
    {
        parent::__construct($app);
        $this->gachaRepository = $gachaRepository;
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where($column, $data);
                break;
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            case 'status':
                return $query->where($column, $data);
                break;
            default:
                return $query;
                break;
        }
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return UserApi::class;
    }

    public function getById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function updateToken(UserApi $user)
    {
        $user->api_token = $user->createToken($user->email)->accessToken;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function getProfile(UserApi $user)
    {
        // Waittinng confirm get count notification
        return $user;
    }

    /**
     * Create user from api.
     */
    public function createUserApi($conds)
    {
        $model = $this->app->make(UserApi::class);

        if (!$model instanceof Model) {
            throw new \Exception("Class {" . UserApi::class . "} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
        $conds['password'] = bcrypt($conds['password']);

        return $this->create($conds);
    }


    /**
     * Given array user status
     * @return array
     */
    public function getListStatus()
    {
        return [
            DEACTIVATE => __('labels.CM001_L026'),
            ACTIVE => __('labels.ADM001_L013'),
            BLACKLIST => __('labels.COC001_L012'),
            WITHDRAWAL => __('labels.COC001_L013'),
        ];
    }

    /**
     * @param mixed $email
     *
     * @return UserApi
     */
    public function getActiveUserByEmail($email)
    {
        return UserApi::where(['email' => $email])->first();
    }

    /**
     * @param mixed $email
     *
     * @return string $token
     */
    public function createResetToken($email, $user)
    {
        $start = Str::random(4);
        $middle = $user->id . 'U';
        $end = Str::random(10 - (strlen($start) + strlen($middle)));
        $secretKey = strtoupper($start . $middle . $end);
        PasswordReset::updateOrCreate(['email' => $email], [
            'expire_time' => Carbon::now()->addSeconds(EXPIRE_TIME_SECRET_KEY)->timestamp,
            'secret_key' => $secretKey
        ]);

        return $secretKey;
    }

    /**
     * Check secret key.
     *
     * @param string $secretKey
     * @param string $email
     */
    public function checkSecretKey($secretKey, $email)
    {
        $passwordReset = PasswordReset::where('email', $email)->where('secret_key', $secretKey)->first();
        if ($passwordReset) {
            $time = $passwordReset->expire_time - Carbon::now()->timestamp;
            if ($passwordReset && $time > 0) {
                return $passwordReset;
            }
        }

        return null;
    }

    /**
     * Remove secret key.
     *
     * @param string $secretKey
     */
    public function deleteSecretKey($secretKey)
    {
        PasswordReset::where('secret_key', $secretKey)->update(['secret_key' => null, 'expire_time' => 0]);
    }


    /**
     * Reset password
     *
     * @param array $conditions
     */
    public function passwordReset($conditions)
    {
        $result = PasswordReset::where('secret_key', $conditions['secret_key'])->first();
        $time = $result->expire_time - Carbon::now()->timestamp;
        if (isset($result->email) && $time > 0) {
            $user = $this->model->where('email', $result->email)->first();
            if ($user) {
                return $user->update([
                    'password' => bcrypt($conditions['password'])
                ]);
            }
        }

        return $user;
    }

    /**
     * Get browser history of user.
     *
     * @param App\Models\User $user
     * @return Collection $list
     */
    public function getBrowsingHistoryGacha($user)
    {
        try {
            $user->with(['histories']);
            $gachaIds = $user->histories->pluck('gacha_id')->toArray();

            $selectable = [
                'id',
                'name',
                'company_id',
                'selling_price',
                'discounted_price',
                'discounted_price',
                'period_start',
                'period_end',
                'status_operation',
                'status'
            ];
            $prodSelectable = ['id', 'quantity', 'gacha_id', 'reward_status'];
            $list = $this->gachaRepository->findByCondition(
                [
                    'ids' => $gachaIds
                ],
                [
                    'images' => function ($query) {
                        return $query->select('id', 'gacha_id', 'attachment')->orderBy('updated_at', DESC)->limit(1);
                    },
                    'products' => function ($query) use ($prodSelectable) {
                        return $query->select($prodSelectable);
                    },
                ],
                $selectable
            )->orderBy('updated_at', DESC)->limit(5)->get();

            return $list;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get user is withdraw.
     * @param string $email
     */
    public function getUserWithdraw($email)
    {
        return UserApi::onlyTrashed()->where('email', $email)->first();
    }
}
