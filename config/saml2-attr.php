<?php

return [

    'givenname' => env('SAML2_ATTR_FIRSTNAME', 'urn:mace:dir:attribute-def:givenName'),
    'surname'   => env('SAML2_ATTR_SURNAME', 'urn:mace:dir:attribute-def:sn'),
    'email'     => env('SAML2_ATTR_EMAIL', 'urn:mace:dir:attribute-def:mail'),
    'uid'       => env('SAML2_ATTR_UID', 'urn:mace:dir:attribute-def:uid'),
    'institute' => env('SAML2_ATTR_ORG', 'urn:mace:terena.org:attribute-def:schacHomeOrganization'),

];
