<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\LeaderboardEntry;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeaderboardEntryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $leaderboard = Leaderboard::query()->findOrFail($request->input('leaderboard_id'));

        abort_unless($leaderboard->canEdit(Auth::user()), 403, "Only the board or member of the {$leaderboard->committee->name} can edit this leaderboard");

        if ($leaderboard->entries()->where('user_id', $request->user_id)->first()) {
            Session::flash('flash_message', 'There is already a entry for this user');

            return back();
        }

        $entry = LeaderboardEntry::query()->create($request->all());
        $user = User::query()->findOrFail($request->user_id);
        $entry->leaderboard()->associate($leaderboard);
        $entry->user()->associate($user);
        $entry->save();

        Session::flash('flash_message', 'Added new entry successfully.');

        return back();
    }

    /**
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $entry = LeaderboardEntry::query()->findOrFail($request->id);

        abort_unless($entry->leaderboard->canEdit(Auth::user()), 403, "Only the board or member of the {$entry->leaderboard->committee->name} can edit this leaderboard");

        $entry->points = $request->points;
        $entry->save();

        return response()->json(['points' => $entry->points]);
    }

    /**
     * @param  int  $id
     *
     * @throws Exception
     */
    public function destroy($id): RedirectResponse
    {
        $entry = LeaderboardEntry::query()->findOrFail($id);

        abort_unless($entry->leaderboard->canEdit(Auth::user()), 403, "Only the board or member of the {$entry->leaderboard->committee->name} can edit this leaderboard");

        $entry->delete();
        Session::flash('flash_message', 'The entry has been deleted.');

        return back();
    }
}
