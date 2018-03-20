<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\Event;
use Proto\Models\Page;
use Proto\Models\Committee;

use Response;
use View;
use Auth;
use Session;

class SearchController extends Controller
{

    public function search(Request $request)
    {

        $term = $request->input('query');

        $data = SearchController::doSearch($term);

        $users = [];
        foreach ($data['users'] as $id => $count) {
            $user = User::findOrFail($id);
            $users[] = [
                'score' => $count,
                'object' => $user,
                'href' => route('user::profile', ['id' => $user->getPublicId()])
            ];
        }
        $pages = [];
        foreach ($data['pages'] as $id => $count) {
            $page = Page::findOrFail($id);
            $pages[] = [
                'score' => $count,
                'object' => $page,
                'href' => route('page::show', ['slug' => $page->slug])
            ];
        }
        $committees = [];
        foreach ($data['committees'] as $id => $count) {
            $committee = Committee::findOrFail($id);
            $committees[] = [
                'score' => $count,
                'object' => $committee,
                'href' => route('committee::show', ['id' => $committee->getPublicId()])
            ];
        }
        $events = [];
        foreach ($data['events'] as $id => $count) {
            $event = Event::findOrFail($id);
            $events[] = [
                'score' => $count,
                'object' => $event,
                'href' => route('event::show', ['id' => $event->getPublicId()])
            ];
        }

        usort($users, function ($a, $b) {
            return $b['score'] - $a['score'];
        });
        usort($pages, function ($a, $b) {
            return $b['score'] - $a['score'];
        });
        usort($committees, function ($a, $b) {
            return $b['score'] - $a['score'];
        });
        usort($events, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        return view('website.search', [
            'term' => $term,
            'users' => $users,
            'pages' => $pages,
            'committees' => $committees,
            'events' => $events
        ]);

    }

    public function ldapSearch(Request $request)
    {
        $query = null;
        $data = null;

        if ($request->has('query')) {

            $query = $request->input('query');
            if (strlen($query) >= 3) {
                $terms = explode(' ', $query);
                $search = "&";

                $data = [];

                foreach ($terms as $term) {
                    $search .= "(|(sn=$term)(givenName=$term)(telephoneNumber=*$term*)(otherTelephone=*$term*)(physicalDeliveryOfficeName=*$term*))";
                }

                $data = LdapController::searchUtwente($search, true);
            } else {
                Session::flash('flash_message', 'Please make your search term more than three characters.');
            }

        }

        return view('website.ldapsearch', [
            'term' => $query,
            'data' => (array)$data
        ]);
    }

    public static function doSearch($term)
    {

        $data = [
            'users' => [],
            'pages' => [],
            'events' => [],
            'committees' => []
        ];

        $term = str_replace('%', '', $term);

        if (strlen($term) == 0) {
            return $data;
        }

        $term = explode(' ', $term);

        if (count($term) == 0) {
            return $data;
        }

        foreach ($term as $string) {

            $string = strtolower($string);

            if ($string == 'proto') continue;

            foreach (User::all() as $user) {

                if (
                    (
                        (strlen($string) >= 3 && strpos(strtolower($user->name), $string) > -1)
                        || strtolower($user->calling_name) == $string
                        || ($user->utwente_username && strlen($string) >= 5 && strpos(strtolower($user->utwente_username), $string) > -1) && Auth::check() && Auth::user()->can('board')
                        || (intval($string) > 0 && $user->id == $string)
                    ) && $user->member && Auth::check() && Auth::user()->member
                ) {

                    if (array_key_exists($user->id, $data['users'])) {
                        $data['users'][$user->id]++;
                    } else {
                        $data['users'][$user->id] = 1;
                    }

                }

            }

            foreach (Page::all() as $page) {

                if (
                    (
                        (strlen($string) >= 3 && strpos(strtolower($page->title), $string) > -1)
                        || (strlen($string) >= 3 && strpos(strtolower($page->content), $string) > -1)
                    ) && (!$page->is_member_only || Auth::check() && Auth::user()->member)
                ) {

                    if (array_key_exists($page->id, $data['pages'])) {
                        $data['pages'][$page->id] +=
                            substr_count(strtolower($page->title), $string)
                            + substr_count(strtolower($page->content), $string);
                    } else {
                        $data['pages'][$page->id] = substr_count(strtolower($page->title), $string)
                            + substr_count(strtolower($page->content), $string);
                    }

                }

            }

            foreach (Event::all() as $event) {

                if (
                    (
                        (strlen($string) >= 3 && strpos(strtolower($event->title), $string) > -1)
                        || (strlen($string) >= 3 && strpos(strtolower($event->description), $string) > -1)
                    ) && (!$event->secret || Auth::check() && Auth::user()->can('board'))
                ) {

                    if (array_key_exists($event->id, $data['events'])) {
                        $data['events'][$event->id] +=
                            substr_count(strtolower($event->title), $string)
                            + substr_count(strtolower($event->content), $string);
                    } else {
                        $data['events'][$event->id] = substr_count(strtolower($event->title), $string)
                            + substr_count(strtolower($event->description), $string);
                        $data['events'][$event->id] -= SearchController::searchTimePenalty($event);
                    }

                }

            }

            foreach (Committee::all() as $committee) {

                if (
                    (
                        (strlen($string) >= 3 && strpos(strtolower($committee->name), $string) > -1)
                        || (strlen($string) >= 3 && strpos(strtolower($committee->description), $string) > -1)
                    ) && ($committee->public || Auth::check() && Auth::user()->can('board'))
                ) {

                    if (array_key_exists($committee->id, $data['committees'])) {
                        $data['committees'][$committee->id] +=
                            substr_count(strtolower($committee->name), $string)
                            + substr_count(strtolower($committee->description), $string);
                    } else {
                        $data['committees'][$committee->id] = substr_count(strtolower($committee->name), $string)
                            + substr_count(strtolower($committee->description), $string);
                    }

                }

            }

        }

        arsort($data['users']);
        arsort($data['pages']);
        arsort($data['events']);
        arsort($data['committees']);

        return $data;
    }

    public static function searchTimePenalty(Event $event)
    {
        $penalty = 0;

        $delta = date('U') - date('U', $event->start);
        $penalty = 0.2 * ($delta / 3600 / 24);

        return $penalty;
    }

    public function openSearch()
    {
        return Response::make(View::make('website.opensearch'))->header('Content-Type', 'text/xml');
    }

}
