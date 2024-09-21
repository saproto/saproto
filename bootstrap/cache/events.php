<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'Illuminate\\Auth\\Events\\Login' => 
    array (
      0 => 'App\\Handlers\\Events\\AuthLoginEventHandler',
    ),
    'Aacotroneo\\Saml2\\Events\\Saml2LoginEvent' => 
    array (
      0 => 'App\\Handlers\\Events\\SamlLoginEventHandler',
    ),
  ),
);