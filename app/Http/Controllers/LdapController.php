<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class LdapController extends Controller
{

    public static function searchUtwente($query, $onlyactive = false)
    {
        $data = (array)json_decode(file_get_contents(
            config('app-proto.utwente-ldap-hook') . "?filter=" . urlencode($query)
        ));
        $response = [];
        foreach ($data as $entry) {
            $object = [];
            foreach ($entry as $attribute => $data) {
                if (is_array($data)) {
                    $object[$attribute] = $data[0];
                }
            }

            // Set object type
            if (in_array('userprincipalname', array_keys($object))) {
                switch (substr($object['userprincipalname'], 0, 1)) {
                    case 's':
                        $object['type'] = 'student';
                        break;
                    case 'm':
                        $object['type'] = 'employee';
                        break;
                    case 'x':
                        $object['type'] = 'functional';
                        break;
                    default:
                        $object['type'] = 'other';
                        break;
                }
            } else {
                $object['type'] = 'other';
            }

            // Check account status
            if (in_array('extensionattribute6', array_keys($object))) {
                switch ($object['extensionattribute6']) {
                    case 'actief':
                        $object['active'] = true;
                        break;
                    default:
                        $object['active'] = false;
                        break;
                }
                unset($object['extensionattribute6']);
            } else {
                $object['active'] = false;
            }

            if (!$onlyactive || $object['active']) {
                $response[] = (object)$object;
            }
        }
        return $response;
    }

}
