<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Committee;
use App\Models\Company;
use App\Models\EmailList;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\HelpingCommittee;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryEntry;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Permission;
use Role;

class ExportController extends Controller
{
    /**
     * @return Collection<int, mixed>
     */
    public function export(string $table, string $personal_key)
    {
        $user = User::query()->where('personal_key', $personal_key)->first();
        abort_if(! $user || ! $user->is_member || ! $user->signed_nda, 403, 'You do not have access to this data. You need a membership of a relevant committee to access it.');

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
                $data = Activity::query()
                    ->whereHas('event', function ($q) use ($user) {
                        $q
                            ->where('end', '>=', Date::now()->subYear()->timestamp)
                            ->when($user->cannot('sysadmin'), function ($q) {
                                $q->where([
                                    ['secret', false],
                                    [static function ($query) {
                                        $query->where('publication', '<', Date::tomorrow()->timestamp)
                                            ->orWhereNull('publication');
                                    }],
                                ]);
                            });
                    })->get();

                break;
            case 'committees':
                if ($user->can('admin')) {
                    $data = Committee::all();
                } else {
                    $data = Committee::query()
                        ->where('public', 1)
                        ->orWhereIn('id', array_values(Config::array('proto.committee')))
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
                $data = Event::query()
                    ->where('end', '>=', Date::now()->subYear()->timestamp)
                    ->setEagerLoads([])
                    ->when($user->cannot('sysadmin'), function ($q) {
                        $q->where([
                            ['secret', false],
                            [static function ($query) {
                                $query->where('publication', '<', Date::tomorrow()->timestamp)
                                    ->orWhereNull('publication');
                            }],
                        ]);
                    })->get();

                break;
            case 'event_categories':
                $data = EventCategory::all();
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
