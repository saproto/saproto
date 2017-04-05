<?php

return [

    'idp' => [
        'issuer' => 'https://idp.proto.utwente.nl'
    ],

    'sp' => [

        // Test Service Provider TestShib (www.testshib.org)
        base64_encode('https://sp.testshib.org/Shibboleth.sso/SAML2/POST') => [
            'audience' => ['https://sp.testshib.org/shibboleth-sp'],
        ]

    ]

];
