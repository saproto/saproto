<?php

namespace App\Console\Commands;

use App\Http\Controllers\LdapController;
use App\Mail\FeeEmail;
use App\Mail\FeeEmailForBoard;
use App\Models\Member;
use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

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
    public function handle(): int
    {
        if (intval(date('n')) == 8 || intval(date('n')) == 9) {
            $this->info("We don't charge membership fees in August or September.");

            return 0;
        }

        if (intval(date('n')) == 10) {
            $this->info('Temporarily skipped due to membership issues.');

            return 0;
        }

        $yearstart = intval(date('n')) >= 9 ? intval(date('Y')) : intval(date('Y')) - 1;

        $students = LdapController::searchStudents();
        $names = $students['names'];
        $emails = $students['emails'];
        $usernames = $students['usernames'];

        $already_paid = OrderLine::query()->whereIn('product_id', array_values(Config::array('omnomcom.fee')))->where('created_at', '>=', $yearstart.'-09-01 00:00:01')->get()->pluck('user_id')->toArray();

        $charged = (object) [
            'count' => 0,
            'regular' => [],
            'reduced' => [],
            'remitted' => [],
        ];

        foreach (Member::all() as $member) {
            if (in_array($member->user->id, $already_paid)) {
                continue;
            }

            if ($member->is_pending) {
                continue;
            }

            $reason = null;
            $email_remittance_reason = null;

            if ($member->is_lifelong || $member->is_honorary || $member->is_donor || $member->is_pet) {
                $fee = Config::array('omnomcom.fee')['remitted'];
                $email_fee = 'remitted';
                if ($member->is_honorary) {
                    $reason = 'Honorary Member';
                    $email_remittance_reason = 'you are an honorary member';
                } elseif ($member->is_lifelong) {
                    $reason = 'Lifelong Member';
                    $email_remittance_reason = 'you signed up for life-long membership when you became a member';
                } elseif ($member->is_pet) {
                    $reason = 'Pet member';
                    $email_remittance_reason = 'you are a pet and therefore do not possess any money';
                } elseif ($member->is_donor) {
                    $reason = 'Donor';
                    $email_remittance_reason = 'you are a donor of the association, and your donation is not handled via the membership fee system';
                }

                $charged->remitted[] = $member->user->name.' (#'.$member->user->id.") - {$reason}";
            } elseif (in_array(strtolower($member->user->email), $emails) || in_array($member->user->utwente_username, $usernames) || in_array(strtolower($member->user->name), $names)) {
                $fee = Config::array('omnomcom.fee')['regular'];
                $email_fee = 'regular';
                $charged->regular[] = $member->user->name.' (#'.$member->user->id.')';
            } else {
                $fee = Config::array('omnomcom.fee')['reduced'];
                $email_fee = 'reduced';
                $charged->reduced[] = $member->user->name.' (#'.$member->user->id.')';
            }

            $charged->count++;

            $product = Product::query()->findOrFail($fee);
            $product->buyForUser($member->user, 1, null, null, null, null, 'membership_fee_cron');

            Mail::to($member->user)->queue((new FeeEmail($member->user, $email_fee, $product->price, $email_remittance_reason))->onQueue('high'));
        }

        /** @phpstan-ignore-next-line */
        if ($charged->count > 0) {
            Mail::queue((new FeeEmailForBoard($charged))->onQueue('high'));
        }

        $this->info('Charged '.$charged->count.' of '.Member::query()->count().' members their fee.');

        return 0;
    }
}
