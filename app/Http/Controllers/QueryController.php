<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Event;
use Proto\Models\Member;
use Response;

class QueryController extends Controller
{
    public function index()
    {
        return view('queries.index');
    }

    public function activityOverview(Request $request)
    {
        if (!$request->has('start') || !$request->has('start')) {
            if (intval(date('n')) >= 9) {
                $yearstart = intval(date('Y'));
            } else {
                $yearstart = intval(date('Y')) - 1;
            }
            $start = strtotime("$yearstart-09-01 00:00:01");
            $end = date('U');
        } else {
            $start = strtotime($request->start);
            $end = strtotime($request->end) + 86400; // Add one day to make it inclusive.
        }

        $events = Event::with(['activity', 'activity.users', 'activity.helpingCommitteeInstances'])
            ->where('start', '>=', $start)->where('end', '<=', $end)
            ->orderBy('start', 'asc')->get();

        return view('queries.activity_overview', [
            'start'  => $start,
            'end'    => $end,
            'events' => $events,
        ]);
    }

    public function membershipTotals(Request $request)
    {

        // Get a list of all CreaTe students.
        $ldap_students = LdapController::searchUtwente('|(department=*B-CREA*)(department=*M-ITECH*)');

        $names = [];
        $emails = [];
        $usernames = [];

        foreach ($ldap_students as $student) {
            $names[] = strtolower($student->givenname.' '.$student->sn);
            $emails[] = strtolower($student->userprincipalname);
            $usernames[] = $student->uid;
        }

        $count = 0;
        $count_primary = 0;
        $count_secondary = 0;
        $count_ut = 0;
        $count_active = 0;
        $count_lifelong = 0;
        $count_honorary = 0;
        $count_donator = 0;

        $export_subsidies = [];
        $export_active = [];

        // Loop over all members and determine if they are studying CreaTe.
        foreach (Member::all() as $member) {
            $is_primary_student = in_array(strtolower($member->user->email), $emails) ||
                in_array($member->user->utwente_username, $usernames) ||
                in_array(strtolower($member->user->name), $names);
            $has_ut_mail = substr($member->user->email, -10) == 'utwente.nl';
            $is_ut = $is_primary_student || $has_ut_mail || $member->user->utwente_username !== null;

            $count++;

            if ($member->user->isActiveMember()) {
                $count_active++;

                if ($request->has('export_active')) {
                    $export_active[] = (object) [
                        'name'       => $member->user->name,
                        'committees' => $member->user->committees->pluck('name'),
                    ];
                }
            }
            if ($member->is_lifelong) {
                $count_lifelong++;
            }
            if ($member->is_honorary) {
                $count_honorary++;
            }
            if ($member->is_donator) {
                $count_donator++;
            }

            if ($is_primary_student) {
                $count_primary++;
            } else {
                $count_secondary++;
            }

            if ($is_ut) {
                $count_ut++;
            }

            if ($request->has('export_subsidies')) {
                if ($is_ut) {
                    $export_subsidies[] = (object) [
                        'primary'   => $is_primary_student ? 'true' : 'false',
                        'name'      => $member->user->name,
                        'email'     => $has_ut_mail ? $member->user->email : null,
                        'ut_number' => $member->user->utwente_username ? $member->user->utwente_username : null,
                    ];
                }
            }
        }

        if ($request->has('export_subsidies')) {
            $headers = [
                'Content-Encoding'    => 'UTF-8',
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf('attachment; filename="primary_member_overview_%s.csv"', date('d_m_Y')),
            ];

            return Response::make(view('queries.export_subsidies', ['export' => $export_subsidies]), 200, $headers);
        } elseif ($request->has('export_active')) {
            $headers = [
                'Content-Encoding'    => 'UTF-8',
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf('attachment; filename="active_member_overview_%s.csv"', date('d_m_Y')),
            ];

            return Response::make(view('queries.export_active_members', ['export' => $export_active]), 200, $headers);
        } else {
            return view('queries.membership_totals', [
                'total'     => $count,
                'primary'   => $count_primary,
                'secondary' => $count_secondary,
                'ut'        => $count_ut,
                'active'    => $count_active,
                'lifelong'  => $count_lifelong,
                'honorary'  => $count_honorary,
                'donator'   => $count_donator,
            ]);
        }
    }
}
