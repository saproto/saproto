<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public int          $id,
        public string       $name,
        public string       $calling_name,
        public string       $email,
        public bool         $is_member,
        public ?MemberData  $member,
        public string       $photo_preview,
        public string       $theme,
        public ?string      $welcome_message,
        public ?bool        $phone,
        public ?string      $birthdate,
        public ?string      $edu_username,
        public ?string      $utwente_username,
        public ?string      $website,
        public bool         $is_protube_admin,
        public bool         $address_visible,
        public bool         $did_study_create,
        public bool         $did_study_itech,
        public bool         $profile_in_almanac,
        public bool         $show_achievements,
        public bool         $keep_omnomcom_history,
        public bool         $disable_omnomcom,
        public bool         $show_omnomcom_calories,
        public bool         $show_omnomcom_total,
        public bool         $show_birthday,
        public bool         $phone_visible,
        public bool         $receive_sms,
        public ?AddressData $address,
        public ?BankData    $bank,
    )
    {
    }
}
