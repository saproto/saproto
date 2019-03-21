<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Adldap\Adldap;
use Adldap\Connections\Provider;

class LdapController extends Controller
{

    public static function searchUtwente($query, $onlyactive = false)
    {
        $ad = new Adldap();
        $provider = new Provider(config('adldap.utwente'));
        $ad->addProvider('utwente', $provider);
        $ad->connect('utwente');

        $filter = [
            '(objectClass=organizationalPerson)',
            '(' . $query . ')'
        ];

        $select = [
            'givenName',
            'sn',
            'initials',
            'displayName',
            'middleName',
            'cn',
            'userPrincipalName',
            'uid',
            'description',
            'mail',
            'department',
            'telephoneNumber',
            'physicaldeliveryofficename',
            'postalCode',
            'l',
            'preferredLanguage',
            'streetAddress',
            'sAMAccountName',
            'wWWHomePage',
            'extensionAttribute6'
        ];

        $data = $provider->search()->select($select)->rawFilter($filter)->get()->jsonSerialize();

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
