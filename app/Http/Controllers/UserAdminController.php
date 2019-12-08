<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use Proto\Mail\MembershipEnded;
use Proto\Mail\MembershipStarted;
use Proto\Models\Member;
use Proto\Models\User;
use Proto\Models\HashMapItem;

use PDF;
use Auth;
use Entrust;
use Session;
use Redirect;
use Mail;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->input('query');

        if ($search) {
            $users = User::withTrashed()->where('name', 'LIKE', '%' . $search . '%')->orWhere('calling_name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->orWhere('utwente_username', 'LIKE', '%' . $search . '%')->paginate(20);
        } else {
            $users = User::withTrashed()->paginate(20);
        }

        return view('users.admin.overview', ['users' => $users, 'query' => $search]);

    }


    /**
     * Show the details view for member admin.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function details($id)
    {
        $user = User::findOrFail($id);
        return view('users.admin.details', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->calling_name = $request->calling_name;
        if (strtotime($request->birthdate) !== false) {
            $user->birthdate = date('Y-m-d', strtotime($request->birthdate));
        } else {
            $user->birthdate = null;
        }
        $user->save();
        Session::flash("flash_message", "User updated!");
        return Redirect::back();
    }

    /**
     * Allows impersonation of another user.
     *
     * @param $id
     * @return mixed
     */
    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        if (!Auth::user()->can('sysadmin')) {
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (!Auth::user()->can($permission->name)) abort(403, "You may not impersonate this person.");
                }
            }
        }

        Session::put("impersonator", Auth::user()->id);
        Auth::login($user);
        return redirect('/');
    }

    /**
     * Returns to the original user when impersonating.
     *
     * @return mixed
     */
    public function quitImpersonating()
    {
        if (Session::has("impersonator")) {
            $redirectuser = Auth::id();

            $impersonator = User::findOrFail(Session::get("impersonator"));
            Session::pull("impersonator");

            Auth::login($impersonator);

            return redirect()->route('user::admin::details', ['id' => $redirectuser]);
        }
    }

    /**
     * Adds a member object to a user.
     *
     * @param $id
     * @return mixed
     */
    public function addMembership($id, Request $request)
    {
        $user = User::findOrFail($id);

        if (!($user->address && $user->bank)) {
            Session::flash("flash_message", "This user really needs a bank account and address. Don't bypass the system!");
            return Redirect::back();
        }

        $member = Member::create();
        $member->user()->associate($user);

        /** Create member alias */

        $name = explode(" ", $user->name);
        if (count($name) > 1) {
            $aliasbase = UserAdminController::transliterateString(strtolower(
                preg_replace('/\PL/u', '', substr($name[0], 0, 1))
                . '.' .
                preg_replace('/\PL/u', '', implode("", array_slice($name, 1)))
            ));
        } else {
            $aliasbase = UserAdminController::transliterateString(strtolower(
                preg_replace('/\PL/u', '', $name[0])
            ));
        }

        # make sure usernames are max 20 characters long (windows limitation)
        $aliasbase = substr($aliasbase, 0, 17);

        $alias = $aliasbase;
        $i = 0;

        while (Member::where('proto_username', $alias)->withTrashed()->count() > 0) {
            $i++;
            $alias = $aliasbase . '-' . $i;
        }

        $member->proto_username = $alias;

        /** End create member alias */

        $user->updateLdapUser();

        $member->save();

        Mail::to($user)->queue((new MembershipStarted($user))->onQueue('high'));

        EmailListController::autoSubscribeToLists('autoSubscribeMember', $user);

        HashMapItem::create([
            'key' => 'wizard',
            'subkey' => $user->id,
            'value' => 1
        ]);

        Artisan::call('proto:playsound', [ 'sound' =>  config('proto.soundboardSounds')['new-member']]);

        Session::flash("flash_message", "Congratulations! " . $user->name . " is now our newest member!");

        return redirect()->back();
    }

    /**
     * Adds membership end date to member object.
     * Member object will be removed by cron job on end date.
     *
     * @param $id
     * @return mixed
     */
    public function endMembership($id)
    {
        $user = User::findOrFail($id);

        $user->member()->delete();
        $user->clearMemberProfile();

        Mail::to($user)->queue((new MembershipEnded($user))->onQueue('high'));

        Session::flash("flash_message", "Membership of " . $user->name . " has been termindated.");

        return redirect()->back();
    }

    public function toggleNda($id)
    {
        if (!Auth::user()->can('board')) {
            abort(403, "Only board members can do this.");
        }
        $user = User::findOrFail($id);
        $user->signed_nda = !$user->signed_nda;
        $user->save();

        Session::flash("flash_message", "Toggled NDA status of " . $user->name . ". Please verify if it is correct.");
        return redirect()->back();
    }

    public function unblockOmnomcom($id)
    {
        $user = User::findOrFail($id);
        $user->disable_omnomcom = false;
        $user->save();

        Session::flash("flash_message", "OmNomCom unblocked for " . $user->name . ".");
        return redirect()->back();
    }

    public function toggleStudiedCreate($id)
    {
        $user = User::findOrFail($id);
        $user->did_study_create = !$user->did_study_create;
        $user->save();

        Session::flash("flash_message", "Toggled CreaTe status of " . $user->name . ".");
        return redirect()->back();
    }

    public function toggleStudiedITech($id)
    {
        $user = User::findOrFail($id);
        $user->did_study_itech = !$user->did_study_itech;
        $user->save();

        Session::flash("flash_message", "Toggled ITech status of " . $user->name . ".");
        return redirect()->back();
    }

    public function showForm(Request $request, $id)
    {

        if ((!Auth::check() || !Auth::user()->can('board')) && $request->ip() != config('app-proto.printer-host')) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->address === null) {
            Session::flash("flash_message", "This user has no address!");
            return Redirect::back();
        }

        $form = PDF::loadView('users.admin.membershipform', ['user' => $user]);

        $form = $form->setPaper('a4');

        if ($request->ip() != config('app-proto.printer-host')) {
            return $form->stream();
        } else {
            return $form->download();
        }

    }

    public function printForm(Request $request)
    {

        $user = User::find($request->input('id'));

        if (!$user) {
            return "This user could not be found!";
        }

        if ($user->address->count() === 0) {
            return "This user has no address!";
        }

        $result = FileController::requestPrint('document', route('memberform::download', ['id' => $user->id]));

        if ($result === false) {
            return "Something went wrong trying to reach the printer service.";
        }

        return "The printer service responded: " . $result;

    }

    /**
     * Replace all strange characters in a string with normal ones. Shamelessly borrowed from http://stackoverflow.com/a/6837302
     */
    public static function transliterateString($txt)
    {
        $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
    }


}
