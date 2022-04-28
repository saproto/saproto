<?php

namespace Proto\Console\Commands;

use Carbon;
use Illuminate\Console\Command;
use Proto\Models\Achievement;
use Proto\Models\AchievementOwnership;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Event;
use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\ProductCategory;
use Proto\Models\ProductCategoryEntry;
use Proto\Models\User;

class AchievementsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:achievementscron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that automatically assigns achievements';

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
        $this->info('Autoassigning achievements to users...');

        $this->giveAchievement($this->AchievementBeast(), 19);
        $this->giveAchievement($this->Hangry(), 20);
        $this->giveAchievement($this->CryBaby(), 21);
        $this->giveAchievement($this->TrueGerman(), 22);
        $this->giveAchievement($this->OldFart(), 23);
        $this->giveAchievement($this->IAmBread(), 24);
        $this->giveAchievement($this->GottaCatchEmAll(), 25);
        $this->giveAchievement($this->YouDandy(), 26);
        $this->giveAchievement($this->FristiMember(), 27);
        $this->giveAchievement($this->BigSpender(), 28);
        $this->giveAchievement($this->fourOClock(), 29);
        $this->giveAchievement($this->youreSpecial(), 30);
        $this->giveAchievement($this->bigKid(), 32);
        $this->giveAchievement($this->NoLife(), 52);
        $this->giveAchievement($this->First(), 51);
        $this->giveAchievement($this->ForeverMember(), 38);
        $this->giveAchievement($this->GoodHuman(), 53);
        $this->giveAchievement($this->IAmNoodle(), 54);
        $this->giveAchievement($this->nThActivity(1), 63);
        $this->giveAchievement($this->nThActivity(100), 64);
        $this->giveAchievement($this->percentageActivities(25), 55);
        $this->giveAchievement($this->percentageActivities(75), 56);
        $this->giveAchievement($this->percentageActivities(100), 57);

        $this->info('Auto achievement gifting done!');
    }

    /**
     * Give an achievement to a list of users.
     */
    private function giveAchievement($users, $achievement_id)
    {
        $changecount = 0;

        $achievement = Achievement::find($achievement_id);

        if ($achievement) {
            foreach ($users as $user) {
                if ($user) {
                    try {
                        $achieved = $user->achieved();

                        $hasAchievement = false;

                        foreach ($achieved as $test) {
                            if ($test->id == $achievement_id) {
                                $hasAchievement = true;
                                break;
                            }
                        }
                    } catch (Exception $e) {
                        dd($e);
                    }

                    if (! $hasAchievement) {
                        $new = [
                            'user_id' => $user->id,
                            'achievement_id' => $achievement_id,
                        ];
                        $relation = new AchievementOwnership($new);
                        $relation->save();
                        $changecount += 1;
                        $this->line('Achievement "'.$achievement->name.'" given to '.$user->name);
                    } else {
//                        $this->line($achievement->name . ' already obtained by ' . $user->name . '.');
                    }
                } else {
                    $this->error('Cant find a certain user for '.$achievement->name.'. User probably deleted.');
                }
            }

            $this->info('Gave away '.$changecount.' of achievement "'.$achievement->name.'".');
        } else {
            $this->error('Error! '.$achievement_id.' is a non-existing achievement ID. Skipping to next auto achievement.');
        }
    }

    /**
     *    ------------------------------------------------------------------------   ACHIEVEMENT LOGIC FUNCTIONS   --------------------------------------------------------------------------------.
     */

    /**
     * Achievement beast = 10 achievements or more.
     */
    private function AchievementBeast()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            if (count($user->achieved()) >= 10) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     * Hangry = bought 5 snickers or more (all time).
     */
    private function Hangry()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $orders = Orderline::where('user_id', $user->id)->where('product_id', 2)->get();
            $count = 0;
            foreach ($orders as $order) {
                $count += $order->units;
            }
            if ($count >= 5) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     * Cry baby = bought 15 surprise eggs or more.
     */
    private function CryBaby()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $orders = Orderline::where('user_id', $user->id)->where('product_id', 487)->get();
            $count = 0;
            foreach ($orders as $order) {
                $count += $order->units;
            }
            if ($count >= 15) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     * True German = more than 20 Weizen in beer history.
     */
    private function TrueGerman()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $orders = Orderline::where('user_id', $user->id)->whereIn('product_id', [805, 211, 758])->get();
            $count = 0;
            foreach ($orders as $order) {
                $count += $order->units;
            }
            if ($count >= 20) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     *  Old Fart = more than 5 years a member.
     */
    private function OldFart()
    {
        $members = Member::where('deleted_at', null)->where('created_at', '<', Carbon::now()->subYears(5))->get();
        $selected = [];
        foreach ($members as $member) {
            $selected[] = User::find($member->user_id);
        }
        return $selected;
    }

    /**
     * 4ever committee member = you've been a committee member for more than three years.
     */
    private function ForeverMember()
    {
        $selected = [];

        foreach (User::all() as $user) {
            $forever = false;
            foreach (Committee::all() as $committee) {
                $memberships = CommitteeMembership::withTrashed()
                    ->where('user_id', $user->id)
                    ->where('committee_id', $committee->id)
                    ->get();
                $days = 0;
                foreach ($memberships as $membership) {
                    if ($membership->deleted_at != null && ! $committee->is_society) {
                        $diff = $membership->deleted_at->diff($membership->created_at);
                    } else {
                        $diff = Carbon::now()->diff($membership->created_at);
                    }
                    $days += $diff->days;
                }
                if ($days >= 1095) {
                    $forever = true;
                }
            }
            if ($forever) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     *  Good Human = you have donated to a committee!
     */
    private function GoodHuman()
    {
        $selected = [];
        $products = ProductCategoryEntry::where('category_id', 28)->get();
        foreach ($products as $product) {
            $orders = OrderLine::where('product_id', $product->id)->get();
            foreach ($orders as $order) {
                $user = User::find($order['user_id']);
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     *  I am Bread = you bought more than 100 croque monsieurs.
     */
    private function IAmBread()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $orders = Orderline::where('user_id', $user->id)->whereIn('product_id', [22, 219, 419])->get();
            $count = 0;
            foreach ($orders as $order) {
                $count += $order->units;
            }
            if ($count >= 100) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     *  I am Bread = you bought more than 100 noodles;.
     */
    private function IAmNoodle()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $orders = Orderline::where('user_id', $user->id)->where('product_id', 39)->get();
            $count = 0;
            foreach ($orders as $order) {
                $count += $order->units;
            }
            if ($count >= 100) {
                $selected[] = $user;
            }
        }

        return $selected;
    }

    /**
     *  Gotta catch 'em all! = at least in 10 different committees.
     */
    private function GottaCatchEmAll()
    {
        $users = User::all();
        $selected = [];
        foreach ($users as $user) {
            $memberships = CommitteeMembership::withTrashed()
                ->where('user_id', $user->id)
                ->with('committee')
                ->get();
            for ($i = 0; $i < count($memberships); $i++) {
                for ($j = $i + 1; $j < count($memberships); $j++) {
                    if ($memberships[$i]->committee_id == $memberships[$j]->committee_id) {
                        $memberships[$i] = null;
                        break;
                    }
                }
            }
            $count = 0;
            foreach ($memberships as $temp) {
                if ($temp != null && ! $temp->committee->is_society) {
                    $count++;
                }
            }
            if ($count >= 10) {
                $selected[] = $user;
            }
        }

        return $selected;
    }

    /**
     *  You dandy = you bought 3 different types of merchandise.
     */
    private function YouDandy()
    {
        $users = User::all();
        $selected = [];
        $merch = ProductCategory::find(9)->products()->pluck('id');
        foreach ($users as $user) {
            $merchorders = OrderLine::where('user_id', $user->id)->whereIn('product_id', $merch)->get();
            if (count($merchorders) > 3) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     * FIRST!!!! = you were the first to buy a product.
     */
    private function First()
    {
        $products = Product::all();
        $selected = [];

        foreach ($products as $product) {
            if ($product->is_visible == 1) {
                $order = OrderLine::orderBy('id')->where('product_id', $product->id)->first();
                if ($order != null) {
                    $user = User::find($order['user_id']);
                    $selected[] = $user;
                }
            }
        }

        return $selected;
    }

    /**
     *  Fristi Member = you're no CreaTer and you bought a Fristi.
     */
    private function FristiMember()
    {
        $selected = [];
        $fristies = OrderLine::where('product_id', 180)->whereNotNull('user_id')->get();
        foreach ($fristies as $fristi) {
            if ($fristi->user && ! $fristi->user->did_study_create) {
                $selected[] = User::find($fristi->user_id);
            }
        }
        return $selected;
    }

    /**
     *  Big spender = you had the max money subtracted for 1 month (=€250).
     */
    private function BigSpender()
    {
        $selected = [];
        if (Carbon::now()->day == 1) {
            $users = User::all();
            foreach ($users as $user) {
                $orders = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->get();
                $cost = 0;
                foreach ($orders as $order) {
                    $cost += $order->total_price;
                    if ($cost >= 250) {
                        $selected[] = $user;
                        break;
                    }
                }
            }
        } else {
            $this->info('Its not the first of the month! Cancelling Big Spender...');
        }
        return $selected;
    }

    /**
     *  No Life = when you have bought the will to live product 777 times.
     */
    private function NoLife()
    {
        $selected = [];
        $users = User::all();
        foreach ($users as $user) {
            $amount = 0;
            $orders = OrderLine::where('product_id', 987)->where('user_id', $user->id)->get();
            foreach ($orders as $order) {
                $amount += $order->units;
            }
            if ($amount >= 777) {
                $selected[] = $user;
            }
        }
        return $selected;
    }

    /**
     *  It’s always 4 o’clock somewhere = a month where more than 25% of OmNomCom purchases is beer.
     */
    private function fourOClock()
    {
        $selected = [];
        if (Carbon::now()->day == 1) {
            $beerIDs = ProductCategory::find(11)->products()->pluck('id')->toArray();
            $beerIDs = array_merge($beerIDs, ProductCategory::find(15)->products()->pluck('id')->toArray());
            $beerIDs = array_merge($beerIDs, ProductCategory::find(18)->products()->pluck('id')->toArray());
            $beerIDs = array_merge($beerIDs, ProductCategory::find(19)->products()->pluck('id')->toArray());
            $users = User::all();
            foreach ($users as $user) {
                $orders = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->get();
                $beers = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->whereIn('product_id', $beerIDs)->get();
                if (count($beers) > 0) {
                    if (count($beers) / count($orders) > 0.25) {
                        $selected[] = $user;
                    }
                }
            }
        } else {
            $this->info('Its not the first of the month! Cancelling It\'s always 4 o\'clock somewhere...');
        }
        return $selected;
    }

    /**
     *  You’re special = more than 25% of your beer purchases this month is special beer.
     */
    private function youreSpecial()
    {
        $selected = [];
        if (Carbon::now()->day == 1) {
            $beerIDs = ProductCategory::find(11)->products()->pluck('id')->toArray();
            $beerIDs = array_merge($beerIDs, ProductCategory::find(15)->products()->pluck('id')->toArray());
            $beerIDs = array_merge($beerIDs, ProductCategory::find(18)->products()->pluck('id')->toArray());
            $beerIDs = array_merge($beerIDs, ProductCategory::find(19)->products()->pluck('id')->toArray());
            $users = User::all();
            foreach ($users as $user) {
                $orders = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->get();
                $beers = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->whereIn('product_id', $beerIDs)->get();
                if (count($beers) > 0) {
                    if (count($beers) / count($orders) > 0.25) {
                        $selected[] = $user;
                    }
                }
            }
        } else {
            $this->info('Its not the first of the month! Cancelling You\'re special...');
        }
        return $selected;
    }

    /**
     *  Big kid = month where more than 25% of purchases is from the kid friendly category.
     */
    private function bigKid()
    {
        $selected = [];
        if (Carbon::now()->day == 1) {
            $kidIDs = ProductCategory::find(21)->products()->pluck('id')->toArray();
            $users = User::all();
            foreach ($users as $user) {
                $orders = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->where('user_id', $user->id)->get();
                $kidOrders = OrderLine::where('updated_at', '>', Carbon::now()->subMonths(1))->whereIn('product_id', $kidIDs)->where('user_id', $user->id)->get();
                if (count($kidOrders) > 0) {
                    if (count($kidOrders) / count($orders) > 0.25) {
                        $selected[] = $user;
                    }
                }
            }
        } else {
            $this->info('Its not the first of the month! Cancelling Big kid...');
        }
        return $selected;
    }

    private function nThActivity($activityAmount) {
        $selected = [];
        $users = User::all();
        foreach ($users as $user) {
            $participated = ActivityParticipation::where('user_id', $user->id)->pluck('activity_id');
            $activities = Activity::WhereIn('id', $participated)->pluck('event_id');
            $CountEvents = Event::whereIn('id', $activities)->whereTime('end', '<', Carbon::now()->valueOf())->count();
            if($CountEvents >= $activityAmount){
                $selected[] = $user;
            }
        }
        return $selected;
    }

    private function percentageActivities($percentage) {
        $selected = [];
            if (Carbon::now()->day == 1) {
                $possibleActivities = Event::where('end', '>', Carbon::now()->subMonth()->valueOf())->where('end', '<', Carbon::now()->valueOf())->where('secret', '=', '0')->has('activity')->count();
                if ($possibleActivities >= 5) {
                    $users = User::all();
                    foreach ($users as $user) {
                        $participated = ActivityParticipation::where('user_id', $user->id)->pluck('activity_id');
                        $activities = Activity::whereIn('id', $participated)->pluck('event_id');
                        $CountEventsParticipated = Event::whereIn('id', $activities)->where('end', '>', Carbon::now()->subMonth()->valueOf())->where('end', '<', Carbon::now()->valueOf())->where('secret', '=', '0')->count();

                        if (floor($CountEventsParticipated / $possibleActivities * 100) >= $percentage) {
                            $selected[] = $user;
                        }
                    }
                }
                else{
                    $this->info('Not enough activities this month! cancelling participation trophee for '.$percentage.'% of activities attended!');
                }
            }
            else {
                $this->info('Its not the first of the month! Cancelling participation trophee for '.$percentage.' of activities attended!');
            }
            return $selected;
        }
}
