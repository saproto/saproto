<?php

namespace Proto\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDF;
use Proto\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberCardController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return Response|StreamedResponse
     */
    public function download(Request $request, $id)
    {
        if ((! Auth::check() || ! Auth::user()->can('board')) && $request->ip() != config('app-proto.printer-host')) {
            abort(403);
        }

        /** @var User $user */
        $user = User::findOrFail($id);

        if (! $user->is_member) {
            abort(403, 'Only members can have a member card printed.');
        }

        $card = PDF::loadView('users.membercard.membercard', ['user' => $user, 'overlayonly' => $request->has('overlayonly')]);

        $card = $card
            ->setOption('page-width', 86)->setOption('page-height', 54)
            ->setOption('margin-bottom', 0)->setOption('margin-left', 0)->setOption('margin-right', 0)->setOption('margin-top', 0);

        if ($request->ip() != config('app-proto.printer-host')) {
            return $card->stream();
        } else {
            return $card->download();
        }
    }

    public function startPrint(Request $request)
    {
        $user = User::find($request->input('id'));

        if (! $user) {
            return 'This user could not be found!';
        }

        if (! $user->is_member) {
            return 'Only members can have their card printed!';
        }

        $result = FileController::requestPrint('card', route('membercard::download', ['id' => $user->id]));
        $user->member->card_printed_on = date('Y-m-d');
        $user->member->save();

        return 'The printer service responded: '.$result;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function startOverlayPrint(Request $request)
    {
        $user = User::find($request->input('id'));

        if (! $user) {
            return 'This user could not be found!';
        }

        if (! $user->is_member) {
            return 'Only members can have their card printed!';
        }

        $result = FileController::requestPrint('card', route('membercard::download', ['id' => $user->id, 'overlayonly' => 1]));

        return 'The printer service responded: '.$result;
    }
}
