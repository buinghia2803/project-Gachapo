<?php

namespace App\Business;

use App\Repositories\UserCreditCardRepository;
use App\Services\StripeService;

class UserCreditCardBusiness extends BaseBusiness
{
  protected UserCreditCardRepository $userCreditCardRepository;

  public function __construct(
    UserCreditCardRepository $userCreditCardRepository,
    StripeService $stripeService
  ) {
    parent::__construct($userCreditCardRepository);
    $this->stripeService = $stripeService;
    $this->userCreditCardRepository = $userCreditCardRepository;
  }

  /**
   * Event create credit card.
   * @param array $conds.
   */
  public function create($conds)
  {
    try {
      $cardConds = [
        'card_number' => $conds['card_number'],
        'expiration_date' => explode('/', $conds['date_of_expiry']),
        'cvc' => $conds['security_code'],
      ];
      $responseCard = $this->stripeService->createCardStripe($cardConds, $conds['customer_id']);
      $conds['card_number'] = $responseCard->last4 ?? '';
      $conds['stripe_card_id'] = $responseCard->id ?? '';
      $conds['fingerprint'] = $responseCard->fingerprint ?? '';
      $conds['user_id'] = $conds['user_id'] ?? '';

      return $this->repository->create($conds);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

  /**
   * Event create credit card.
   * @param array $conds.
   */
  public function update($card, $conds)
  {
    try {
      $cardConds = [
        'card_number' => $conds['card_number'],
        'expiration_date' => explode('/', $conds['date_of_expiry']),
        'cvc' => $conds['security_code'],
      ];
      $responseCard = $this->stripeService->updateCardStripe($conds['customer_id'], $card->stripe_card_id, $cardConds);
      $conds['card_number'] = $responseCard->last4 ?? '';
      $conds['stripe_card_id'] = $responseCard->id ?? '';
      $conds['fingerprint'] = $responseCard->fingerprint ?? '';
      $conds['user_id'] = $conds['user_id'] ?? '';

      return $this->repository->update($conds, $card->id);
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}
