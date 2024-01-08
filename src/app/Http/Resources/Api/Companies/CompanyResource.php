<?php

namespace App\Http\Resources\Api\Companies;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param    \Illuminate\Http\Request  $request
   * @return  array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'company' => $this->company,
      'company_furigana' => $this->company_furigana,
      'person_manager' => $this->person_manager,
      'person_manager_furigana' => $this->person_manager_furigana,
      'phone' => $this->phone,
      'email' => $this->email,
      'company_information' => $this->company_information,
      'site_url' => $this->site_url,
      'company_address' => $this->company_address,
      'registered_copy_attachment' => $this->registered_copy_attachment,
      'bank_name' => $this->bank_name,
      'branch_name' => $this->branch_name,
      'bank_code' => $this->bank_code,
      'branch_code' => $this->branch_code,
      'bank_type' => $this->bank_type,
      'bank_number' => $this->bank_number,
      'bank_holder' => $this->bank_holder,
      'commission' => $this->commission,
      'status_two_step_verification' => $this->status_two_step_verification,
      'status_notifice' => $this->status_notifice,
      'status' => $this->status,
      'status_approve' => $this->status_approve,
    ];
  }
}
