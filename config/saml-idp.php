<?php

return [

    'idp' => [
        'issuer' => getenv('SAML2_IDP_ENTITY_ID'),
        'cert' => getenv('SAML2_IDP_CERT'),
        'key' => getenv('SAML2_IDP_KEY'),
    ],

    'sp' => [

        // Test Service Provider TestShib (www.testshib.org)
        base64_encode('https://atalanta.saproto.nl/saml2/module.php/saml/sp/saml2-acs.php/default-sp') => [
            'audience' => ['http://test.proto.utwente.nl'],
        ]

    ]

];
