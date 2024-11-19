<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_API_KEY'),
    ],

    'saml2' => [
        'metadata' => env('SAML_IDP_METADATA_URL'),
        'sp_entityid' => env('SAML_SP_ENTITY_ID'),
        // Need to exclude from CSRF verification
        'sp_acs' => 'surf/callback',
        'sp_sign_assertions' => true,
        'sp_default_binding_method' => \LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST,
        'attribute_map' => [
            'uid' => \SocialiteProviders\Saml2\OasisAttributeNameUris::UID,
            'organization' => "urn:mace:terena.org:attribute-def:schacHomeOrganization",
        ],
    ],
];
