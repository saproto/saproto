<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\User;

use PDF;

class MemberCardController extends Controller
{
    public function download(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$user->member) {
            abort(500, "Only members can have a member card printed.");
        }

        $card = PDF::loadView('users.membercard.membercard', ['user' => $user]);

        return $card
            ->setOption('page-width',86)->setOption('page-height',54)
            ->setOption('margin-bottom',0)->setOption('margin-left',0)->setOption('margin-right',0)->setOption('margin-top',0)
            ->stream();
    }
}
