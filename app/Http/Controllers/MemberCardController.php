<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use PDF;
use Spipu\Html2Pdf\Exception\Html2PdfException;

class MemberCardController extends Controller
{
    /**
     * @return ResponseFactory|Response
     *
     * @throws Html2PdfException
     */
    public function download(Request $request, User $user)
    {
        abort_unless($user->is_member, 403, 'Only members can have a member card printed.');

        $card = new PDF('L', [86, 54], 'en');
        $card->setDefaultFont('freeserif');
        $card->writeHTML(view('users.membercard.membercard', ['user' => $user, 'overlayonly' => $request->has('overlayonly')]));
        $filename = 'usercard_'.$user->id.'.pdf';

        return response($card->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"',
        ]);
    }

    public function startPrint(Request $request): string
    {
        $user = User::query()->find($request->input('id'));

        if (! $user) {
            return 'This user could not be found!';
        }

        if (! $user->is_member) {
            return 'Only members can have their card printed!';
        }

        $result = FileController::requestPrint('card', route('membercard::download', ['user' => $user]));
        $user->member->card_printed_on = Date::now()->format('Y-m-d');
        $user->member->save();

        return 'The printer service responded: '.$result;
    }
}
