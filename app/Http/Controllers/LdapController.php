<?php

namespace Proto\Http\Controllers;

class LdapController extends Controller
{
    public static function searchUtwente($query, $onlyactive = false)
    {
        $response = file_get_contents(sprintf('%s?key=%s&filter=(%s)', config('ldap.proxy.utwente.url'), config('ldap.proxy.utwente.key'), urlencode($query)));
        $result = json_decode($response)->result;

        if ($onlyactive) {
            $result = array_filter($result, function ($row) {
                if ($row->active) {
                    return true;
                }

                return false;
            });
        }

        return $result;
    }
}
