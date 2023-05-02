<?php

namespace Proto\Http\Controllers;

use Permission;
use Proto\Models\Account;
use Proto\Models\Achievement;
use Proto\Models\Activity;
use Proto\Models\Committee;
use Proto\Models\Company;
use Proto\Models\EmailList;
use Proto\Models\Event;
use Proto\Models\HelpingCommittee;
use Proto\Models\MenuItem;
use Proto\Models\Page;
use Proto\Models\Product;
use Proto\Models\ProductCategory;
use Proto\Models\ProductCategoryEntry;
use Proto\Models\Ticket;
use Proto\Models\User;
use Role;

class ExportController extends Controller
{
    /**
     * @param array $table
     * @param string $personal_key
     * @return mixed
     */
    public function export($table, $personal_key)
    {
        $user = User::where('personal_key', $personal_key)->first();
        if (! $user || ! $user->is_member || ! $user->signed_nda) {
            abort(403, 'You do not have access to this data. You need a membership of a relevant committee to access it.');
        }
        $data = null;
        switch ($table) {
            case 'user':
                $data = $user;
                break;
            case 'accounts':
                $data = Account::all();
                break;
            case 'achievement':
                $data = Achievement::all();
                break;
            case 'activities':
                $data = Activity::has('event')->with('event')->get()->filter(function ($activity) use ($user) {
                    return $activity->event->mayViewEvent($user);
                });
                foreach ($data as $val) {
                    unset($val->event);
                }
                break;
            case 'committees':
                if ($user->can('admin')) {
                    $data = Committee::all();
                } else {
                    $data = Committee::query()
                        ->where('public', 1)
                        ->orWhereIn('id', array_values(config('proto.committee')))
                        ->get();
                }
                break;
            case 'committees_activities':
                $data = HelpingCommittee::all();
                break;
            case 'companies':
                $data = Company::all();
                break;
            case 'events':
                if ($user->can('admin')) {
                    $data = Event::all();
                } else {
                    $data = Event::all()
                        ->filter(function (Event $event) use ($user) {
                            return $event->mayViewEvent($user);
                        });
                }

                // Exclude 'activity' relation
                foreach($data as $key => $val) {
                    unset($val->activity);
                }

                break;
            case 'mailinglists':
                $data = EmailList::all();
                break;
            case 'menuitems':
                $data = MenuItem::all();
                break;
            case 'pages':
                $data = Page::all();
                break;
            case 'permissions':
                $data = Permission::all();
                break;
            case 'products':
                $data = Product::all();
                break;
            case 'products_categories':
                $data = ProductCategoryEntry::all();
                break;
            case 'product_categories':
                $data = ProductCategory::all();
                break;
            case 'roles':
                $data = Role::all();
                break;
            case 'tickets':
                $data = Ticket::all();
                break;
        }

        return $data;
    }
}
