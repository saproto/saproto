<?php

namespace Proto\Http\Controllers;

use Proto\Models\EmailList;
use Proto\Models\Event;
use Proto\Models\Account;
use Proto\Models\Achievement;
use Proto\Models\Activity;
use Proto\Models\Committee;
use Proto\Models\HelpingCommittee;
use Spatie\Permission\Models\Permission;
use Proto\Models\Product;
use Proto\Models\ProductCategory;
use Proto\Models\ProductCategoryEntry;
use Spatie\Permission\Models\Role;
use Proto\Models\Ticket;
use Proto\Models\User;

class ExportController extends Controller
{
    public function export($table, $personal_key)
    {
        $user = User::where('personal_key', $personal_key)->first();
        if (!$user || !$user->is_member || !$user->signed_nda) {
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
                if ($user->can('admin')) {
                    $data = Activity::all();
                } else {
                    $data = Activity::with('event')->get()->filter(function ($val) {
                        return $val->event && $val->event->secret == 0;
                    });
                    foreach ($data as $key => $val) {
                        unset($data[$key]->event);
                    }
                }
                break;
            case 'committees':
                if ($user->can('admin')) {
                    $data = Committee::all();
                } else {
                    $data = Committee::where('public', 1)->orWhereIn('id', array_values(config('proto.committee')))->get();
                }
                break;
            case 'committees_activities':
                $data = HelpingCommittee::all();
                break;
            case 'events':
                if ($user->can('admin')) {
                    $data = Event::all();
                } else {
                    $data = Event::where('secret', 0)->get();
                }
                break;
            case 'mailinglists':
                $data = EmailList::all();
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