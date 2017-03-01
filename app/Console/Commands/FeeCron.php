<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\Product;

use Mail;

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

        if (intval(date('n')) == 8 || intval(date('n')) == 8) {
            $this->info('We don\'t charge membership fees in August or September.');
            return;
        }

        if (intval(date('n')) >= 9) {
            $yearstart = intval(date('Y'));
        } else {
            $yearstart = intval(date('Y')) - 1;
        }

        $ldap_students = json_decode(file_get_contents(env('LDAP_URL_UTWENTE') . '?filter=department=*B-CREA*'));

        $names = [];
        $emails = [];
        $usernames = [];

        foreach ($ldap_students as $student) {
            $names[] = $student->givenname[0] . ' ' . $student->sn[0];
            $emails[] = $student->mail[0];
            $usernames[] = $student->uid[0];
        }

        $already_paid = OrderLine::whereIn('product_id', array_values(config('omnomcom.fee')))->where('created_at', '>=', $yearstart . '-09-01 00:00:01')->get()->pluck('user_id')->toArray();

        $charged = (object)[
            'count' => 0,
            'regular' => [],
            'reduced' => [],
            'remitted' => []
        ];

        foreach (Member::all() as $member) {

            if (in_array($member->user->id, $already_paid)) {
                continue;
            }

            if ($member->is_lifelong || $member->is_honorary || $member->is_donator) {
                $fee = config('omnomcom.fee')['remitted'];
                if ($member->is_honorary) {
                    $reason = "Honorary Member";
                } elseif ($member->is_lifelong) {
                    $reason = "Lifelong Member";
                } else {
                    $reason = "Donator";
                }
                $charged->remitted[] = $member->user->name . " (#" . $member->user->id . ") - $reason";
            } elseif (in_array($member->user->email, $emails) || in_array($member->user->utwente_username, $usernames) || in_array($member->user->name, $names)) {
                $fee = config('omnomcom.fee')['regular'];
                $charged->regular[] = $member->user->name . " (#" . $member->user->id . ")";
            } else {
                $fee = config('omnomcom.fee')['reduced'];
                $charged->reduced[] = $member->user->name . " (#" . $member->user->id . ")";
            }

            $charged->count++;

            $product = Product::findOrFail($fee);
            $product->buyForUser($member->user, 1, $product->price);

        }

        if ($charged->count > 0) {
            Mail::queueOn('high', 'emails.fee', ['data' => $charged], function ($message) use ($charged) {
                $message->to('payments@proto.utwente.nl', 'S.A. Proto Payments Update');
                $message->subject('Membership Fee Cron Update for ' . date('d-m-Y') . '. (' . $charged->count . ' transactions)');
            });
        }

        $this->info("Charged " . $charged->count . " of " . Member::count() . " members their fee.");

    }

}
