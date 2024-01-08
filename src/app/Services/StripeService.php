<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class StripeService
{
  protected $currency = 'JPY';

  private $stripe;

  public function __construct()
  {
    $secretKey = env("STRIPE_SECRET");
    $this->stripe = new StripeClient($secretKey);
  }

  /**
   * Set currency.
   * @param string $currency
   */
  public function setCurrency($currency)
  {
    $this->currency = $currency;
  }

  /**
   * Create credit card on stripe
   * @param array $cardInfo
   * @param array $customerId
   */
  public function createCardStripe($cardInfo, $customerId)
  {
    try {
      $stripeToken = $this->stripe->tokens->create([
        'card' => [
          'number' => $cardInfo['card_number'],
          'exp_month' => $cardInfo['expiration_date'][0],
          'exp_year' => $cardInfo['expiration_date'][1],
          'cvc' => $cardInfo['cvc'],
        ]
      ]);

      $card = $this->stripe->customers->createSource(
        $customerId,
        ['source' => $stripeToken]
      );

      return $card;
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error($e->getMessage());

      return false;
    }
  }

  /**
   * Create customer on stripe.
   * @param array $customerInfo
   */
  public function createCustomerStripe($customerInfo)
  {
    try {
      return $this->stripe->customers->create([
        'email' => $customerInfo['email'],
        'name' => $customerInfo['name'],
      ]);
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error($e->getMessage());

      return false;
    }
  }

  /**
   * Delete a customer on stripe.
   * @param string $customerId
   */
  public function deleteCustomerStripe($customerId)
  {
    try {
      return $this->stripe->customers->delete($customerId);
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    }
  }

  /**
   * Update a card on Stripe.
   * @param string $customerId
   * @param string $cardId
   * @param array $cardInfo
   */
  public function updateCardStripe($customerId, $cardId, $cardInfo)
  {
    try {
      return $this->stripe->customers->updateSource(
        $customerId,
        $cardId,
        [
          'exp_month' => $cardInfo['expiration_date'][0],
          'exp_year' => $cardInfo['expiration_date'][1],
        ]
      );
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    }
  }

  /**
   * Delete a card on Stripe.
   * @param string $customerId
   * @param string $cardId
   */
  public function deleteCardStripe($customerId, $cardId)
  {
    try {
      return $this->stripe->customers->deleteSource(
        $customerId,
        $cardId
      );
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());
      return false;
    }
  }

  /**
   * Create a charge on Stripe.
   * @param array $data
   */
  public function createChargeStripe($data)
  {
    try {
      return $this->stripe->charges->create([
        'amount'   => $data['amount'],
        'currency' => $this->currency,
        'customer' => $data['customer_id'],
        'source'   => $data['card_id']
      ]);
    } catch (CardException $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    } catch (\Exception $e) {
      Log::error('[StripeService->createCardStripe]: ' . __LINE__ . $e->getMessage());

      return false;
    }
  }
}
