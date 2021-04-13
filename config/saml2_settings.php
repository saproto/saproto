<?php

return $settings = [

    /**
     * Array of IDP prefixes to be configured e.g. 'idpNames' => ['test1', 'test2', 'test3'],
     * Separate routes will be automatically registered for each IDP specified with IDP name as prefix
     * Separate config file saml2/<idpName>_idp_settings.php should be added & configured accordingly.
     */
    'idpNames' => ['surfconext'],

    /**
     * If 'useRoutes' is set to true, the package defines five new routes for reach entry in idpNames:.
     *
     *    Method | URI                                | Name
     *    -------|------------------------------------|------------------
     *    POST   | {routesPrefix}/{idpName}/acs       | saml_acs
     *    GET    | {routesPrefix}/{idpName}/login     | saml_login
     *    GET    | {routesPrefix}/{idpName}/logout    | saml_logout
     *    GET    | {routesPrefix}/{idpName}/metadata  | saml_metadata
     *    GET    | {routesPrefix}/{idpName}/sls       | saml_sls
     */
    'useRoutes' => true,

    /**
     * Optional, leave empty if you want the defined routes to be top level, i.e. "/{idpName}/*".
     */
    'routesPrefix' => '/saml2',

    /**
     * which middleware group to use for the saml routes
     * Laravel 5.2 will need a group which includes StartSession.
     */
    'routesMiddleware' => ['saml', 'web'],

    /**
     * Indicates how the parameters will be
     * retrieved from the sls request for signature validation.
     */
    'retrieveParametersFromServer' => false,

    /**
     * Where to redirect after logout.
     */
    'logoutRoute' => '/',

    /**
     * Where to redirect after login if no other option was provided.
     */
    'loginRoute' => '/surfconext/post',

    /**
     * Where to redirect after login if no other option was provided.
     */
    'errorRoute' => '/',

];
