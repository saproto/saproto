<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;

use Proto\Models\Member;
use Proto\Models\Tempadmin;
use Proto\Models\User;

use PDF;
use Auth;
use Entrust;
use Session;
use Redirect;
use Mail;

class MemberAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.members.overview');
    }

    public function showSearch(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $users = User::where('name', 'LIKE', '%' . $search . '%')->orWhere('calling_name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->orWhere('utwente_username', 'LIKE', '%' . $search . '%')->paginate(20);
        } else {
            $users = User::paginate(20);
        }

        return view('users.members.nested.list', ['users' => $users]);
    }


    /**
     * Show the nested details view for member admin.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function showDetails($id)
    {
        $user = User::findOrFail($id);
        return view('users.members.nested.details', ['user' => $user]);
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

        if (!Auth::user()->can('admin')) {
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (!Auth::user()->can($permission->name)) abort(403);
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
            $impersonator = User::findOrFail(Session::get("impersonator"));
            Session::pull("impersonator");

            Auth::login($impersonator);

            return response()->redirectTo("/");
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
        $member->is_associate = !$request->input('is_primary');
        $member->user()->associate($user);

        /** Create member alias */

        $name = explode(" ", $user->name);
        if (count($name) > 1) {
            $aliasbase = MemberAdminController::transliterateString(strtolower(
                preg_replace('/\PL/u', '', substr($name[0], 0, 1))
                . '.' .
                preg_replace('/\PL/u', '', implode("", array_slice($name, 1)))
            ));
        } else {
            $aliasbase = MemberAdminController::transliterateString(strtolower(
                preg_replace('/\PL/u', '', $name[0])
            ));
        }
        $alias = $aliasbase;
        $i = 0;

        while (Member::where('proto_username', $alias)->withTrashed()->count() > 0) {
            $i++;
            $alias = $aliasbase . '-' . $i;
        }

        $member->proto_username = $alias;

        /** End create member alias */

        $member->save();

        $name = $user->name;
        $email = $user->email;

        Mail::queueOn('high', 'emails.membership', ['user' => $user, 'internal' => config('proto.internal')], function ($m) use ($name, $email) {
            $m->replyTo('internal@proto.utwente.nl', config('proto.internal') . ' (Officer Internal Affairs)');
            $m->to($email, $name);
            $m->subject('Start of your membership of Study Association Proto');
        });

        Session::flash("flash_message", "Congratulations! " . $user->name . " is now our newest member!");

        return redirect()->route('user::member::list');
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

        $name = $user->name;
        $email = $user->email;

        Mail::queueOn('high', 'emails.membershipend', ['user' => $user, 'secretary' => config('proto.secretary')], function ($m) use ($name, $email) {
            $m->replyTo('secretary@proto.utwente.nl', config('proto.secretary') . ' (Secretary)');
            $m->to($email, $name);
            $m->subject('Termination of your membership of Study Association Proto');
        });

        Session::flash("flash_message", "Membership of " . $user->name . " has been termindated.");

        return redirect()->route('user::member::list');
    }

    public function showForm(Request $request, $id)
    {

        if ((!Auth::check() || !Auth::user()->can('board')) && $request->ip() != env('PRINTER_HOST')) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->address === null) {
            Session::flash("flash_message", "This user has no address!");
            return Redirect::back();
        }

        $form = PDF::loadView('users.members.membershipform', ['user' => $user]);

        $form = $form->setPaper('a4');

        if ($request->ip() != env('PRINTER_HOST')) {
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

    public function makeTempAdmin($id)
    {
        $user = User::findOrFail($id);

        $tempAdmin = new Tempadmin;

        $tempAdmin->created_by = Auth::user()->id;
        $tempAdmin->start_at = Carbon::today();
        $tempAdmin->end_at = Carbon::tomorrow();
        $tempAdmin->user()->associate($user);

        $tempAdmin->save();

        return redirect()->route('user::member::list');
    }

    public function endTempAdmin($id)
    {
        $user = User::findOrFail($id);

        foreach ($user->tempadmin as $tempadmin) {
            if (Carbon::now()->between(Carbon::parse($tempadmin->start_at), Carbon::parse($tempadmin->end_at))) {
                $tempadmin->end_at = Carbon::now();
                $tempadmin->save();
            }
        }

        // Call Herbert webhook to run check through all connected admins. Will result in kick for users whose
        // temporary adminpowers were removed.
        file_get_contents(env('HERBERT_SERVER') . "/adminCheck");

        return redirect()->route('user::member::list');
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
