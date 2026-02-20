<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Committee;
use App\Models\Event;
use App\Models\Page;
use App\Models\PhotoAlbum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request): View
    {
        $term = $request->input('query');

        $users = collect();
        if (Auth::user()?->is_member) {
            $users = $this->getGenericSearchQuery(
                User::class,
                $term,
                Auth::user()->can('board') ? ['id', 'name', 'calling_name', 'utwente_username', 'email'] : ['id', 'name', 'calling_name', 'email']
            )?->with('media')->get()->filter(function ($item) {
                /** @var User $item */
                return $item->is_member;
            }) ?? [];
        }

        $pages = $this->getGenericSearchQuery(
            Page::class,
            $term,
            ['slug', 'title', 'content']
        )?->get()
            ->filter(function ($item) {
                /** @var Page $item */
                return ! $item->is_member_only || Auth::user()?->is_member;
            }) ?? [];

        $committees = $this->getGenericSearchQuery(
            Committee::class,
            $term,
            ['id', 'name', 'slug']
        )?->get()
            ->filter(function ($item) {
                /** @var Committee $item */
                return $item->public || Auth::user()?->can('board');
            }) ?? [];

        $presearch_event_ids = $this->getGenericSearchQuery(
            Event::class,
            $term,
            ['id', 'title']
        )?->pluck('id');

        $events = collect();
        if ($presearch_event_ids) {
            // load the events with all the correct data to show in the event block

            Event::getEventBlockQuery()->whereIn('id', $presearch_event_ids)
                ->reorder()
                ->orderBy('start', 'desc')
                ->get()->each(static function ($event) use ($events) {
                    /** @var Event $event */
                    if ($event->mayViewEvent(Auth::user())) {
                        $events->push($event);
                    }
                });
        }

        $photoAlbums = $this->getGenericSearchQuery(
            PhotoAlbum::class,
            $term,
            ['id', 'name']
        )?->orderBy('date_taken', 'desc')
            ->unless(Auth::user()?->can('protography'), static function ($q) {
                $q->where('private', false);
            })
            ->get();

        return view('search.search', [
            'term' => $term,
            'users' => $users,
            'pages' => $pages,
            'committees' => $committees,
            'events' => $events,
            'photoAlbums' => $photoAlbums,
        ]);
    }

    public function ldapSearch(Request $request): View|RedirectResponse
    {
        if (! $request->has('query')) {
            return view('search.ldapsearch', [
                'term' => '',
                'data' => null,
            ]);
        }

        $query = $request->input('query');
        if (preg_match('/^[a-zA-Z0-9\s\-]+$/', (string) $query) !== 1) {
            Session::flash('flash_message', 'You cannot use special characters in your search query.');

            return back();
        }

        if (strlen((string) $query) < 3) {
            Session::flash('flash_message', 'Please make your search term more than three characters.');

            return back();
        }

        $terms = explode(' ', (string) $query);
        // make the search match all the terms, and is an active account
        $search = '(&(extensionattribute6=actief)';
        foreach ($terms as $term) {
            // or all the individual fields
            $search .= "(|(sn=*{$term}*)(middlename=*{$term}*)(givenName=*{$term}*)(telephoneNumber=*{$term}*)(otherTelephone=*{$term}*)(physicalDeliveryOfficeName=*{$term}*)";
            if (Auth::user()->can('board')) {
                $search .= "(userPrincipalName={$term}@utwente.nl)";
            }

            $search .= ')';
        }

        // close the search
        $search .= ')';

        $result = LdapController::searchUtwente($search);
        // check that we have a valid response
        if (isset($result->error)) {
            Session::flash('flash_message', 'Something went wrong while searching the UT LDAP server.'.($result->error ? ' '.$result->error : ''));

            return back();
        }

        return view('search.ldapsearch', [
            'term' => $query,
            'data' => $result->result,
        ]);
    }

    public function openSearch(): Response
    {
        return response()->view('search.opensearch')->header('Content-Type', 'text/xml');
    }

    /**
     * @return array<object{
     *     id: int,
     *     name: string,
     *     is_member: bool
     * }>
     */
    public function getUserSearch(Request $request): array
    {
        $search_attributes = ['id', 'name', 'calling_name', 'utwente_username', 'email'];
        $result = [];
        $users = $this->getGenericSearchQuery(User::class, $request->get('q'), $search_attributes)?->with('media')->get() ?? [];
        foreach ($users as $user) {
            /** @var User $user */
            $result[] = (object) [
                'id' => $user->id,
                'name' => $user->name,
                'is_member' => $user->is_member,
            ];
        }

        return $result;
    }

    /** @return Collection<int, Event>|null */
    public function getEventSearch(Request $request): ?Collection
    {
        $search_attributes = ['id', 'title'];

        return $this->getGenericSearchQuery(Event::class, $request->get('q'), $search_attributes)?->get();
    }

    /** @return Collection<int, Committee>|null */
    public function getCommitteeSearch(Request $request): ?Collection
    {
        $search_attributes = ['id', 'name', 'slug'];

        return $this->getGenericSearchQuery(Committee::class, $request->get('q'), $search_attributes)?->get();
    }

    /** @return Collection<int, Product>|null */
    public function getProductSearch(Request $request): ?Collection
    {
        $search_attributes = ['id', 'name'];

        return $this->getGenericSearchQuery(Product::class, $request->get('q'), $search_attributes)?->get();
    }

    /** @return Collection<int, Achievement>|null */
    public function getAchievementSearch(Request $request): ?Collection
    {
        $search_attributes = ['id', 'name'];

        return $this->getGenericSearchQuery(Achievement::class, $request->get('q'), $search_attributes)?->get();
    }

    /**
     * @template TModel of Model
     *
     * @param  class-string<TModel>  $model
     * @param  array<int, string>  $attributes
     * @return Builder<TModel>|null
     */
    private function getGenericSearchQuery(string $model, ?string $query, array $attributes): ?Builder
    {
        if (empty($query)) {
            return null;
        }

        $terms = explode(' ', str_replace('*', '%', $query));
        /** @var Builder<TModel> $query */
        $query = $model::query();

        $check_at_least_one_valid_term = false;
        foreach ($terms as $term) {
            if (strlen(str_replace('%', '', $term)) < 3) {
                continue;
            }

            $check_at_least_one_valid_term = true;
        }

        if (! $check_at_least_one_valid_term) {
            return null;
        }

        foreach ($attributes as $attr) {
            $query = $query->orWhere(static function (\Illuminate\Contracts\Database\Query\Builder $query) use ($terms, $attr) {
                foreach ($terms as $term) {
                    if (strlen(str_replace('%', '', $term)) < 3) {
                        continue;
                    }

                    $query = $query->whereLike($attr, sprintf('%%%s%%', $term));
                }
            });
        }

        return $query;
    }
}
