<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\User;

use PDF;
use Hash;
use Auth;

class MemberCardController extends Controller
{
    public function download(Request $request, $id)
    {

        if ((!Auth::check() || !Auth::user()->can('board')) && $request->ip() != env('PRINTER_HOST')) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if (!$user->member) {
            abort(500, "Only members can have a member card printed.");
        }

        $card = PDF::loadView('users.membercard.membercard', ['user' => $user, 'overlayonly' => $request->has('overlayonly')]);

        $card = $card
            ->setOption('page-width', 86)->setOption('page-height', 54)
            ->setOption('margin-bottom', 0)->setOption('margin-left', 0)->setOption('margin-right', 0)->setOption('margin-top', 0);

        if ($request->ip() != env('PRINTER_HOST')) {
            return $card->stream();
        } else {
            return $card->download();
        }

    }

    public function startprint(Request $request)
    {

        $user = User::find($request->input('id'));

        if (!$user) {
            return "This user could not be found!";
        }

        if (!$user->member) {
            return "Only members can have their card printed!";
        }

        $result = FileController::requestPrint('card', route('membercard::download', ['id' => $user->id]));

        if ($result === false) {
            return "Something went wrong trying to reach the printer service.";
        }

        $user->member->card_printed_on = date('Y-m-d');
        $user->member->save();

        return "The printer service responded: " . $result;

    }

    public function startoverlayprint(Request $request)
    {

        $user = User::find($request->input('id'));

        if (!$user) {
            return "This user could not be found!";
        }

        if (!$user->member) {
            return "Only members can have their card printed!";
        }

        $result = FileController::requestPrint('card', route('membercard::download', ['id' => $user->id, 'overlayonly' => 1]));

        if ($result === false) {
            return "Something went wrong trying to reach the printer service.";
        }

        return "The printer service responded: " . $result;

    }
}
