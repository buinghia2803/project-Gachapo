<?php

namespace App\Business;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Services\StripeService;
use App\Models\User;
use App\Jobs\SendMailTemplate;
use App\Jobs\Verification2ndFactorJob;

class UserBusiness extends BaseBusiness
{
    protected UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
        UserCreditCardBusiness $userCreditCardBusiness,
        StripeService $stripeService
    ) {
        parent::__construct($userRepository);
        $this->userCreditCardBusiness = $userCreditCardBusiness;
        $this->stripeService = $stripeService;
    }

    /**
     * Find user by id.
     * @param int $id
     */
    public function findById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Create token for user.
     */
    public function updateToken($id)
    {
        return $this->repository->updateToken($id);
    }

    /**
     * Create token for user.
     */
    public function getProfile($user)
    {
        return $this->repository->getProfile($user);
    }

    /**
     * Create user and card.
     * @param array $conds
     */
    public function createUserAndCard($conds)
    {
        try {
            DB::beginTransaction();
            $cardInfo = null;
            // Create customer on Stripe Service.
            $customerStripe = $this->stripeService->createCustomerStripe([
                'name' => $conds['name'] ?? '',
                'email' => $conds['email'] ?? ''
            ]);
            $user = $this->repository->createUserApi($conds);
            $conds['customer_id'] = $customerStripe->id;
            $cardConds = [
                'card_number' => str_replace(' ', '', $conds['card_number']),
                'expiration_date' => explode('/', $conds['date_of_expiry']),
                'cvc' => $conds['security_code'],
            ];
            $responseCard = $this->stripeService->createCardStripe($cardConds, $conds['customer_id']);
            $conds['card_number'] = $responseCard->last4 ?? '';
            if ($user) {
                $conds['stripe_card_id'] = $responseCard->id ?? '';
                $conds['fingerprint'] = $responseCard->fingerprint ?? '';
                $conds['user_id'] = $user->id;
                $cardInfo = $this->userCreditCardBusiness->create($conds);
                foreach ($cardInfo->attributesToArray() as $key => $value) {
                    $user[$key] = $value;
                }
            }
            // Send Mail
            SendMailTemplate::dispatch(MAIL_TEMPLATES_REGISTRATION, $conds['email'], ['links' => $conds['links']]);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[UserBusiness->createUserAndCard:' . __LINE__ . ']: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Send mail verification for user.
     * @param string $email
     */
    public function sendMailRegisterCompleted($email)
    {
        $this->repository->findByCondition(['email' => $email])->first()->update(['status' => ACTIVE]);
        SendMailTemplate::dispatch(MAIL_TEMPLATES_COMPLETED_MEMBERSHIP_REGISTRATION, $email);
    }

    /**
     * Send mail Universal 2nd Factor
     */
    public function sendMail2ndFactor($user)
    {
        $expiredTime = now()->addMinutes(EXPIRED_2ND_FACTOR)->timestamp;
        $scretkey = $this->encryptDecrypt(ENCRYPT, $expiredTime);
        Verification2ndFactorJob::dispatch($user, $scretkey)->onQueue('high');
    }

    /**
     * Check secret key.
     */
    public function verify2ndFactor($secret_key)
    {
        $time = (int) $this->encryptDecrypt(DECRYPT, $secret_key);

        if ($time) {
            if ($time > now()->timestamp) {
                return ['status' => true];
            } else {
                return ['status' => false, 'code' => 'expired', 'message' => '確認コードの有効期限が切れています'];
            }
        } else {
            return ['status' => false, 'code' => 'not_exist_code', 'message' => '認証コードが存在しません'];
        }
    }

    /**
     * Update model.
     *
     * @param Model $entity
     * @param array $data
     *
     * @return Model
     */
    public function updateModel(User $entity, $data = [])
    {
        try {
            $entity->update($data);
            $entity->load('creditCard');
            if ($entity->creditCard) {
                $entity->creditCard->update($data);
            }

            return $entity;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Given list user status
     * @return array
     */
    public function getListStatus()
    {
        return $this->repository->getListStatus();
    }

    /**
     * Get user by email.
     * @param mixed $email
     *
     * @return UserApi
     */
    public function getActiveUserByEmail($email)
    {
        return $this->repository->getActiveUserByEmail($email);
    }

    /**
     * Create token password reset.
     *
     * @param mixed $email
     * @return string $token
     */
    public function createResetToken($email, $user)
    {
        return $this->repository->createResetToken($email, $user);
    }

    /**
     * Check secret key.
     * @param string $secretKey
     * @param string $email
     */
    public function checkSecretKey($secretKey, $email)
    {
        return $this->repository->checkSecretKey($secretKey, $email);
    }

    /**
     * Remove secret key.
     *
     * @param string $secretKey
     */
    public function deleteSecretKey($secretKey)
    {
        return $this->repository->deleteSecretKey($secretKey);
    }

    /**
     * Reset password
     * @param array $conditions
     */
    public function passwordReset($conditions)
    {
        return $this->repository->passwordReset($conditions);
    }

    /**
     * Update user.
     * @param int $id
     * @param array $data
     */
    public function update($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repository->update($data, $id);
    }

    /**
     * Update information shipping of user.
     * @param Model $entity
     * @param array $data
     *
     * @return Model
     */
    public function updateInfoShipping(User $user, $data)
    {
        $user->update($data);

        return $user;
    }

    /**
     * Simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     *
     * @param string $action: can be 'encrypt' or 'decrypt'
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    public function encryptDecrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        // hash
        $key = hash('sha256', SECRET_KEY_AES_256_CBC);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', SECRET_IV_AES_256_CBC), 0, 16);
        if ($action == ENCRYPT) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == DECRYPT) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * Get browser history of user
     *
     * @param App\Models\User $user
     * @return Collection $list
     */
    public function getBrowsingHistoryGacha(User $user)
    {
        return $this->repository->getBrowsingHistoryGacha($user);
    }

    /**
     * Get user is withdraw
     * @param string $email
     */
    public function getUserWithdraw($email)
    {
        return $this->repository->getUserWithdraw($email);
    }
}
