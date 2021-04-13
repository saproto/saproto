<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Proto\Http\Controllers\LdapController;
use Proto\Mail\FeeEmail;
use Proto\Mail\FeeEmailForBoard;
use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\Product;

class FeeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:feecron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that takes care of charging the membership fee.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (intval(date('n')) == 8 || intval(date('n')) == 9) {
            $this->info('We don\'t charge membership fees in August or September.');

            return;
        }

        if (intval(date('n')) >= 9) {
            $yearstart = intval(date('Y'));
        } else {
            $yearstart = intval(date('Y')) - 1;
        }

        $ldap_students = LdapController::searchUtwente('|(department=*B-CREA*)(department=*M-ITECH*)');

        $names = [];
        $emails = [];
        $usernames = [];

        foreach ($ldap_students as $student) {
            $names[] = strtolower($student->givenname.' '.$student->sn);
            $emails[] = strtolower($student->userprincipalname);
            $usernames[] = $student->uid;
        }

        $already_paid = OrderLine::whereIn('product_id', array_values(config('omnomcom.fee')))->where('created_at', '>=', $yearstart.'-09-01 00:00:01')->get()->pluck('user_id')->toArray();

        $charged = (object) [
            'count'    => 0,
            'regular'  => [],
            'reduced'  => [],
            'remitted' => [],
        ];

        foreach (Member::all() as $member) {
            if (in_array($member->user->id, $already_paid) || $member->pending) {
                continue;
            }

            $email_remmitance_reason = null;
            $email_fee = null;

            if ($member->is_lifelong || $member->is_honorary || $member->is_donator) {
                $fee = config('omnomcom.fee')['remitted'];
                $email_fee = 'remitted';
                if ($member->is_honorary) {
                    $reason = 'Honorary Member';
                    $email_remmitance_reason = 'you are an honorary member';
                } elseif ($member->is_lifelong) {
                    $reason = 'Lifelong Member';
                    $email_remmitance_reason = 'you signed up for life-long membership when you became a member';
                } else {
                    $reason = 'Donator';
                    $email_remmitance_reason = 'you are a donator of the association, and your donation is not handled via the membership fee system';
                }
                $charged->remitted[] = $member->user->name.' (#'.$member->user->id.") - $reason";
            } elseif (in_array(strtolower($member->user->email), $emails) || in_array($member->user->utwente_username, $usernames) || in_array(strtolower($member->user->name), $names)) {
                $fee = config('omnomcom.fee')['regular'];
                $email_fee = 'regular';
                $charged->regular[] = $member->user->name.' (#'.$member->user->id.')';
            } else {
                $fee = config('omnomcom.fee')['reduced'];
                $email_fee = 'reduced';
                $charged->reduced[] = $member->user->name.' (#'.$member->user->id.')';
            }

            $charged->count++;

            $product = Product::findOrFail($fee);
            $product->buyForUser($member->user, 1, null, null, null, null, 'membership_fee_cron');

            Mail::to($member->user)->queue((new FeeEmail($member->user, $email_fee, $product->price, $email_remmitance_reason))->onQueue('high'));
        }

        if ($charged->count > 0) {
            Mail::queue((new FeeEmailForBoard($charged))->onQueue('high'));
        }

        $this->info('Charged '.$charged->count.' of '.Member::count().' members their fee.');
    }
}
