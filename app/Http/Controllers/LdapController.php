<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Adldap\Adldap;
use Adldap\Connections\Provider;

class LdapController extends Controller
{

    public static function searchUtwente($query, $onlyactive = false)
    {
        $response = file_get_contents(getenv('LDAP_PROXY_URL') . '?key=' . getenv('LDAP_PROXY_KEY') . '&filter=(' . urlencode($query) . ')');
        $result = json_decode($response)->result;

        if($onlyactive) {
            $result = array_filter($result, function($row) {
                if($row->active) {
                    return true;
                }

                return false;
            });
        }

        return $result;
    }

}
