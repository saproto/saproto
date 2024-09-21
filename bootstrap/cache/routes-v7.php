<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => true,
    1 => 
    array (
      '/biscolab-recaptcha/validate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7gYVMARyZyjLLP12',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/clockwork' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NgT6Ud9iWqmz8cs5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/clockwork/app' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iqm97qcPA6nIlC1V',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/__clockwork' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2lxzaF7ywPUTUcUH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.token',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/authorize' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.authorizations.authorize',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'passport.authorizations.approve',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'passport.authorizations.deny',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/token/refresh' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.token.refresh',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/tokens' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.tokens.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/clients' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.clients.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'passport.clients.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/scopes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.scopes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/oauth/personal-access-tokens' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.personal.tokens.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'passport.personal.tokens.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/dmx_values' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::dmx_values',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::token',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/news' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::news',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/verify_iban' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::verify_iban',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::user::qr::token',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/gdpr_export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::user::gdpr_export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/discord/redirect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::discord::redirect',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/discord/linked' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::discord::linked',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/discord/unlink' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::discord::unlink',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/photos/random_photo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::photos::randomPhoto',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/photos/photos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::photos::albums',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/screen/bus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::screen::bus',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/screen/timetable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::screen::timetable',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/screen/timetable/protopeners' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::screen::timetable::protopeners',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/screen/narrowcasting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::screen::narrowcasting',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/protube/played' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::protube::played',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/protube/userdetails' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::protube::',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/search/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::search::user',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/search/committee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::search::committee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/search/event' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::search::event',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/search/product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::search::product',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/search/achievement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::search::achievement',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/omnomcom/stock' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::omnomcom::stock',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/wallstreet/active' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wallstreet::active',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/wallstreet/toggle_event' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wallstreet::toggle_event',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/isalfredthere' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::isalfredthere',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/wrapped' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wrapped',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::unX6qYdaYa29YEPN',
          ),
          1 => 'smartxp.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uGpnA4cC7OSpY43I',
          ),
          1 => 'www.smartxp.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::G7vEChVP8SM4CfEe',
          ),
          1 => 'caniworkinthesmartxp.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        3 => 
        array (
          0 => 
          array (
            '_route' => 'generated::E6Im4u1r3ZaLA8Ui',
          ),
          1 => 'www.caniworkinthesmartxp.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        4 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rnoXLq1CwdibaBAX',
          ),
          1 => 'omnomcom.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        5 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qc6tecLF9ZxgRdu4',
          ),
          1 => 'www.omnomcom.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        6 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UiGJyiwIWejiWLVj',
          ),
          1 => 'haveyoutriedturningitoffandonagain.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        7 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GhKg3J5n1V4wmVH7',
          ),
          1 => 'www.haveyoutriedturningitoffandonagain.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        8 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RfCRapR5IQAECIIH',
          ),
          1 => 'isalfredthere.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        9 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4FbEs9019NfBPkNy',
          ),
          1 => 'www.isalfredthere.nl',
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        10 => 
        array (
          0 => 
          array (
            '_route' => 'homepage',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/developers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2QD9sgRZyL4hR36M',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/fishcam' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'fishcam',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/becomeamember' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'becomeamember',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/headerimage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'headerimage::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/headerimage/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'headerimage::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/headerimage/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'headerimage::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'search::get',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'search::post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/opensearch' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'search::opensearch',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ldap/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'search::ldap::get',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'search::ldap::post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout/redirect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::logout::redirect',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::reset::submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::reset',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::reset::send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::sync::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/change' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::change::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::change',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::register::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::register',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register/surfconext' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::register::surfconext',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/surfconext' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::edu',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/surfconext/post' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::edupost',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/username' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::requestusername::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login::requestusername',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::changepassword',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/personal_key' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::personal_key::generate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/memberprofile/complete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::memberprofile::show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user::memberprofile::complete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/memberprofile/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::memberprofile::showclear',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user::memberprofile::clear',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/change_email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::changemail',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::dashboard::show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user::dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/quit_impersonating' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::quitimpersonating',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/show' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/address/togglehidden' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::address::togglehidden',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/diet/edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::diet::edit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/bank/show' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::bank::show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/bank/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::bank::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/bank/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::bank::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/bank/edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::bank::edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/bank/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::bank::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/profilepic/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::pic::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/profilepic/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::pic::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/edu/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::edu::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/edu/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::edu::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/2fa/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::2fa::create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/2fa/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::2fa::delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/registrationhelper' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::registrationhelper::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/admin/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/memberform/sign' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::showsign',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::sign',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/committee/membership/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::membership::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/committee/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/committee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/committee/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/society/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'society::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/narrowcasting/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/narrowcasting/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/narrowcasting/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/narrowcasting/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::clear',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/narrowcasting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::display',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/companies/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/companies/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/companies/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/companies/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/membercard/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'membercard::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/joboffers/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/joboffers/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/joboffers/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/joboffers/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards/entries/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::entries::create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leaderboards/entries/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::entries::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dinnerform/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dinnerform/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wallstreet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wallstreet/marquee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::marquee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wallstreet/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wallstreet/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/wallstreet/events/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/financial/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::financial::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/categories/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::category::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/categories/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::category::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/copy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::copy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/set_reminder' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::set_reminder',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/events/toggle_relevant_only' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::toggle_relevant_only',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/news/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/news/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/news/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/news/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tickets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tickets/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tickets/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/list/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::list::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/list/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::list::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/filter' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::filter',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotes::list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/goodideas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'goodideas::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/feedback/categories/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::category::admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/feedback/categories/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::category::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/feedback/vote' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::vote',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/minisite' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/store/rfid/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::store::rfid::create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/orders/orderline-wizard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::orderline-wizard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/orders/store/bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::storebulk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/orders/store/single' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::adminlist',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/payments/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::payments::statistics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/tipcie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::tipcie::orderhistory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/accounts/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/accounts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/accounts/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/export/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::export_csv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::statistics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/mut' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::mutations',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/products/mut/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::mutations_export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/categories/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/unwithdrawable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::unwithdrawable',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/withdrawals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/withdrawals/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/withdrawals/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/mollie/pay' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mollie::pay',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/mollie/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mollie::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/omnomcom/supplier' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::generateorder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/video/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::admin::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/video/admin/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::admin::create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/video' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/announcement/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/announcement/admin/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/announcement/admin/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/announcement/admin/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::clear',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/photos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::albums',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/photos/slideshow' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::slideshow',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/photos/admin/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/photos/admin/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/spotify/oauth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'spotify::oauth',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/authorization' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'authorization::overview',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/passwordstore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/passwordstore/auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::auth',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::postAuth',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/passwordstore/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/passwordstore/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/alias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alias::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/alias/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alias::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/alias/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alias::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/alias/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alias::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/smartxp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'smartxp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/protopolis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'protopolis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/caniworkinthesmartxp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ItmaNZqvnMZm2yOf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/protube/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'protube::dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/protube/togglehistory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'protube::togglehistory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/protube/clearhistory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'protube::clearhistory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/protube/top' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'protube::top',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/achievement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/achievement/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/achievement/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/achievement/give' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::give',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/achievement/gallery' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::gallery',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welcomeMessages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welcomeMessages::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welcomeMessages/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welcomeMessages::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tempadmin/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tempadmin/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tempadmin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr::generate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr/isApproved' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr::approved',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/short_url' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'short_url::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx/override' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx/override/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dmx/override/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/queries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'queries::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/queries/activity_overview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'queries::activity_overview',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/queries/activity_statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'queries::activity_statistics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/queries/membership_totals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'queries::membership_totals',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/minisites/isalfredthere' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'minisites::isalfredthere::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/minisites/isalfredthere/edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'minisites::isalfredthere::edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/minisites/isalfredthere/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'minisites::isalfredthere::update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/create-codex' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::create-codex',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/create-song' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::create-song',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/create-song-category' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::create-song-category',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/create-text-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::create-text-type',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/create-text' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::create-text',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/store-codex' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::store-codex',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/store-codex-category' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::store-codex-category',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/store-text-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::store-text-type',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/codex/store-text' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::store-text',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/december/toggle' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'december::toggle',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|(?:(?:[^./]*+\\.)++)(?|/s(?|aml2/([^/]++)/(?|log(?|out(*:60)|in(*:69))|metadata(*:85)|acs(*:95)|sls(*:105))|ociety/([^/]++)(*:129)|hort_url/(?|edit/([^/]++)(*:162)|update/([^/]++)(*:185)|delete/([^/]++)(*:208)))|/__clockwork/(?|((?:[0-9-]+|latest))/extended(*:263)|((?:[0-9-]+|latest))(?:/((?:next|previous))(?:/(\\d+))?)?(*:327)|([^/]++)(*:343)|a(?|uth(*:358)|pp(*:368))|(.+)(*:381))|/c(?|lockwork/(.+)(*:408)|o(?|m(?|mittee/(?|membership/(?|end/([^/]++)/([^/]++)(*:469)|([^/]++)(?|/delete(*:495)|(*:503)))|([^/]++)(?|/(?|edit(?|(*:535))|image(*:549)|send_anonymous_email(?|(*:580))|toggle_helper_reminder(*:611))|(*:620)))|panies/(?|edit/([^/]++)(?|(*:656))|d(?|elete/([^/]++)(*:683)|own/([^/]++)(*:703))|up/([^/]++)(*:723)|([^/]++)(*:739)))|dex/(?|e(?|dit\\-(?|codex/([^/]++)(*:782)|song(?|/([^/]++)(*:806)|\\-category/([^/]++)(*:833))|text(?|\\-type/([^/]++)(*:864)|/([^/]++)(*:881)))|xport/([^/]++)(*:905))|delete\\-(?|codex/([^/]++)(*:939)|song(?|/([^/]++)(*:963)|\\-category/([^/]++)(*:990))|text(?|\\-type/([^/]++)(*:1021)|/([^/]++)(*:1039)))|update\\-(?|codex/([^/]++)(*:1075)|song(?|/([^/]++)(*:1100)|\\-category/([^/]++)(*:1128))|text(?|\\-type/([^/]++)(*:1160)|/([^/]++)(*:1178))))))|/o(?|auth/(?|tokens/([^/]++)(*:1220)|clients/([^/]++)(?|(*:1248))|personal\\-access\\-tokens/([^/]++)(*:1291))|mnomcom/(?|store(?|(?:/([^/]++))?(*:1334)|/([^/]++)/buy(*:1356))|orders/(?|history(?:/([^/]++))?(*:1397)|delete/([^/]++)(*:1421)|filter/(?|name(?:/([^/]++))?(*:1458)|date(?:/([^/]++))?(*:1485)))|accounts/(?|aggregate/([^/]++)(*:1526)|edit/([^/]++)(*:1548)|update/([^/]++)(*:1572)|delete/([^/]++)(*:1596)|([^/]++)(*:1613))|products/(?|edit/([^/]++)(*:1648)|update/(?|([^/]++)(*:1675)|bulk(*:1688))|delete/([^/]++)(*:1713))|categories/(?|update/([^/]++)(*:1752)|delete/([^/]++)(*:1776)|([^/]++)(*:1793))|m(?|ywithdrawal/([^/]++)(*:1827)|ollie/(?|status/([^/]++)(*:1860)|receive/([^/]++)(*:1885)|monthly/([^/]++)(*:1910)))|withdrawals/(?|e(?|dit/([^/]++)(*:1952)|xport/([^/]++)(*:1975)|mail/([^/]++)(*:1997))|delete(?|/([^/]++)(*:2025)|from/([^/]++)/([^/]++)(*:2056))|accounts/([^/]++)(*:2083)|close/([^/]++)(*:2106)|mark(?|failed/([^/]++)/([^/]++)(*:2146)|loss/([^/]++)/([^/]++)(*:2177))|([^/]++)(*:2195))))|/a(?|pi/(?|scan/([^/]++)(*:2231)|user/(?|qr_auth_(?|approve/([^/]++)(*:2275)|info/([^/]++)(*:2297))|dev_export/([^/]++)/([^/]++)(*:2335))|discord/verify/([^/]++)(*:2368)|events/upcoming(?:/([^/]++))?(*:2406)|photos/photos(?:/([^/]++))?(*:2442)|wallstreet/(?|updated_prices/([^/]++)(*:2488)|all_prices/([^/]++)(*:2516)|latest_events/([^/]++)(*:2547)))|nnouncement/(?|admin/(?|edit/([^/]++)(*:2595)|update/([^/]++)(*:2619)|delete/([^/]++)(*:2643))|dismiss/([^/]++)(*:2669))|uthorization/([^/]++)/(?|grant(*:2709)|revoke/([^/]++)(*:2733))|lias/delete/([^/]++)(*:2763)|chieve(?|/([^/]++)(*:2790)|ment/(?|edit/([^/]++)(*:2820)|update/([^/]++)(*:2844)|delete/([^/]++)(*:2868)|award/([^/]++)(*:2891)|take(?|/([^/]++)/([^/]++)(*:2925)|All/([^/]++)(*:2946))|([^/]++)/icon(*:2969))))|/f(?|ile/([^/]++)/([^/]++)(?|(*:3010)|/([^/]++)(*:3028))|eedback/(?|categories/(?|edit/([^/]++)(?|(*:3079))|delete/([^/]++)(*:3104))|a(?|pprove/([^/]++)(*:3133)|rchive/([^/]++)(*:3157))|re(?|ply/([^/]++)(*:3184)|store/([^/]++)(*:3207))|delete/([^/]++)(*:3232)|([^/]++)/(?|index(*:3258)|s(?|earch(?:/([^/]++))?(*:3290)|tore(*:3303))|archive(?|d(*:3324)|all(*:3336)))))|/i(?|mage/([^/]++)/([^/]++)(?|(*:3379)|/([^/]++)(*:3397))|cal/calendar(?:/([^/]++))?(*:3433))|/headerimage/delete/([^/]++)(*:3471)|/p(?|a(?|ssword(?|/reset/([^/]++)(*:3513)|store/(?|edit/([^/]++)(*:3544)|update/([^/]++)(*:3568)|delete/([^/]++)(*:3592)))|ge/(?|edit/([^/]++)(?|(*:3625)|/(?|image(*:3643)|file/(?|create(*:3666)|([^/]++)/delete(*:3690))))|update/([^/]++)(*:3717)|delete/([^/]++)(*:3741)|([^/]++)(*:3758)))|hotos/(?|like/([^/]++)(*:3791)|dislike/([^/]++)(*:3816)|photo/([^/]++)(*:3839)|([^/]++)(*:3856)|admin/(?|edit/([^/]++)(?|(*:3890)|/(?|action(*:3909)|upload(*:3924)|delete(*:3939)))|publish/([^/]++)(*:3966)|unpublish/([^/]++)(*:3993))))|/u(?|ser(?|/(?|r(?|fidcard/([^/]++)/(?|delete(*:4050)|edit(*:4063)|update(*:4078))|egistrationhelper/([^/]++)(*:4114))|2fa/delete/([^/]++)(*:4143)|([^/]++)/member/(?|impersonate(*:4182)|omnomcomsound/(?|update(*:4214)|delete(*:4229))|create(*:4245)|remove(?|(*:4263)|_end(*:4276))|end_in_september(*:4302)|settype(*:4318))|admin/(?|studied_(?|create/([^/]++)(*:4363)|itech/([^/]++)(*:4386))|nda/([^/]++)(*:4408)|unblock_omnomcom/([^/]++)(*:4442)|([^/]++)(?|(*:4462))))|(?:/([^/]++))?(*:4488))|nsubscribe/([^/]++)(*:4517))|/me(?|mber(?|form/(?|d(?|ownload/(?|new/([^/]++)(*:4575)|signed/([^/]++)(*:4599))|elete/([^/]++)(*:4623))|print/([^/]++)(*:4647))|card/(?|([^/]++)(*:4673)|print(*:4687)|download/([^/]++)(*:4713)))|nu/(?|up(?|/([^/]++)(*:4744)|date/([^/]++)(*:4766))|d(?|own/([^/]++)(*:4792)|elete/([^/]++)(*:4815))|edit/([^/]++)(*:4838)))|/n(?|arrowcasting/(?|edit/([^/]++)(?|(*:4886))|delete/([^/]++)(*:4911))|ews/(?|edit/([^/]++)(?|(*:4944)|/image(*:4959))|update/([^/]++)(*:4984)|delete/([^/]++)(*:5008)|s(?|endWeekly/([^/]++)(*:5039)|howWeeklyPreview/([^/]++)(*:5073))|([^/]++)(*:5091)))|/joboffers/(?|edit/([^/]++)(?|(*:5132))|delete/([^/]++)(*:5157)|([^/]++)(*:5174))|/leaderboards/(?|e(?|dit/([^/]++)(*:5217)|ntries/delete/([^/]++)(*:5248))|update/([^/]++)(*:5273)|delete/([^/]++)(*:5297))|/d(?|innerform/(?|edit/([^/]++)(*:5338)|update/([^/]++)(*:5362)|close/([^/]++)(*:5385)|delete/([^/]++)(*:5409)|admin/([^/]++)(*:5432)|process/([^/]++)(*:5457)|orderline/(?|delete/([^/]++)(*:5494)|edit/([^/]++)(*:5516)|store/([^/]++)(*:5539)|update/([^/]++)(*:5563))|([^/]++)(*:5581))|mx/(?|edit/([^/]++)(*:5610)|update/([^/]++)(*:5634)|delete/([^/]++)(*:5658)|override/(?|edit/([^/]++)(*:5692)|update/([^/]++)(*:5716)|delete/([^/]++)(*:5740))))|/w(?|allstreet/(?|close/([^/]++)(*:5784)|e(?|dit/([^/]++)(?|(*:5812))|vents/(?|edit/([^/]++)(*:5844)|update/([^/]++)(*:5868)|delete/([^/]++)(*:5892)|products/(?|create/([^/]++)(*:5928)|remove/([^/]++)/([^/]++)(*:5961))))|delete/([^/]++)(*:5988)|statistics/([^/]++)(*:6016)|products/(?|create/([^/]++)(*:6052)|remove/([^/]++)/([^/]++)(*:6085)))|e(?|bhook/mollie/([^/]++)(*:6121)|lcomeMessages/delete/([^/]++)(*:6159)))|/e(?|vents/(?|financial/close/([^/]++)(*:6208)|categories/(?|edit/([^/]++)(*:6244)|update/([^/]++)(*:6268)|delete/([^/]++)(*:6292))|edit/([^/]++)(*:6315)|update/([^/]++)(*:6339)|delete/([^/]++)(*:6363)|a(?|lbum/(?|([^/]++)/link(*:6397)|unlink/([^/]++)(*:6421))|rchive/([^/]++)(*:6446)|dmin/([^/]++)(*:6468))|scan/([^/]++)(*:6491)|([^/]++)(?|/login(*:6517)|(*:6526))|togglepresence/([^/]++)(*:6559)|participate(?|/([^/]++)(*:6591)|for/([^/]++)(*:6612))|u(?|nparticipate/([^/]++)(*:6647)|pdatehelp/([^/]++)(*:6674))|buytickets/([^/]++)(*:6703)|signup/([^/]++)(?|(*:6730)|/delete(*:6746))|addhelp/([^/]++)(*:6772)|deletehelp/([^/]++)(*:6800)|checklist/([^/]++)(*:6827))|mail/(?|list/(?|edit/([^/]++)(*:6866)|update/([^/]++)(*:6890)|delete/([^/]++)(*:6914))|show/([^/]++)(*:6937)|edit/([^/]++)(*:6959)|update/([^/]++)(*:6983)|toggleready/([^/]++)(*:7012)|delete/([^/]++)(*:7036)|([^/]++)/attachment/(?|create(*:7074)|delete/([^/]++)(*:7098))))|/t(?|ickets/(?|edit/([^/]++)(*:7138)|u(?|pdate/([^/]++)(*:7165)|nscan(?:/([^/]++))?(*:7193))|d(?|elete/([^/]++)(*:7221)|ownload/([^/]++)(*:7246))|scan/([^/]++)(*:7269))|ogglelist/([^/]++)(*:7297)|empadmin/(?|make/([^/]++)(*:7331)|e(?|nd(?|/([^/]++)(*:7358)|Id/([^/]++)(*:7378))|dit/([^/]++)(*:7400))|update/([^/]++)(*:7425)))|/video/(?|admin/(?|edit/([^/]++)(*:7468)|update/([^/]++)(*:7492)|delete/([^/]++)(*:7516))|([^/]++)(*:7534))|/qr/(?|code/([^/]++)(*:7564)|([^/]++)(?|(*:7584)|/approve(*:7601)))|/go(?:/([^/]++))?(*:7629)))/?$}sDu',
    ),
    3 => 
    array (
      60 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'saml2_logout',
          ),
          1 => 
          array (
            0 => 'idpName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      69 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'saml2_login',
          ),
          1 => 
          array (
            0 => 'idpName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      85 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'saml2_metadata',
          ),
          1 => 
          array (
            0 => 'idpName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      95 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'saml2_acs',
          ),
          1 => 
          array (
            0 => 'idpName',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      105 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'saml2_sls',
          ),
          1 => 
          array (
            0 => 'idpName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      129 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'society::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      162 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'short_url::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      185 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'short_url::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      208 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'short_url::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      263 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HAzAg1T3xxdBwYpT',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      327 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5jZSYJfKnJ2cKZeH',
            'direction' => NULL,
            'count' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'direction',
            2 => 'count',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      343 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mjNgWVHJzGfUF3cz',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      358 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6zZcWfsXZnl1B5VG',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      368 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0M4yYVtmfAVbbzYn',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      381 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gOjV0GkpJcv4yY0y',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::X5XX0xiSEhiIB3IO',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      469 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::membership::endedition',
          ),
          1 => 
          array (
            0 => 'committee',
            1 => 'edition',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      495 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::membership::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      503 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::membership::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'committee::membership::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      535 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'committee::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      549 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::image',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      580 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::anonymousmail',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'committee::sendanonymousmail',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      611 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::toggle_helper_reminder',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      620 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'committee::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      656 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'companies::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      683 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      703 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::orderDown',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      723 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::orderUp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      739 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'companies::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::edit-codex',
          ),
          1 => 
          array (
            0 => 'codex',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      806 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::edit-song',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      833 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::edit-song-category',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      864 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::edit-text-type',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      881 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::edit-text',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      905 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::export',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      939 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::delete-codex',
          ),
          1 => 
          array (
            0 => 'codex',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      963 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::delete-song',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      990 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::delete-song-category',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1021 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::delete-text-type',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1039 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::delete-text',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1075 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::update-codex',
          ),
          1 => 
          array (
            0 => 'codex',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1100 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::update-song',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1128 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::update-song-category',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1160 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::update-text-type',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1178 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'codex::update-text',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1220 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.tokens.destroy',
          ),
          1 => 
          array (
            0 => 'token_id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.clients.update',
          ),
          1 => 
          array (
            0 => 'client_id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'passport.clients.destroy',
          ),
          1 => 
          array (
            0 => 'client_id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1291 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passport.personal.tokens.destroy',
          ),
          1 => 
          array (
            0 => 'token_id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1334 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::store::show',
            'store' => NULL,
          ),
          1 => 
          array (
            0 => 'store',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1356 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::store::buy',
          ),
          1 => 
          array (
            0 => 'store',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1397 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::index',
            'date' => NULL,
          ),
          1 => 
          array (
            0 => 'date',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1458 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::filter::name',
            'name' => NULL,
          ),
          1 => 
          array (
            0 => 'name',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1485 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::orders::filter::date',
            'date' => NULL,
          ),
          1 => 
          array (
            0 => 'date',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::aggregate',
          ),
          1 => 
          array (
            0 => 'account',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1548 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1572 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1596 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1613 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::accounts::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1648 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1675 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1688 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::bulkupdate',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1713 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::products::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1752 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1776 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1793 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::categories::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1827 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mywithdrawal',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1860 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mollie::status',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1885 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mollie::receive',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1910 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::mollie::monthly',
          ),
          1 => 
          array (
            0 => 'month',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1952 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1975 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::export',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1997 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::email',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2025 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2056 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::deleteuser',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2083 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::showAccounts',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2106 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::close',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2146 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::markfailed',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2177 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::markloss',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'omnomcom::withdrawal::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2231 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::scan',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2275 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::user::qr::approve',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::user::qr::info',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::user::dev_export',
          ),
          1 => 
          array (
            0 => 'table',
            1 => 'personal_key',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2368 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::discord::verify',
          ),
          1 => 
          array (
            0 => 'userId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2406 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::events::upcoming',
            'limit' => NULL,
          ),
          1 => 
          array (
            0 => 'limit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2442 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::photos::albumList',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2488 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wallstreet::updated_prices',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wallstreet::all_prices',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2547 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api::wallstreet::latest_events',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2595 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2619 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2643 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2669 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'announcement::dismiss',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2709 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'authorization::grant',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2733 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'authorization::revoke',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2763 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alias::delete',
          ),
          1 => 
          array (
            0 => 'id_or_alias',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2790 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achieve',
          ),
          1 => 
          array (
            0 => 'achievement',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2820 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2844 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2868 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2891 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::award',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2925 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::take',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2946 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::takeAll',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2969 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'achievement::icon',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3010 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'file::get',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3028 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'file::',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
            2 => 'name',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3079 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::category::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::category::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3104 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::category::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3133 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::approve',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3157 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::archive',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3184 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::reply',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3207 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::restore',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3232 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3258 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::index',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3290 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::search',
            'searchTerm' => NULL,
          ),
          1 => 
          array (
            0 => 'category',
            1 => 'searchTerm',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3303 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::store',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3324 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::archived',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3336 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'feedback::archiveall',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3379 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'image::get',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3397 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'image::',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
            2 => 'name',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3433 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ical::calendar',
            'personal_key' => NULL,
          ),
          1 => 
          array (
            0 => 'personal_key',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3471 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'headerimage::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3513 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login::password::reset::token',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3544 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3568 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3592 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'passwordstore::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3625 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3643 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::image',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3666 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::file::create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3690 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::file::delete',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'file_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3717 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3741 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3758 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page::show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3791 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::likes',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3816 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::dislikes',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3839 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3856 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::album::list',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3890 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3909 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::action',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3924 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::upload',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3939 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3966 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::publish',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3993 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'photo::admin::unpublish',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4050 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::rfid::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4063 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::rfid::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4078 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::rfid::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4114 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::registrationhelper::details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4143 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::2fa::admindelete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4182 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::impersonate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4214 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::omnomcomsound::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4229 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::omnomcomsound::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4245 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4263 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::remove',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4276 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::removeend',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4302 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::endinseptember',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4318 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::member::settype',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4363 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::toggle_studied_create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4386 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::toggle_studied_itech',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::toggle_nda',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4442 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::unblock_omnomcom',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4462 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user::admin::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4488 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user::profile',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4517 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'unsubscribefromlist',
          ),
          1 => 
          array (
            0 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4575 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::download::new',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4599 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::download::signed',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4623 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4647 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'memberform::print',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4673 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'membercard::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4687 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'membercard::print',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4713 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'membercard::download',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::orderUp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4766 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4792 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::orderDown',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4815 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4838 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4886 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4911 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'narrowcasting::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4944 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::image',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4984 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5008 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5039 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::sendWeekly',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5073 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::showWeeklyPreview',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5091 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'news::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5132 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5157 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5174 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'joboffers::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5217 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::entries::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5273 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leaderboards::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5338 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5362 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5385 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::close',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5409 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5432 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::admin',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5457 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::process',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5494 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::orderline::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::orderline::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5539 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::orderline::store',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5563 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::orderline::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5581 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dinnerform::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5610 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5634 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5658 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5692 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5716 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5740 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dmx::override::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5784 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::close',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5812 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5844 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5868 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5892 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5928 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::products::create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5961 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::events::products::remove',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'productId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5988 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6016 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::statistics',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6052 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::products::create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6085 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'wallstreet::products::remove',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'productId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6121 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'webhook::mollie',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welcomeMessages::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6208 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::financial::close',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::category::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6268 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::category::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6292 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::category::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6315 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6339 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6363 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6397 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::linkalbum',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::unlinkalbum',
          ),
          1 => 
          array (
            0 => 'album',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6446 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::archive',
          ),
          1 => 
          array (
            0 => 'year',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6468 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::admin',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6491 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::scan',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6517 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::login',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6559 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::togglepresence',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6591 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::addparticipation',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6612 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::addparticipationfor',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6647 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::deleteparticipation',
          ),
          1 => 
          array (
            0 => 'participation_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6674 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::updatehelp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6703 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::buytickets',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6730 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::addsignup',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6746 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::deletesignup',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6772 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::addhelp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6800 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::deletehelp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6827 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'event::checklist',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6866 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::list::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6890 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::list::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6914 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::list::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6937 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6983 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7012 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::toggleready',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7036 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7074 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::attachment::create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7098 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'email::attachment::delete',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'file_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7138 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7165 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7193 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::unscan',
            'barcode' => NULL,
          ),
          1 => 
          array (
            0 => 'barcode',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7221 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7246 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::download',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7269 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tickets::scan',
          ),
          1 => 
          array (
            0 => 'barcode',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'togglelist',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7331 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::make',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7358 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::end',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7378 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::endId',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7400 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7425 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tempadmin::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7468 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::admin::edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7492 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::admin::update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::admin::delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7534 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'video::show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7564 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr::code',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7584 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr::dialog',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7601 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr::approve',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7629 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'short_url::go',
            'short' => NULL,
          ),
          1 => 
          array (
            0 => 'short',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'saml2_logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'saml2/{idpName}/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'saml',
        ),
        'as' => 'saml2_logout',
        'uses' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@logout',
        'controller' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@logout',
        'namespace' => NULL,
        'prefix' => 'saml2/{idpName}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'saml2_login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'saml2/{idpName}/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'saml',
        ),
        'as' => 'saml2_login',
        'uses' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@login',
        'controller' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@login',
        'namespace' => NULL,
        'prefix' => 'saml2/{idpName}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'saml2_metadata' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'saml2/{idpName}/metadata',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'saml',
        ),
        'as' => 'saml2_metadata',
        'uses' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@metadata',
        'controller' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@metadata',
        'namespace' => NULL,
        'prefix' => 'saml2/{idpName}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'saml2_acs' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saml2/{idpName}/acs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'saml',
        ),
        'as' => 'saml2_acs',
        'uses' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@acs',
        'controller' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@acs',
        'namespace' => NULL,
        'prefix' => 'saml2/{idpName}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'saml2_sls' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'saml2/{idpName}/sls',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'saml',
        ),
        'as' => 'saml2_sls',
        'uses' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@sls',
        'controller' => 'Aacotroneo\\Saml2\\Http\\Controllers\\Saml2Controller@sls',
        'namespace' => NULL,
        'prefix' => 'saml2/{idpName}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7gYVMARyZyjLLP12' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'biscolab-recaptcha/validate',
      'action' => 
      array (
        'uses' => 'Biscolab\\ReCaptcha\\Controllers\\ReCaptchaController@validateV3',
        'controller' => 'Biscolab\\ReCaptcha\\Controllers\\ReCaptchaController@validateV3',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'generated::7gYVMARyZyjLLP12',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HAzAg1T3xxdBwYpT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '__clockwork/{id}/extended',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@getExtendedData',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@getExtendedData',
        'as' => 'generated::HAzAg1T3xxdBwYpT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '([0-9-]+|latest)',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5jZSYJfKnJ2cKZeH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '__clockwork/{id}/{direction?}/{count?}',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@getData',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@getData',
        'as' => 'generated::5jZSYJfKnJ2cKZeH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '([0-9-]+|latest)',
        'direction' => '(next|previous)',
        'count' => '\\d+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mjNgWVHJzGfUF3cz' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => '__clockwork/{id}',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@updateData',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@updateData',
        'as' => 'generated::mjNgWVHJzGfUF3cz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6zZcWfsXZnl1B5VG' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '__clockwork/auth',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@authenticate',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@authenticate',
        'as' => 'generated::6zZcWfsXZnl1B5VG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NgT6Ud9iWqmz8cs5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'clockwork',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webRedirect',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webRedirect',
        'as' => 'generated::NgT6Ud9iWqmz8cs5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iqm97qcPA6nIlC1V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'clockwork/app',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webIndex',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webIndex',
        'as' => 'generated::iqm97qcPA6nIlC1V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::X5XX0xiSEhiIB3IO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'clockwork/{path}',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webAsset',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webAsset',
        'as' => 'generated::X5XX0xiSEhiIB3IO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2lxzaF7ywPUTUcUH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '__clockwork',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webRedirect',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webRedirect',
        'as' => 'generated::2lxzaF7ywPUTUcUH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0M4yYVtmfAVbbzYn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '__clockwork/app',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webIndex',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webIndex',
        'as' => 'generated::0M4yYVtmfAVbbzYn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gOjV0GkpJcv4yY0y' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '__clockwork/{path}',
      'action' => 
      array (
        'uses' => 'Clockwork\\Support\\Laravel\\ClockworkController@webAsset',
        'controller' => 'Clockwork\\Support\\Laravel\\ClockworkController@webAsset',
        'as' => 'generated::gOjV0GkpJcv4yY0y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.token' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'oauth/token',
      'action' => 
      array (
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\AccessTokenController@issueToken',
        'as' => 'passport.token',
        'middleware' => 'throttle',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\AccessTokenController@issueToken',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.authorizations.authorize' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'oauth/authorize',
      'action' => 
      array (
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizationController@authorize',
        'as' => 'passport.authorizations.authorize',
        'middleware' => 'web',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizationController@authorize',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.token.refresh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'oauth/token/refresh',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\TransientTokenController@refresh',
        'as' => 'passport.token.refresh',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\TransientTokenController@refresh',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.authorizations.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'oauth/authorize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ApproveAuthorizationController@approve',
        'as' => 'passport.authorizations.approve',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ApproveAuthorizationController@approve',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.authorizations.deny' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'oauth/authorize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\DenyAuthorizationController@deny',
        'as' => 'passport.authorizations.deny',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\DenyAuthorizationController@deny',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.tokens.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'oauth/tokens',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizedAccessTokenController@forUser',
        'as' => 'passport.tokens.index',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizedAccessTokenController@forUser',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.tokens.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'oauth/tokens/{token_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizedAccessTokenController@destroy',
        'as' => 'passport.tokens.destroy',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\AuthorizedAccessTokenController@destroy',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.clients.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'oauth/clients',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@forUser',
        'as' => 'passport.clients.index',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@forUser',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.clients.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'oauth/clients',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@store',
        'as' => 'passport.clients.store',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@store',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.clients.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'oauth/clients/{client_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@update',
        'as' => 'passport.clients.update',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@update',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.clients.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'oauth/clients/{client_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@destroy',
        'as' => 'passport.clients.destroy',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ClientController@destroy',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.scopes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'oauth/scopes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\ScopeController@all',
        'as' => 'passport.scopes.index',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\ScopeController@all',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.personal.tokens.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'oauth/personal-access-tokens',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@forUser',
        'as' => 'passport.personal.tokens.index',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@forUser',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.personal.tokens.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'oauth/personal-access-tokens',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@store',
        'as' => 'passport.personal.tokens.store',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@store',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passport.personal.tokens.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'oauth/personal-access-tokens/{token_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@destroy',
        'as' => 'passport.personal.tokens.destroy',
        'controller' => 'Laravel\\Passport\\Http\\Controllers\\PersonalAccessTokenController@destroy',
        'namespace' => 'Laravel\\Passport\\Http\\Controllers',
        'prefix' => 'oauth',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::dmx_values' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/dmx_values',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::dmx_values',
        'uses' => 'App\\Http\\Controllers\\DmxController@valueApi',
        'controller' => 'App\\Http\\Controllers\\DmxController@valueApi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::token' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::token',
        'uses' => 'App\\Http\\Controllers\\ApiController@getToken',
        'controller' => 'App\\Http\\Controllers\\ApiController@getToken',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::scan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/scan/{event}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
        ),
        'as' => 'api::scan',
        'uses' => 'App\\Http\\Controllers\\TicketController@scanApi',
        'controller' => 'App\\Http\\Controllers\\TicketController@scanApi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::news' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/news',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::news',
        'uses' => 'App\\Http\\Controllers\\NewsController@apiIndex',
        'controller' => 'App\\Http\\Controllers\\NewsController@apiIndex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::verify_iban' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/verify_iban',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::verify_iban',
        'uses' => 'App\\Http\\Controllers\\BankController@verifyIban',
        'controller' => 'App\\Http\\Controllers\\BankController@verifyIban',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::user::qr::approve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/qr_auth_approve/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'as' => 'api::user::qr::approve',
        'uses' => 'App\\Http\\Controllers\\QrAuthController@apiApprove',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@apiApprove',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::user::qr::info' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/qr_auth_info/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'as' => 'api::user::qr::info',
        'uses' => 'App\\Http\\Controllers\\QrAuthController@apiInfo',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@apiInfo',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::user::qr::token' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'as' => 'api::user::qr::token',
        'uses' => 'App\\Http\\Controllers\\ApiController@getToken',
        'controller' => 'App\\Http\\Controllers\\ApiController@getToken',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::user::gdpr_export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/gdpr_export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
        ),
        'as' => 'api::user::gdpr_export',
        'uses' => 'App\\Http\\Controllers\\ApiController@gdprExport',
        'controller' => 'App\\Http\\Controllers\\ApiController@gdprExport',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::user::dev_export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/dev_export/{table}/{personal_key}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::user::dev_export',
        'uses' => 'App\\Http\\Controllers\\ExportController@export',
        'controller' => 'App\\Http\\Controllers\\ExportController@export',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::discord::redirect' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/discord/redirect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'as' => 'api::discord::redirect',
        'uses' => 'App\\Http\\Controllers\\DiscordController@discordLinkRedirect',
        'controller' => 'App\\Http\\Controllers\\DiscordController@discordLinkRedirect',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/discord',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::discord::linked' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/discord/linked',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'as' => 'api::discord::linked',
        'uses' => 'App\\Http\\Controllers\\DiscordController@discordLinkCallback',
        'controller' => 'App\\Http\\Controllers\\DiscordController@discordLinkCallback',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/discord',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::discord::unlink' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/discord/unlink',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'as' => 'api::discord::unlink',
        'uses' => 'App\\Http\\Controllers\\DiscordController@discordUnlink',
        'controller' => 'App\\Http\\Controllers\\DiscordController@discordUnlink',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/discord',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::discord::verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/discord/verify/{userId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'proboto',
        ),
        'as' => 'api::discord::verify',
        'uses' => 'App\\Http\\Controllers\\ApiController@discordVerifyMember',
        'controller' => 'App\\Http\\Controllers\\ApiController@discordVerifyMember',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/discord',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::events::upcoming' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/events/upcoming/{limit?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::events::upcoming',
        'uses' => 'App\\Http\\Controllers\\EventController@apiUpcomingEvents',
        'controller' => 'App\\Http\\Controllers\\EventController@apiUpcomingEvents',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::photos::randomPhoto' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/photos/random_photo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
        ),
        'as' => 'api::photos::randomPhoto',
        'uses' => 'App\\Http\\Controllers\\ApiController@randomPhoto',
        'controller' => 'App\\Http\\Controllers\\ApiController@randomPhoto',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::photos::albums' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/photos/photos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'as' => 'api::photos::albums',
        'uses' => 'App\\Http\\Controllers\\PhotoController@apiIndex',
        'controller' => 'App\\Http\\Controllers\\PhotoController@apiIndex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::photos::albumList' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/photos/photos/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'as' => 'api::photos::albumList',
        'uses' => 'App\\Http\\Controllers\\PhotoController@apiShow',
        'controller' => 'App\\Http\\Controllers\\PhotoController@apiShow',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::screen::bus' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/screen/bus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'api',
        ),
        'as' => 'api::screen::bus',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@bus',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@bus',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/screen',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::screen::timetable' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/screen/timetable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'api',
        ),
        'as' => 'api::screen::timetable',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@timetable',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@timetable',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/screen',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::screen::timetable::protopeners' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/screen/timetable/protopeners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'api',
        ),
        'as' => 'api::screen::timetable::protopeners',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@protopenersTimetable',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@protopenersTimetable',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/screen',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::screen::narrowcasting' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/screen/narrowcasting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'api',
        ),
        'as' => 'api::screen::narrowcasting',
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@indexApi',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@indexApi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/screen',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::protube::played' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/protube/played',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::protube::played',
        'uses' => 'App\\Http\\Controllers\\ApiController@protubePlayed',
        'controller' => 'App\\Http\\Controllers\\ApiController@protubePlayed',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::protube::' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/protube/userdetails',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth:api',
        ),
        'uses' => 'App\\Http\\Controllers\\ApiController@protubeUserDetails',
        'controller' => 'App\\Http\\Controllers\\ApiController@protubeUserDetails',
        'as' => 'api::protube::',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::search::user' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/search/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
          4 => 'permission:board|omnomcom',
        ),
        'as' => 'api::search::user',
        'uses' => 'App\\Http\\Controllers\\SearchController@getUserSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@getUserSearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/search',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::search::committee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/search/committee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
          4 => 'permission:board|omnomcom',
        ),
        'as' => 'api::search::committee',
        'uses' => 'App\\Http\\Controllers\\SearchController@getCommitteeSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@getCommitteeSearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/search',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::search::event' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/search/event',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
          4 => 'permission:board|omnomcom',
        ),
        'as' => 'api::search::event',
        'uses' => 'App\\Http\\Controllers\\SearchController@getEventSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@getEventSearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/search',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::search::product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/search/product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
          4 => 'permission:board|omnomcom',
        ),
        'as' => 'api::search::product',
        'uses' => 'App\\Http\\Controllers\\SearchController@getProductSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@getProductSearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/search',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::search::achievement' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/search/achievement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'auth',
          4 => 'permission:board|omnomcom',
        ),
        'as' => 'api::search::achievement',
        'uses' => 'App\\Http\\Controllers\\SearchController@getAchievementSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@getAchievementSearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/search',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::omnomcom::stock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/omnomcom/stock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::omnomcom::stock',
        'uses' => 'App\\Http\\Controllers\\OmNomController@stock',
        'controller' => 'App\\Http\\Controllers\\OmNomController@stock',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wallstreet::active' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallstreet/active',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::wallstreet::active',
        'uses' => 'App\\Http\\Controllers\\WallstreetController@active',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@active',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wallstreet::updated_prices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallstreet/updated_prices/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::wallstreet::updated_prices',
        'uses' => 'App\\Http\\Controllers\\WallstreetController@getUpdatedPricesJSON',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@getUpdatedPricesJSON',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wallstreet::all_prices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallstreet/all_prices/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::wallstreet::all_prices',
        'uses' => 'App\\Http\\Controllers\\WallstreetController@getAllPrices',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@getAllPrices',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wallstreet::latest_events' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallstreet/latest_events/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
        ),
        'as' => 'api::wallstreet::latest_events',
        'uses' => 'App\\Http\\Controllers\\WallstreetController@getLatestEvents',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@getLatestEvents',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wallstreet::toggle_event' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wallstreet/toggle_event',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'web',
          3 => 'permission:tipcie',
        ),
        'as' => 'api::wallstreet::toggle_event',
        'uses' => 'App\\Http\\Controllers\\WallstreetController@toggleEvent',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@toggleEvent',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::isalfredthere' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/isalfredthere',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
        ),
        'as' => 'api::isalfredthere',
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@getApi',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@getApi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api::wrapped' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/wrapped',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'forcedomain',
          2 => 'auth:api',
        ),
        'uses' => 'App\\Http\\Controllers\\WrappedController@index',
        'as' => 'api::wrapped',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'controller' => 'App\\Http\\Controllers\\WrappedController@index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::unX6qYdaYa29YEPN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'smartxp.nl',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::unX6qYdaYa29YEPN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uGpnA4cC7OSpY43I' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'www.smartxp.nl',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::uGpnA4cC7OSpY43I',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::G7vEChVP8SM4CfEe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'caniworkinthesmartxp.nl',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::G7vEChVP8SM4CfEe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::E6Im4u1r3ZaLA8Ui' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'www.caniworkinthesmartxp.nl',
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::E6Im4u1r3ZaLA8Ui',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rnoXLq1CwdibaBAX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'omnomcom.nl',
        'uses' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'controller' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::rnoXLq1CwdibaBAX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qc6tecLF9ZxgRdu4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'www.omnomcom.nl',
        'uses' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'controller' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::qc6tecLF9ZxgRdu4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UiGJyiwIWejiWLVj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'haveyoutriedturningitoffandonagain.nl',
        'uses' => 'App\\Http\\Controllers\\HomeController@developers',
        'controller' => 'App\\Http\\Controllers\\HomeController@developers',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::UiGJyiwIWejiWLVj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GhKg3J5n1V4wmVH7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'www.haveyoutriedturningitoffandonagain.nl',
        'uses' => 'App\\Http\\Controllers\\HomeController@developers',
        'controller' => 'App\\Http\\Controllers\\HomeController@developers',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::GhKg3J5n1V4wmVH7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RfCRapR5IQAECIIH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'isalfredthere.nl',
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::RfCRapR5IQAECIIH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4FbEs9019NfBPkNy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => 'www.isalfredthere.nl',
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::4FbEs9019NfBPkNy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'file::get' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'file/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => '',
        'uses' => 'App\\Http\\Controllers\\FileController@get',
        'controller' => 'App\\Http\\Controllers\\FileController@get',
        'as' => 'file::get',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/file',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'file::' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'file/{id}/{hash}/{name}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'domain' => '',
        'uses' => 'App\\Http\\Controllers\\FileController@get',
        'controller' => 'App\\Http\\Controllers\\FileController@get',
        'as' => 'file::',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/file',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'image::get' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'image/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\FileController@getImage',
        'controller' => 'App\\Http\\Controllers\\FileController@getImage',
        'as' => 'image::get',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/image',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'image::' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'image/{id}/{hash}/{name}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\FileController@getImage',
        'controller' => 'App\\Http\\Controllers\\FileController@getImage',
        'as' => 'image::',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/image',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2QD9sgRZyL4hR36M' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'developers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@developers',
        'controller' => 'App\\Http\\Controllers\\HomeController@developers',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::2QD9sgRZyL4hR36M',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'homepage' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@show',
        'controller' => 'App\\Http\\Controllers\\HomeController@show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'homepage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'fishcam' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'fishcam',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@fishcam',
        'controller' => 'App\\Http\\Controllers\\HomeController@fishcam',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'fishcam',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'becomeamember' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'becomeamember',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@becomeAMemberOf',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@becomeAMemberOf',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'becomeamember',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'headerimage::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'headerimage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:header-image',
        ),
        'uses' => 'App\\Http\\Controllers\\HeaderImageController@index',
        'controller' => 'App\\Http\\Controllers\\HeaderImageController@index',
        'as' => 'headerimage::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/headerimage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'headerimage::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'headerimage/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:header-image',
        ),
        'uses' => 'App\\Http\\Controllers\\HeaderImageController@create',
        'controller' => 'App\\Http\\Controllers\\HeaderImageController@create',
        'as' => 'headerimage::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/headerimage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'headerimage::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'headerimage/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:header-image',
        ),
        'uses' => 'App\\Http\\Controllers\\HeaderImageController@store',
        'controller' => 'App\\Http\\Controllers\\HeaderImageController@store',
        'as' => 'headerimage::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/headerimage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'headerimage::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'headerimage/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:header-image',
        ),
        'uses' => 'App\\Http\\Controllers\\HeaderImageController@destroy',
        'controller' => 'App\\Http\\Controllers\\HeaderImageController@destroy',
        'as' => 'headerimage::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/headerimage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'search::get' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SearchController@search',
        'controller' => 'App\\Http\\Controllers\\SearchController@search',
        'as' => 'search::get',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'search::post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SearchController@search',
        'controller' => 'App\\Http\\Controllers\\SearchController@search',
        'as' => 'search::post',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'search::opensearch' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'opensearch',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SearchController@openSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@openSearch',
        'as' => 'search::opensearch',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'search::ldap::get' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ldap/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'utwente',
        ),
        'uses' => 'App\\Http\\Controllers\\SearchController@ldapSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@ldapSearch',
        'as' => 'search::ldap::get',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/ldap',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'search::ldap::post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ldap/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'utwente',
        ),
        'uses' => 'App\\Http\\Controllers\\SearchController@ldapSearch',
        'controller' => 'App\\Http\\Controllers\\SearchController@ldapSearch',
        'as' => 'search::ldap::post',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/ldap',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getLogin',
        'controller' => 'App\\Http\\Controllers\\AuthController@getLogin',
        'as' => 'login::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postLogin',
        'controller' => 'App\\Http\\Controllers\\AuthController@postLogin',
        'as' => 'login::post',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getLogout',
        'controller' => 'App\\Http\\Controllers\\AuthController@getLogout',
        'as' => 'login::logout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::logout::redirect' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout/redirect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getLogoutRedirect',
        'controller' => 'App\\Http\\Controllers\\AuthController@getLogoutRedirect',
        'as' => 'login::logout::redirect',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::reset::token' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getPasswordReset',
        'controller' => 'App\\Http\\Controllers\\AuthController@getPasswordReset',
        'as' => 'login::password::reset::token',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::reset::submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postPasswordReset',
        'controller' => 'App\\Http\\Controllers\\AuthController@postPasswordReset',
        'as' => 'login::password::reset::submit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getPasswordResetEmail',
        'controller' => 'App\\Http\\Controllers\\AuthController@getPasswordResetEmail',
        'as' => 'login::password::reset',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::reset::send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postPasswordResetEmail',
        'controller' => 'App\\Http\\Controllers\\AuthController@postPasswordResetEmail',
        'as' => 'login::password::reset::send',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::sync::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getPasswordSync',
        'controller' => 'App\\Http\\Controllers\\AuthController@getPasswordSync',
        'as' => 'login::password::sync::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postPasswordSync',
        'controller' => 'App\\Http\\Controllers\\AuthController@postPasswordSync',
        'as' => 'login::password::sync',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::change::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/change',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getPasswordChange',
        'controller' => 'App\\Http\\Controllers\\AuthController@getPasswordChange',
        'as' => 'login::password::change::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::password::change' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/change',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postPasswordChange',
        'controller' => 'App\\Http\\Controllers\\AuthController@postPasswordChange',
        'as' => 'login::password::change',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/password',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::register::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@getRegister',
        'controller' => 'App\\Http\\Controllers\\AuthController@getRegister',
        'as' => 'login::register::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postRegister',
        'controller' => 'App\\Http\\Controllers\\AuthController@postRegister',
        'as' => 'login::register',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::register::surfconext' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register/surfconext',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postRegisterSurfConext',
        'controller' => 'App\\Http\\Controllers\\AuthController@postRegisterSurfConext',
        'as' => 'login::register::surfconext',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::edu' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'surfconext',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@startSurfConextAuth',
        'controller' => 'App\\Http\\Controllers\\AuthController@startSurfConextAuth',
        'as' => 'login::edu',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::edupost' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'surfconext/post',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@postSurfConextAuth',
        'controller' => 'App\\Http\\Controllers\\AuthController@postSurfConextAuth',
        'as' => 'login::edupost',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::requestusername::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'username',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@requestUsername',
        'controller' => 'App\\Http\\Controllers\\AuthController@requestUsername',
        'as' => 'login::requestusername::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login::requestusername' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'username',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@requestUsername',
        'controller' => 'App\\Http\\Controllers\\AuthController@requestUsername',
        'as' => 'login::requestusername',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@deleteUser',
        'controller' => 'App\\Http\\Controllers\\AuthController@deleteUser',
        'as' => 'user::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::changepassword' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthController@updatePassword',
        'controller' => 'App\\Http\\Controllers\\AuthController@updatePassword',
        'as' => 'user::changepassword',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::personal_key::generate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/personal_key',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@generateKey',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@generateKey',
        'as' => 'user::personal_key::generate',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::memberprofile::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/memberprofile/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@getCompleteProfile',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@getCompleteProfile',
        'as' => 'user::memberprofile::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/memberprofile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::memberprofile::complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/memberprofile/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@postCompleteProfile',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@postCompleteProfile',
        'as' => 'user::memberprofile::complete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/memberprofile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::memberprofile::showclear' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/memberprofile/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@getClearProfile',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@getClearProfile',
        'as' => 'user::memberprofile::showclear',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/memberprofile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::memberprofile::clear' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/memberprofile/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@postClearProfile',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@postClearProfile',
        'as' => 'user::memberprofile::clear',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/memberprofile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::changemail' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/change_email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@updateMail',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@updateMail',
        'as' => 'user::changemail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::dashboard::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@show',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@show',
        'as' => 'user::dashboard::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@update',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@update',
        'as' => 'user::dashboard',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::quitimpersonating' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/quit_impersonating',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@quitImpersonating',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@quitImpersonating',
        'as' => 'user::quitimpersonating',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/address/show',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@add',
        'controller' => 'App\\Http\\Controllers\\AddressController@add',
        'as' => 'user::address::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/address/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@store',
        'controller' => 'App\\Http\\Controllers\\AddressController@store',
        'as' => 'user::address::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/address/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@destroy',
        'controller' => 'App\\Http\\Controllers\\AddressController@destroy',
        'as' => 'user::address::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/address/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@edit',
        'controller' => 'App\\Http\\Controllers\\AddressController@edit',
        'as' => 'user::address::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/address/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@update',
        'controller' => 'App\\Http\\Controllers\\AddressController@update',
        'as' => 'user::address::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::address::togglehidden' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/address/togglehidden',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AddressController@toggleHidden',
        'controller' => 'App\\Http\\Controllers\\AddressController@toggleHidden',
        'as' => 'user::address::togglehidden',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::diet::edit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/diet/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@editDiet',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@editDiet',
        'as' => 'user::diet::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::bank::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/bank/show',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\BankController@show',
        'controller' => 'App\\Http\\Controllers\\BankController@show',
        'as' => 'user::bank::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::bank::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/bank/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\BankController@store',
        'controller' => 'App\\Http\\Controllers\\BankController@store',
        'as' => 'user::bank::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::bank::delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/bank/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\BankController@destroy',
        'controller' => 'App\\Http\\Controllers\\BankController@destroy',
        'as' => 'user::bank::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::bank::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/bank/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\BankController@edit',
        'controller' => 'App\\Http\\Controllers\\BankController@edit',
        'as' => 'user::bank::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::bank::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/bank/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\BankController@update',
        'controller' => 'App\\Http\\Controllers\\BankController@update',
        'as' => 'user::bank::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::rfid::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/rfidcard/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RfidCardController@destroy',
        'controller' => 'App\\Http\\Controllers\\RfidCardController@destroy',
        'as' => 'user::rfid::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/rfidcard/{id}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::rfid::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/rfidcard/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RfidCardController@edit',
        'controller' => 'App\\Http\\Controllers\\RfidCardController@edit',
        'as' => 'user::rfid::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/rfidcard/{id}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::rfid::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/rfidcard/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RfidCardController@update',
        'controller' => 'App\\Http\\Controllers\\RfidCardController@update',
        'as' => 'user::rfid::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/rfidcard/{id}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::pic::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/profilepic/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProfilePictureController@update',
        'controller' => 'App\\Http\\Controllers\\ProfilePictureController@update',
        'as' => 'user::pic::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/profilepic',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::pic::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/profilepic/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProfilePictureController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProfilePictureController@destroy',
        'as' => 'user::pic::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/profilepic',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::edu::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/edu/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SurfConextController@destroy',
        'controller' => 'App\\Http\\Controllers\\SurfConextController@destroy',
        'as' => 'user::edu::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/edu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::edu::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/edu/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SurfConextController@create',
        'controller' => 'App\\Http\\Controllers\\SurfConextController@create',
        'as' => 'user::edu::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/edu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::2fa::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/2fa/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TFAController@create',
        'controller' => 'App\\Http\\Controllers\\TFAController@create',
        'as' => 'user::2fa::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/2fa',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::2fa::delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/2fa/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TFAController@destroy',
        'controller' => 'App\\Http\\Controllers\\TFAController@destroy',
        'as' => 'user::2fa::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/2fa',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::2fa::admindelete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/2fa/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TFAController@adminDestroy',
        'controller' => 'App\\Http\\Controllers\\TFAController@adminDestroy',
        'as' => 'user::2fa::admindelete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/2fa',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::registrationhelper::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/registrationhelper',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\RegistrationHelperController@index',
        'controller' => 'App\\Http\\Controllers\\RegistrationHelperController@index',
        'as' => 'user::registrationhelper::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/registrationhelper',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::registrationhelper::details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/registrationhelper/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\RegistrationHelperController@details',
        'controller' => 'App\\Http\\Controllers\\RegistrationHelperController@details',
        'as' => 'user::registrationhelper::details',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/registrationhelper',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::impersonate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/{id}/member/impersonate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
          5 => 'auth',
          6 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@impersonate',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@impersonate',
        'as' => 'user::member::impersonate',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::omnomcomsound::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/omnomcomsound/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
          5 => 'auth',
          6 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@uploadOmnomcomSound',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@uploadOmnomcomSound',
        'as' => 'user::member::omnomcomsound::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member/omnomcomsound',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::omnomcomsound::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/{id}/member/omnomcomsound/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
          5 => 'auth',
          6 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@deleteOmnomcomSound',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@deleteOmnomcomSound',
        'as' => 'user::member::omnomcomsound::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member/omnomcomsound',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@addMembership',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@addMembership',
        'as' => 'user::member::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::remove' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/remove',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@endMembership',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@endMembership',
        'as' => 'user::member::remove',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::endinseptember' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/end_in_september',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@EndMembershipInSeptember',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@EndMembershipInSeptember',
        'as' => 'user::member::endinseptember',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::removeend' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/remove_end',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@removeMembershipEnd',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@removeMembershipEnd',
        'as' => 'user::member::removeend',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::member::settype' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/member/settype',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:registermembers',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@setMembershipType',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@setMembershipType',
        'as' => 'user::member::settype',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/{id}/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@index',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@index',
        'as' => 'user::admin::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::toggle_studied_create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/studied_create/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@toggleStudiedCreate',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@toggleStudiedCreate',
        'as' => 'user::admin::toggle_studied_create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::toggle_studied_itech' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/studied_itech/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@toggleStudiedITech',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@toggleStudiedITech',
        'as' => 'user::admin::toggle_studied_itech',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::toggle_nda' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/nda/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
          5 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@toggleNda',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@toggleNda',
        'as' => 'user::admin::toggle_nda',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::unblock_omnomcom' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/unblock_omnomcom/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@unblockOmnomcom',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@unblockOmnomcom',
        'as' => 'user::admin::unblock_omnomcom',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/admin/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@details',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@details',
        'as' => 'user::admin::details',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::admin::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/admin/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@update',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@update',
        'as' => 'user::admin::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'user/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user::profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\UserProfileController@show',
        'controller' => 'App\\Http\\Controllers\\UserProfileController@show',
        'as' => 'user::profile',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/user',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::showsign' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'memberform/sign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@getMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@getMemberForm',
        'as' => 'memberform::showsign',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/memberform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::sign' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'memberform/sign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserDashboardController@postMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserDashboardController@postMemberForm',
        'as' => 'memberform::sign',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/memberform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::download::new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'memberform/download/new/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@getNewMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@getNewMemberForm',
        'as' => 'memberform::download::new',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'memberform/download',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::download::signed' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'memberform/download/signed/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@getSignedMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@getSignedMemberForm',
        'as' => 'memberform::download::signed',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'memberform/download',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::print' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'memberform/print/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@printMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@printMemberForm',
        'as' => 'memberform::print',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/memberform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'memberform::delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'memberform/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\UserAdminController@destroyMemberForm',
        'controller' => 'App\\Http\\Controllers\\UserAdminController@destroyMemberForm',
        'as' => 'memberform::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/memberform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::membership::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee/membership/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@addMembership',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@addMembership',
        'as' => 'committee::membership::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'committee/membership',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::membership::endedition' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/membership/end/{committee}/{edition}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@endEdition',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@endEdition',
        'as' => 'committee::membership::endedition',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'committee/membership',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::membership::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/membership/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@deleteMembership',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@deleteMembership',
        'as' => 'committee::membership::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'committee/membership',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::membership::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/membership/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@editMembershipForm',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@editMembershipForm',
        'as' => 'committee::membership::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'committee/membership',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::membership::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee/membership/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@updateMembershipForm',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@updateMembershipForm',
        'as' => 'committee::membership::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'committee/membership',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@create',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@create',
        'as' => 'committee::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@store',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@store',
        'as' => 'committee::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@edit',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@edit',
        'as' => 'committee::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@update',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@update',
        'as' => 'committee::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee/{id}/image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@image',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@image',
        'as' => 'committee::image',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@index',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@index',
        'as' => 'committee::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@show',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@show',
        'as' => 'committee::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::anonymousmail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/{id}/send_anonymous_email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@showAnonMailForm',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@showAnonMailForm',
        'as' => 'committee::anonymousmail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::sendanonymousmail' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'committee/{id}/send_anonymous_email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@sendAnonMailForm',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@sendAnonMailForm',
        'as' => 'committee::sendanonymousmail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'committee::toggle_helper_reminder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'committee/{slug}/toggle_helper_reminder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@toggleHelperReminder',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@toggleHelperReminder',
        'as' => 'committee::toggle_helper_reminder',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/committee',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'society::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'society/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@overview',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@overview',
        'as' => 'society::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/society',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'showSociety' => true,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'society::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'society/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CommitteeController@show',
        'controller' => 'App\\Http\\Controllers\\CommitteeController@show',
        'as' => 'society::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/society',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@index',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@index',
        'as' => 'narrowcasting::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@create',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@create',
        'as' => 'narrowcasting::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'narrowcasting/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@store',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@store',
        'as' => 'narrowcasting::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@edit',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@edit',
        'as' => 'narrowcasting::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'narrowcasting/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@update',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@update',
        'as' => 'narrowcasting::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@destroy',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@destroy',
        'as' => 'narrowcasting::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::clear' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@clear',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@clear',
        'as' => 'narrowcasting::clear',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'narrowcasting::display' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'narrowcasting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\NarrowcastingController@show',
        'controller' => 'App\\Http\\Controllers\\NarrowcastingController@show',
        'as' => 'narrowcasting::display',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/narrowcasting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@adminIndex',
        'controller' => 'App\\Http\\Controllers\\CompanyController@adminIndex',
        'as' => 'companies::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@create',
        'controller' => 'App\\Http\\Controllers\\CompanyController@create',
        'as' => 'companies::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'companies/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@store',
        'controller' => 'App\\Http\\Controllers\\CompanyController@store',
        'as' => 'companies::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@edit',
        'controller' => 'App\\Http\\Controllers\\CompanyController@edit',
        'as' => 'companies::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'companies/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@update',
        'controller' => 'App\\Http\\Controllers\\CompanyController@update',
        'as' => 'companies::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@destroy',
        'controller' => 'App\\Http\\Controllers\\CompanyController@destroy',
        'as' => 'companies::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::orderUp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/up/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@orderUp',
        'controller' => 'App\\Http\\Controllers\\CompanyController@orderUp',
        'as' => 'companies::orderUp',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::orderDown' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/down/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@orderDown',
        'controller' => 'App\\Http\\Controllers\\CompanyController@orderDown',
        'as' => 'companies::orderDown',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@index',
        'controller' => 'App\\Http\\Controllers\\CompanyController@index',
        'as' => 'companies::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'companies::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'companies/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@show',
        'controller' => 'App\\Http\\Controllers\\CompanyController@show',
        'as' => 'companies::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/companies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'membercard::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'membercard/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@indexmembercard',
        'controller' => 'App\\Http\\Controllers\\CompanyController@indexmembercard',
        'as' => 'membercard::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/membercard',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'membercard::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'membercard/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@showmembercard',
        'controller' => 'App\\Http\\Controllers\\CompanyController@showmembercard',
        'as' => 'membercard::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/membercard',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'membercard::print' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'membercard/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberCardController@startPrint',
        'controller' => 'App\\Http\\Controllers\\MemberCardController@startPrint',
        'as' => 'membercard::print',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/membercard',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'membercard::download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'membercard/download/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberCardController@download',
        'controller' => 'App\\Http\\Controllers\\MemberCardController@download',
        'as' => 'membercard::download',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/membercard',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@adminIndex',
        'controller' => 'App\\Http\\Controllers\\JobofferController@adminIndex',
        'as' => 'joboffers::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@create',
        'controller' => 'App\\Http\\Controllers\\JobofferController@create',
        'as' => 'joboffers::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'joboffers/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@store',
        'controller' => 'App\\Http\\Controllers\\JobofferController@store',
        'as' => 'joboffers::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@edit',
        'controller' => 'App\\Http\\Controllers\\JobofferController@edit',
        'as' => 'joboffers::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'joboffers/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@update',
        'controller' => 'App\\Http\\Controllers\\JobofferController@update',
        'as' => 'joboffers::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@destroy',
        'controller' => 'App\\Http\\Controllers\\JobofferController@destroy',
        'as' => 'joboffers::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@index',
        'controller' => 'App\\Http\\Controllers\\JobofferController@index',
        'as' => 'joboffers::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'joboffers::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'joboffers/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\JobofferController@show',
        'controller' => 'App\\Http\\Controllers\\JobofferController@show',
        'as' => 'joboffers::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/joboffers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@adminIndex',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@adminIndex',
        'as' => 'leaderboards::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@edit',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@edit',
        'as' => 'leaderboards::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leaderboards/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@update',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@update',
        'as' => 'leaderboards::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@create',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@create',
        'as' => 'leaderboards::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leaderboards/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@store',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@store',
        'as' => 'leaderboards::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@destroy',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@destroy',
        'as' => 'leaderboards::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardController@index',
        'controller' => 'App\\Http\\Controllers\\LeaderboardController@index',
        'as' => 'leaderboards::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/leaderboards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::entries::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leaderboards/entries/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardEntryController@store',
        'controller' => 'App\\Http\\Controllers\\LeaderboardEntryController@store',
        'as' => 'leaderboards::entries::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'leaderboards/entries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::entries::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leaderboards/entries/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardEntryController@update',
        'controller' => 'App\\Http\\Controllers\\LeaderboardEntryController@update',
        'as' => 'leaderboards::entries::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'leaderboards/entries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leaderboards::entries::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leaderboards/entries/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaderboardEntryController@destroy',
        'controller' => 'App\\Http\\Controllers\\LeaderboardEntryController@destroy',
        'as' => 'leaderboards::entries::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'leaderboards/entries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@create',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@create',
        'as' => 'dinnerform::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dinnerform/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@store',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@store',
        'as' => 'dinnerform::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@edit',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@edit',
        'as' => 'dinnerform::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dinnerform/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@update',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@update',
        'as' => 'dinnerform::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::close' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/close/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@close',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@close',
        'as' => 'dinnerform::close',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@destroy',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@destroy',
        'as' => 'dinnerform::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/admin/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@admin',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@admin',
        'as' => 'dinnerform::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::process' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/process/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@process',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@process',
        'as' => 'dinnerform::process',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::orderline::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/orderline/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformOrderlineController@delete',
        'controller' => 'App\\Http\\Controllers\\DinnerformOrderlineController@delete',
        'as' => 'dinnerform::orderline::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dinnerform/orderline',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::orderline::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/orderline/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformOrderlineController@edit',
        'controller' => 'App\\Http\\Controllers\\DinnerformOrderlineController@edit',
        'as' => 'dinnerform::orderline::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dinnerform/orderline',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::orderline::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dinnerform/orderline/store/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformOrderlineController@store',
        'controller' => 'App\\Http\\Controllers\\DinnerformOrderlineController@store',
        'as' => 'dinnerform::orderline::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dinnerform/orderline',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::orderline::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dinnerform/orderline/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformOrderlineController@update',
        'controller' => 'App\\Http\\Controllers\\DinnerformOrderlineController@update',
        'as' => 'dinnerform::orderline::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dinnerform/orderline',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dinnerform::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dinnerform/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\DinnerformController@show',
        'controller' => 'App\\Http\\Controllers\\DinnerformController@show',
        'as' => 'dinnerform::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dinnerform',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@index',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@index',
        'as' => 'wallstreet::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::marquee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/marquee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@marquee',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@marquee',
        'as' => 'wallstreet::marquee',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@store',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@store',
        'as' => 'wallstreet::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::close' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/close/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@close',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@close',
        'as' => 'wallstreet::close',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@edit',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@edit',
        'as' => 'wallstreet::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@update',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@update',
        'as' => 'wallstreet::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@destroy',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@destroy',
        'as' => 'wallstreet::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/statistics/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@statistics',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@statistics',
        'as' => 'wallstreet::statistics',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/wallstreet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::products::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/products/create/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@addProducts',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@addProducts',
        'as' => 'wallstreet::products::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::products::remove' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/products/remove/{id}/{productId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@removeProduct',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@removeProduct',
        'as' => 'wallstreet::products::remove',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@eventIndex',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@eventIndex',
        'as' => 'wallstreet::events::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/events/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@addEvent',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@addEvent',
        'as' => 'wallstreet::events::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/events/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@editEvent',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@editEvent',
        'as' => 'wallstreet::events::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/events/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@updateEvent',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@updateEvent',
        'as' => 'wallstreet::events::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/events/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@destroyEvent',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@destroyEvent',
        'as' => 'wallstreet::events::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::products::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'wallstreet/events/products/create/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@addEventProducts',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@addEventProducts',
        'as' => 'wallstreet::events::products::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'wallstreet::events::products::remove' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'wallstreet/events/products/remove/{id}/{productId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\WallstreetController@removeEventProduct',
        'controller' => 'App\\Http\\Controllers\\WallstreetController@removeEventProduct',
        'as' => 'wallstreet::events::products::remove',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'wallstreet/events/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::financial::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/financial/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@finindex',
        'controller' => 'App\\Http\\Controllers\\EventController@finindex',
        'as' => 'event::financial::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/financial',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::financial::close' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/financial/close/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@finclose',
        'controller' => 'App\\Http\\Controllers\\EventController@finclose',
        'as' => 'event::financial::close',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/financial',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::category::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/categories/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@categoryAdmin',
        'controller' => 'App\\Http\\Controllers\\EventController@categoryAdmin',
        'as' => 'event::category::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::category::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/categories/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@categoryStore',
        'controller' => 'App\\Http\\Controllers\\EventController@categoryStore',
        'as' => 'event::category::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::category::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/categories/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@categoryEdit',
        'controller' => 'App\\Http\\Controllers\\EventController@categoryEdit',
        'as' => 'event::category::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::category::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/categories/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@categoryUpdate',
        'controller' => 'App\\Http\\Controllers\\EventController@categoryUpdate',
        'as' => 'event::category::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::category::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/categories/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@categoryDestroy',
        'controller' => 'App\\Http\\Controllers\\EventController@categoryDestroy',
        'as' => 'event::category::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'events/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@create',
        'controller' => 'App\\Http\\Controllers\\EventController@create',
        'as' => 'event::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@store',
        'controller' => 'App\\Http\\Controllers\\EventController@store',
        'as' => 'event::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@edit',
        'controller' => 'App\\Http\\Controllers\\EventController@edit',
        'as' => 'event::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@update',
        'controller' => 'App\\Http\\Controllers\\EventController@update',
        'as' => 'event::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@destroy',
        'controller' => 'App\\Http\\Controllers\\EventController@destroy',
        'as' => 'event::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::linkalbum' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/album/{event}/link',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@linkAlbum',
        'controller' => 'App\\Http\\Controllers\\EventController@linkAlbum',
        'as' => 'event::linkalbum',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::unlinkalbum' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/album/unlink/{album}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@unlinkAlbum',
        'controller' => 'App\\Http\\Controllers\\EventController@unlinkAlbum',
        'as' => 'event::unlinkalbum',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@index',
        'controller' => 'App\\Http\\Controllers\\EventController@index',
        'as' => 'event::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::archive' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/archive/{year}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@archive',
        'controller' => 'App\\Http\\Controllers\\EventController@archive',
        'as' => 'event::archive',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::copy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/copy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@copyEvent',
        'controller' => 'App\\Http\\Controllers\\EventController@copyEvent',
        'as' => 'event::copy',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/admin/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@admin',
        'controller' => 'App\\Http\\Controllers\\EventController@admin',
        'as' => 'event::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::scan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/scan/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@scan',
        'controller' => 'App\\Http\\Controllers\\EventController@scan',
        'as' => 'event::scan',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::set_reminder' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/set_reminder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@setReminder',
        'controller' => 'App\\Http\\Controllers\\EventController@setReminder',
        'as' => 'event::set_reminder',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::toggle_relevant_only' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/toggle_relevant_only',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@toggleRelevantOnly',
        'controller' => 'App\\Http\\Controllers\\EventController@toggleRelevantOnly',
        'as' => 'event::toggle_relevant_only',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/{id}/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@forceLogin',
        'controller' => 'App\\Http\\Controllers\\EventController@forceLogin',
        'as' => 'event::login',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@show',
        'controller' => 'App\\Http\\Controllers\\EventController@show',
        'as' => 'event::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::togglepresence' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/togglepresence/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ParticipationController@togglePresence',
        'controller' => 'App\\Http\\Controllers\\ParticipationController@togglePresence',
        'as' => 'event::togglepresence',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::addparticipation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/participate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\ParticipationController@create',
        'controller' => 'App\\Http\\Controllers\\ParticipationController@create',
        'as' => 'event::addparticipation',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::deleteparticipation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/unparticipate/{participation_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\ParticipationController@destroy',
        'controller' => 'App\\Http\\Controllers\\ParticipationController@destroy',
        'as' => 'event::deleteparticipation',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::addparticipationfor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/participatefor/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ParticipationController@createFor',
        'controller' => 'App\\Http\\Controllers\\ParticipationController@createFor',
        'as' => 'event::addparticipationfor',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::buytickets' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/buytickets/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@buyForEvent',
        'controller' => 'App\\Http\\Controllers\\TicketController@buyForEvent',
        'as' => 'event::buytickets',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::addsignup' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/signup/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@store',
        'controller' => 'App\\Http\\Controllers\\ActivityController@store',
        'as' => 'event::addsignup',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::deletesignup' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/signup/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@destroy',
        'controller' => 'App\\Http\\Controllers\\ActivityController@destroy',
        'as' => 'event::deletesignup',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::addhelp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/addhelp/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@addHelp',
        'controller' => 'App\\Http\\Controllers\\ActivityController@addHelp',
        'as' => 'event::addhelp',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::updatehelp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'events/updatehelp/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@updateHelp',
        'controller' => 'App\\Http\\Controllers\\ActivityController@updateHelp',
        'as' => 'event::updatehelp',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::deletehelp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/deletehelp/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@deleteHelp',
        'controller' => 'App\\Http\\Controllers\\ActivityController@deleteHelp',
        'as' => 'event::deletehelp',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'event::checklist' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'events/checklist/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\ActivityController@checklist',
        'controller' => 'App\\Http\\Controllers\\ActivityController@checklist',
        'as' => 'event::checklist',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/events',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@index',
        'controller' => 'App\\Http\\Controllers\\PageController@index',
        'as' => 'page::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@create',
        'controller' => 'App\\Http\\Controllers\\PageController@create',
        'as' => 'page::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@store',
        'controller' => 'App\\Http\\Controllers\\PageController@store',
        'as' => 'page::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@edit',
        'controller' => 'App\\Http\\Controllers\\PageController@edit',
        'as' => 'page::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@update',
        'controller' => 'App\\Http\\Controllers\\PageController@update',
        'as' => 'page::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page/edit/{id}/image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@featuredImage',
        'controller' => 'App\\Http\\Controllers\\PageController@featuredImage',
        'as' => 'page::image',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@destroy',
        'controller' => 'App\\Http\\Controllers\\PageController@destroy',
        'as' => 'page::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::file::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page/edit/{id}/file/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@addFile',
        'controller' => 'App\\Http\\Controllers\\PageController@addFile',
        'as' => 'page::file::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'page/edit/{id}/file',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::file::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page/edit/{id}/file/{file_id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@deleteFile',
        'controller' => 'App\\Http\\Controllers\\PageController@deleteFile',
        'as' => 'page::file::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'page/edit/{id}/file',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\PageController@show',
        'as' => 'page::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/page',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@admin',
        'controller' => 'App\\Http\\Controllers\\NewsController@admin',
        'as' => 'news::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@create',
        'controller' => 'App\\Http\\Controllers\\NewsController@create',
        'as' => 'news::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'news/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@store',
        'controller' => 'App\\Http\\Controllers\\NewsController@store',
        'as' => 'news::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@edit',
        'controller' => 'App\\Http\\Controllers\\NewsController@edit',
        'as' => 'news::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'news/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@update',
        'controller' => 'App\\Http\\Controllers\\NewsController@update',
        'as' => 'news::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'news/edit/{id}/image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@featuredImage',
        'controller' => 'App\\Http\\Controllers\\NewsController@featuredImage',
        'as' => 'news::image',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@destroy',
        'controller' => 'App\\Http\\Controllers\\NewsController@destroy',
        'as' => 'news::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::sendWeekly' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/sendWeekly/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@sendWeeklyEmail',
        'controller' => 'App\\Http\\Controllers\\NewsController@sendWeeklyEmail',
        'as' => 'news::sendWeekly',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::showWeeklyPreview' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/showWeeklyPreview/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@showWeeklyPreview',
        'controller' => 'App\\Http\\Controllers\\NewsController@showWeeklyPreview',
        'as' => 'news::showWeeklyPreview',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@index',
        'controller' => 'App\\Http\\Controllers\\NewsController@index',
        'as' => 'news::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'news::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'news/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\NewsController@show',
        'controller' => 'App\\Http\\Controllers\\NewsController@show',
        'as' => 'news::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/news',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@index',
        'controller' => 'App\\Http\\Controllers\\MenuController@index',
        'as' => 'menu::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@create',
        'controller' => 'App\\Http\\Controllers\\MenuController@create',
        'as' => 'menu::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'menu/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@store',
        'controller' => 'App\\Http\\Controllers\\MenuController@store',
        'as' => 'menu::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::orderUp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu/up/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@orderUp',
        'controller' => 'App\\Http\\Controllers\\MenuController@orderUp',
        'as' => 'menu::orderUp',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::orderDown' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu/down/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@orderDown',
        'controller' => 'App\\Http\\Controllers\\MenuController@orderDown',
        'as' => 'menu::orderDown',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@edit',
        'controller' => 'App\\Http\\Controllers\\MenuController@edit',
        'as' => 'menu::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'menu/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@update',
        'controller' => 'App\\Http\\Controllers\\MenuController@update',
        'as' => 'menu::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\MenuController@destroy',
        'controller' => 'App\\Http\\Controllers\\MenuController@destroy',
        'as' => 'menu::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/menu',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@index',
        'controller' => 'App\\Http\\Controllers\\TicketController@index',
        'as' => 'tickets::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@create',
        'controller' => 'App\\Http\\Controllers\\TicketController@create',
        'as' => 'tickets::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tickets/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@store',
        'controller' => 'App\\Http\\Controllers\\TicketController@store',
        'as' => 'tickets::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@edit',
        'controller' => 'App\\Http\\Controllers\\TicketController@edit',
        'as' => 'tickets::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tickets/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@update',
        'controller' => 'App\\Http\\Controllers\\TicketController@update',
        'as' => 'tickets::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'auth',
          4 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@destroy',
        'controller' => 'App\\Http\\Controllers\\TicketController@destroy',
        'as' => 'tickets::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::scan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/scan/{barcode}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@scan',
        'controller' => 'App\\Http\\Controllers\\TicketController@scan',
        'as' => 'tickets::scan',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::unscan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/unscan/{barcode?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@unscan',
        'controller' => 'App\\Http\\Controllers\\TicketController@unscan',
        'as' => 'tickets::unscan',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tickets::download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tickets/download/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TicketController@download',
        'controller' => 'App\\Http\\Controllers\\TicketController@download',
        'as' => 'tickets::download',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tickets',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::list::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/list/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@create',
        'controller' => 'App\\Http\\Controllers\\EmailListController@create',
        'as' => 'email::list::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/list',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::list::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/list/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@store',
        'controller' => 'App\\Http\\Controllers\\EmailListController@store',
        'as' => 'email::list::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/list',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::list::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/list/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@edit',
        'controller' => 'App\\Http\\Controllers\\EmailListController@edit',
        'as' => 'email::list::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/list',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::list::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/list/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@update',
        'controller' => 'App\\Http\\Controllers\\EmailListController@update',
        'as' => 'email::list::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/list',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::list::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/list/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@destroy',
        'controller' => 'App\\Http\\Controllers\\EmailListController@destroy',
        'as' => 'email::list::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/list',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@index',
        'controller' => 'App\\Http\\Controllers\\EmailController@index',
        'as' => 'email::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::filter' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/filter',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@filter',
        'controller' => 'App\\Http\\Controllers\\EmailController@filter',
        'as' => 'email::filter',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@create',
        'controller' => 'App\\Http\\Controllers\\EmailController@create',
        'as' => 'email::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@store',
        'controller' => 'App\\Http\\Controllers\\EmailController@store',
        'as' => 'email::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/show/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@show',
        'controller' => 'App\\Http\\Controllers\\EmailController@show',
        'as' => 'email::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@edit',
        'controller' => 'App\\Http\\Controllers\\EmailController@edit',
        'as' => 'email::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@update',
        'controller' => 'App\\Http\\Controllers\\EmailController@update',
        'as' => 'email::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::toggleready' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/toggleready/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@toggleReady',
        'controller' => 'App\\Http\\Controllers\\EmailController@toggleReady',
        'as' => 'email::toggleready',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@destroy',
        'controller' => 'App\\Http\\Controllers\\EmailController@destroy',
        'as' => 'email::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::attachment::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/{id}/attachment/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@addAttachment',
        'controller' => 'App\\Http\\Controllers\\EmailController@addAttachment',
        'as' => 'email::attachment::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/{id}/attachment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'email::attachment::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/{id}/attachment/delete/{file_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@deleteAttachment',
        'controller' => 'App\\Http\\Controllers\\EmailController@deleteAttachment',
        'as' => 'email::attachment::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'email/{id}/attachment',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'togglelist' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'togglelist/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailListController@toggleSubscription',
        'controller' => 'App\\Http\\Controllers\\EmailListController@toggleSubscription',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'togglelist',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'unsubscribefromlist' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'unsubscribe/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EmailController@unsubscribeLink',
        'controller' => 'App\\Http\\Controllers\\EmailController@unsubscribeLink',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'unsubscribefromlist',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotes::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'as' => 'quotes::list',
        0 => 
        \Closure::__set_state(array(
        )),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:137:"fn(\\Illuminate\\Http\\Request $request): \\Illuminate\\View\\View => (new \\App\\Http\\Controllers\\FeedbackController)->index($request, \'quotes\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000e260000000000000000";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'goodideas::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'goodideas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'as' => 'goodideas::index',
        0 => 
        \Closure::__set_state(array(
        )),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:140:"fn(\\Illuminate\\Http\\Request $request): \\Illuminate\\View\\View => (new \\App\\Http\\Controllers\\FeedbackController)->index($request, \'goodideas\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000e360000000000000000";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::category::admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/categories/admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@categoryAdmin',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@categoryAdmin',
        'as' => 'feedback::category::admin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::category::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'feedback/categories/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@categoryStore',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@categoryStore',
        'as' => 'feedback::category::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::category::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/categories/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@categoryEdit',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@categoryEdit',
        'as' => 'feedback::category::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::category::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'feedback/categories/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@categoryUpdate',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@categoryUpdate',
        'as' => 'feedback::category::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::category::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/categories/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@categoryDestroy',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@categoryDestroy',
        'as' => 'feedback::category::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::approve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/approve/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@approve',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@approve',
        'as' => 'feedback::approve',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::reply' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'feedback/reply/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@reply',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@reply',
        'as' => 'feedback::reply',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::archive' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/archive/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@archive',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@archive',
        'as' => 'feedback::archive',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::restore' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/restore/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@restore',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@restore',
        'as' => 'feedback::restore',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@delete',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@delete',
        'as' => 'feedback::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::vote' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'feedback/vote',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@vote',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@vote',
        'as' => 'feedback::vote',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/feedback',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/{category}/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@index',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@index',
        'as' => 'feedback::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/{category}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/{category}/search/{searchTerm?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@search',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@search',
        'as' => 'feedback::search',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/{category}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::archived' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/{category}/archived',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@archived',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@archived',
        'as' => 'feedback::archived',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/{category}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'feedback/{category}/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@store',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@store',
        'as' => 'feedback::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/{category}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'feedback::archiveall' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'feedback/{category}/archiveall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'member',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\FeedbackController@archiveAll',
        'controller' => 'App\\Http\\Controllers\\FeedbackController@archiveAll',
        'as' => 'feedback::archiveall',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'feedback/{category}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/minisite',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'controller' => 'App\\Http\\Controllers\\OmNomController@miniSite',
        'as' => 'omnomcom::',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::store::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/store/{store?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\OmNomController@display',
        'controller' => 'App\\Http\\Controllers\\OmNomController@display',
        'as' => 'omnomcom::store::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/store',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::store::buy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/store/{store}/buy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\OmNomController@buy',
        'controller' => 'App\\Http\\Controllers\\OmNomController@buy',
        'as' => 'omnomcom::store::buy',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/store',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::store::rfid::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/store/rfid/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\RfidCardController@store',
        'controller' => 'App\\Http\\Controllers\\RfidCardController@store',
        'as' => 'omnomcom::store::rfid::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/store',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders/history/{date?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@index',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@index',
        'as' => 'omnomcom::orders::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::orderline-wizard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders/orderline-wizard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@orderlineWizard',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@orderlineWizard',
        'as' => 'omnomcom::orders::orderline-wizard',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::storebulk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/orders/store/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@bulkStore',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@bulkStore',
        'as' => 'omnomcom::orders::storebulk',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/orders/store/single',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@store',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@store',
        'as' => 'omnomcom::orders::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@destroy',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@destroy',
        'as' => 'omnomcom::orders::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::adminlist' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@adminindex',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@adminindex',
        'as' => 'omnomcom::orders::adminlist',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::filter::name' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders/filter/name/{name?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@filterByUser',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@filterByUser',
        'as' => 'omnomcom::orders::filter::name',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders/filter',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::orders::filter::date' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/orders/filter/date/{date?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@filterByDate',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@filterByDate',
        'as' => 'omnomcom::orders::filter::date',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/orders/filter',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::payments::statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/payments/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\OrderLineController@showPaymentStatistics',
        'controller' => 'App\\Http\\Controllers\\OrderLineController@showPaymentStatistics',
        'as' => 'omnomcom::payments::statistics',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::tipcie::orderhistory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/tipcie',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:tipcie',
        ),
        'uses' => 'App\\Http\\Controllers\\TIPCieController@orderIndex',
        'controller' => 'App\\Http\\Controllers\\TIPCieController@orderIndex',
        'as' => 'omnomcom::tipcie::orderhistory',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/accounts/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@index',
        'controller' => 'App\\Http\\Controllers\\AccountController@index',
        'as' => 'omnomcom::accounts::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/accounts/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@create',
        'controller' => 'App\\Http\\Controllers\\AccountController@create',
        'as' => 'omnomcom::accounts::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/accounts/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@store',
        'controller' => 'App\\Http\\Controllers\\AccountController@store',
        'as' => 'omnomcom::accounts::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::aggregate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/accounts/aggregate/{account}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@showAggregation',
        'controller' => 'App\\Http\\Controllers\\AccountController@showAggregation',
        'as' => 'omnomcom::accounts::aggregate',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/accounts/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@edit',
        'controller' => 'App\\Http\\Controllers\\AccountController@edit',
        'as' => 'omnomcom::accounts::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/accounts/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@update',
        'controller' => 'App\\Http\\Controllers\\AccountController@update',
        'as' => 'omnomcom::accounts::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/accounts/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@destroy',
        'controller' => 'App\\Http\\Controllers\\AccountController@destroy',
        'as' => 'omnomcom::accounts::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::accounts::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/accounts/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@show',
        'controller' => 'App\\Http\\Controllers\\AccountController@show',
        'as' => 'omnomcom::accounts::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\ProductController@index',
        'as' => 'omnomcom::products::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@create',
        'controller' => 'App\\Http\\Controllers\\ProductController@create',
        'as' => 'omnomcom::products::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/products/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@store',
        'controller' => 'App\\Http\\Controllers\\ProductController@store',
        'as' => 'omnomcom::products::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@edit',
        'controller' => 'App\\Http\\Controllers\\ProductController@edit',
        'as' => 'omnomcom::products::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/products/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@update',
        'controller' => 'App\\Http\\Controllers\\ProductController@update',
        'as' => 'omnomcom::products::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProductController@destroy',
        'as' => 'omnomcom::products::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::export_csv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/export/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@generateCsv',
        'controller' => 'App\\Http\\Controllers\\ProductController@generateCsv',
        'as' => 'omnomcom::products::export_csv',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::bulkupdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/products/update/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductController@bulkUpdate',
        'controller' => 'App\\Http\\Controllers\\ProductController@bulkUpdate',
        'as' => 'omnomcom::products::bulkupdate',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\AccountController@showOmnomcomStatistics',
        'controller' => 'App\\Http\\Controllers\\AccountController@showOmnomcomStatistics',
        'as' => 'omnomcom::products::statistics',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::mutations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/mut',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\StockMutationController@index',
        'controller' => 'App\\Http\\Controllers\\StockMutationController@index',
        'as' => 'omnomcom::products::mutations',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::products::mutations_export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/products/mut/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\StockMutationController@generateCsv',
        'controller' => 'App\\Http\\Controllers\\StockMutationController@generateCsv',
        'as' => 'omnomcom::products::mutations_export',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@index',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@index',
        'as' => 'omnomcom::categories::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@create',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@create',
        'as' => 'omnomcom::categories::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/categories/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@store',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@store',
        'as' => 'omnomcom::categories::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/categories/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@update',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@update',
        'as' => 'omnomcom::categories::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/categories/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@destroy',
        'as' => 'omnomcom::categories::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::categories::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/categories/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\ProductCategoryController@show',
        'controller' => 'App\\Http\\Controllers\\ProductCategoryController@show',
        'as' => 'omnomcom::categories::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mywithdrawal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/mywithdrawal/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@showForUser',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@showForUser',
        'as' => 'omnomcom::mywithdrawal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::unwithdrawable' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/unwithdrawable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'as' => 'omnomcom::unwithdrawable',
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@unwithdrawable',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@unwithdrawable',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@index',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@index',
        'as' => 'omnomcom::withdrawal::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@create',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@create',
        'as' => 'omnomcom::withdrawal::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/withdrawals/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@store',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@store',
        'as' => 'omnomcom::withdrawal::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::edit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/withdrawals/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@update',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@update',
        'as' => 'omnomcom::withdrawal::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@destroy',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@destroy',
        'as' => 'omnomcom::withdrawal::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::showAccounts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/accounts/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@showAccounts',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@showAccounts',
        'as' => 'omnomcom::withdrawal::showAccounts',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/export/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@export',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@export',
        'as' => 'omnomcom::withdrawal::export',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::close' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/close/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@close',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@close',
        'as' => 'omnomcom::withdrawal::close',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::email' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/email/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@email',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@email',
        'as' => 'omnomcom::withdrawal::email',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::deleteuser' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/deletefrom/{id}/{user_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@deleteFrom',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@deleteFrom',
        'as' => 'omnomcom::withdrawal::deleteuser',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::markfailed' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/markfailed/{id}/{user_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@markFailed',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@markFailed',
        'as' => 'omnomcom::withdrawal::markfailed',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::markloss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/markloss/{id}/{user_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@markLoss',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@markLoss',
        'as' => 'omnomcom::withdrawal::markloss',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::withdrawal::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/withdrawals/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\WithdrawalController@show',
        'controller' => 'App\\Http\\Controllers\\WithdrawalController@show',
        'as' => 'omnomcom::withdrawal::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/withdrawals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mollie::pay' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'omnomcom/mollie/pay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@pay',
        'controller' => 'App\\Http\\Controllers\\MollieController@pay',
        'as' => 'omnomcom::mollie::pay',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/mollie',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mollie::status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/mollie/status/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@status',
        'controller' => 'App\\Http\\Controllers\\MollieController@status',
        'as' => 'omnomcom::mollie::status',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/mollie',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mollie::receive' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/mollie/receive/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@receive',
        'controller' => 'App\\Http\\Controllers\\MollieController@receive',
        'as' => 'omnomcom::mollie::receive',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/mollie',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mollie::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/mollie/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@index',
        'controller' => 'App\\Http\\Controllers\\MollieController@index',
        'as' => 'omnomcom::mollie::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/mollie',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::mollie::monthly' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/mollie/monthly/{month}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:finadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@monthly',
        'controller' => 'App\\Http\\Controllers\\MollieController@monthly',
        'as' => 'omnomcom::mollie::monthly',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'omnomcom/mollie',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'omnomcom::generateorder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'omnomcom/supplier',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:omnomcom',
        ),
        'uses' => 'App\\Http\\Controllers\\OmNomController@generateOrder',
        'controller' => 'App\\Http\\Controllers\\OmNomController@generateOrder',
        'as' => 'omnomcom::generateorder',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/omnomcom',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'webhook::mollie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'webhook/mollie/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\MollieController@webhook',
        'controller' => 'App\\Http\\Controllers\\MollieController@webhook',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'webhook::mollie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::admin::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'video/admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@index',
        'controller' => 'App\\Http\\Controllers\\VideoController@index',
        'as' => 'video::admin::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'video/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::admin::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'video/admin/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@store',
        'controller' => 'App\\Http\\Controllers\\VideoController@store',
        'as' => 'video::admin::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'video/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::admin::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'video/admin/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@edit',
        'controller' => 'App\\Http\\Controllers\\VideoController@edit',
        'as' => 'video::admin::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'video/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::admin::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'video/admin/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@update',
        'controller' => 'App\\Http\\Controllers\\VideoController@update',
        'as' => 'video::admin::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'video/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::admin::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'video/admin/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@destroy',
        'controller' => 'App\\Http\\Controllers\\VideoController@destroy',
        'as' => 'video::admin::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'video/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'video',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@publicIndex',
        'controller' => 'App\\Http\\Controllers\\VideoController@publicIndex',
        'as' => 'video::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/video',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'video::show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'video/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\VideoController@view',
        'controller' => 'App\\Http\\Controllers\\VideoController@view',
        'as' => 'video::show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/video',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@index',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@index',
        'as' => 'announcement::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/admin/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@create',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@create',
        'as' => 'announcement::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'announcement/admin/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@store',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@store',
        'as' => 'announcement::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/admin/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@edit',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@edit',
        'as' => 'announcement::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'announcement/admin/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@update',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@update',
        'as' => 'announcement::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/admin/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@destroy',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@destroy',
        'as' => 'announcement::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::clear' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/admin/clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@clear',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@clear',
        'as' => 'announcement::clear',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'announcement/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'announcement::dismiss' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'announcement/dismiss/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AnnouncementController@dismiss',
        'controller' => 'App\\Http\\Controllers\\AnnouncementController@dismiss',
        'as' => 'announcement::dismiss',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/announcement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::albums' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@index',
        'controller' => 'App\\Http\\Controllers\\PhotoController@index',
        'as' => 'photo::albums',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::slideshow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/slideshow',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@slideshow',
        'controller' => 'App\\Http\\Controllers\\PhotoController@slideshow',
        'as' => 'photo::slideshow',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::likes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/like/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@likePhoto',
        'controller' => 'App\\Http\\Controllers\\PhotoController@likePhoto',
        'as' => 'photo::likes',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::dislikes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/dislike/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@dislikePhoto',
        'controller' => 'App\\Http\\Controllers\\PhotoController@dislikePhoto',
        'as' => 'photo::dislikes',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/photo/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@photo',
        'controller' => 'App\\Http\\Controllers\\PhotoController@photo',
        'as' => 'photo::view',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::album::list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoController@show',
        'controller' => 'App\\Http\\Controllers\\PhotoController@show',
        'as' => 'photo::album::list',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/photos',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/admin/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@index',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@index',
        'as' => 'photo::admin::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'photos/admin/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@create',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@create',
        'as' => 'photo::admin::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/admin/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@edit',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@edit',
        'as' => 'photo::admin::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'photos/admin/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
          3 => 'permission:publishalbums',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@update',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@update',
        'as' => 'photo::admin::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'photos/admin/edit/{id}/action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@action',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@action',
        'as' => 'photo::admin::action',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'photos/admin/edit/{id}/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@upload',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@upload',
        'as' => 'photo::admin::upload',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/admin/edit/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
          3 => 'permission:publishalbums',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@delete',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@delete',
        'as' => 'photo::admin::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::publish' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/admin/publish/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
          3 => 'permission:publishalbums',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@publish',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@publish',
        'as' => 'photo::admin::publish',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'photo::admin::unpublish' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'photos/admin/unpublish/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'permission:protography',
          3 => 'permission:publishalbums',
        ),
        'uses' => 'App\\Http\\Controllers\\PhotoAdminController@unpublish',
        'controller' => 'App\\Http\\Controllers\\PhotoAdminController@unpublish',
        'as' => 'photo::admin::unpublish',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'photos/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'spotify::oauth' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'spotify/oauth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\SpotifyController@oauthTool',
        'controller' => 'App\\Http\\Controllers\\SpotifyController@oauthTool',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'spotify::oauth',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'authorization::overview' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'authorization',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthorizationController@index',
        'controller' => 'App\\Http\\Controllers\\AuthorizationController@index',
        'as' => 'authorization::overview',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/authorization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'authorization::grant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'authorization/{id}/grant',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthorizationController@grant',
        'controller' => 'App\\Http\\Controllers\\AuthorizationController@grant',
        'as' => 'authorization::grant',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/authorization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'authorization::revoke' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'authorization/{id}/revoke/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AuthorizationController@revoke',
        'controller' => 'App\\Http\\Controllers\\AuthorizationController@revoke',
        'as' => 'authorization::revoke',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/authorization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'passwordstore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@index',
        'controller' => 'App\\Http\\Controllers\\PasswordController@index',
        'as' => 'passwordstore::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::auth' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'passwordstore/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@getAuth',
        'controller' => 'App\\Http\\Controllers\\PasswordController@getAuth',
        'as' => 'passwordstore::auth',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::postAuth' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'passwordstore/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@postAuth',
        'controller' => 'App\\Http\\Controllers\\PasswordController@postAuth',
        'as' => 'passwordstore::postAuth',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'passwordstore/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@create',
        'controller' => 'App\\Http\\Controllers\\PasswordController@create',
        'as' => 'passwordstore::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'passwordstore/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@store',
        'controller' => 'App\\Http\\Controllers\\PasswordController@store',
        'as' => 'passwordstore::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'passwordstore/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@edit',
        'controller' => 'App\\Http\\Controllers\\PasswordController@edit',
        'as' => 'passwordstore::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'passwordstore/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@update',
        'controller' => 'App\\Http\\Controllers\\PasswordController@update',
        'as' => 'passwordstore::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'passwordstore::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'passwordstore/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PasswordController@destroy',
        'controller' => 'App\\Http\\Controllers\\PasswordController@destroy',
        'as' => 'passwordstore::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/passwordstore',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alias::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'alias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AliasController@index',
        'controller' => 'App\\Http\\Controllers\\AliasController@index',
        'as' => 'alias::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/alias',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alias::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'alias/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AliasController@create',
        'controller' => 'App\\Http\\Controllers\\AliasController@create',
        'as' => 'alias::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/alias',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alias::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'alias/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AliasController@store',
        'controller' => 'App\\Http\\Controllers\\AliasController@store',
        'as' => 'alias::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/alias',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alias::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'alias/delete/{id_or_alias}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AliasController@destroy',
        'controller' => 'App\\Http\\Controllers\\AliasController@destroy',
        'as' => 'alias::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/alias',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alias::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'alias/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\AliasController@update',
        'controller' => 'App\\Http\\Controllers\\AliasController@update',
        'as' => 'alias::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/alias',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'smartxp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'smartxp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@show',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'smartxp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'protopolis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'protopolis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@showProtopolis',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@showProtopolis',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'protopolis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ItmaNZqvnMZm2yOf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'caniworkinthesmartxp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'controller' => 'App\\Http\\Controllers\\SmartXpScreenController@canWork',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ItmaNZqvnMZm2yOf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'protube::dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'protube/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProtubeController@dashboard',
        'controller' => 'App\\Http\\Controllers\\ProtubeController@dashboard',
        'as' => 'protube::dashboard',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'protube::togglehistory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'protube/togglehistory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProtubeController@toggleHistory',
        'controller' => 'App\\Http\\Controllers\\ProtubeController@toggleHistory',
        'as' => 'protube::togglehistory',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'protube::clearhistory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'protube/clearhistory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProtubeController@clearHistory',
        'controller' => 'App\\Http\\Controllers\\ProtubeController@clearHistory',
        'as' => 'protube::clearhistory',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'protube::top' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'protube/top',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\ProtubeController@topVideos',
        'controller' => 'App\\Http\\Controllers\\ProtubeController@topVideos',
        'as' => 'protube::top',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/protube',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ical::calendar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ical/calendar/{personal_key?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\EventController@icalCalendar',
        'controller' => 'App\\Http\\Controllers\\EventController@icalCalendar',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ical::calendar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achieve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achieve/{achievement}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@achieve',
        'controller' => 'App\\Http\\Controllers\\AchievementController@achieve',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'achieve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@index',
        'controller' => 'App\\Http\\Controllers\\AchievementController@index',
        'as' => 'achievement::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@create',
        'controller' => 'App\\Http\\Controllers\\AchievementController@create',
        'as' => 'achievement::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'achievement/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@store',
        'controller' => 'App\\Http\\Controllers\\AchievementController@store',
        'as' => 'achievement::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@edit',
        'controller' => 'App\\Http\\Controllers\\AchievementController@edit',
        'as' => 'achievement::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'achievement/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@update',
        'controller' => 'App\\Http\\Controllers\\AchievementController@update',
        'as' => 'achievement::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@destroy',
        'controller' => 'App\\Http\\Controllers\\AchievementController@destroy',
        'as' => 'achievement::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::award' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'achievement/award/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@award',
        'controller' => 'App\\Http\\Controllers\\AchievementController@award',
        'as' => 'achievement::award',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::give' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'achievement/give',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@give',
        'controller' => 'App\\Http\\Controllers\\AchievementController@give',
        'as' => 'achievement::give',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::take' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/take/{id}/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@take',
        'controller' => 'App\\Http\\Controllers\\AchievementController@take',
        'as' => 'achievement::take',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::takeAll' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/takeAll/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@takeAll',
        'controller' => 'App\\Http\\Controllers\\AchievementController@takeAll',
        'as' => 'achievement::takeAll',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::icon' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'achievement/{id}/icon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@icon',
        'controller' => 'App\\Http\\Controllers\\AchievementController@icon',
        'as' => 'achievement::icon',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'achievement::gallery' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'achievement/gallery',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\AchievementController@gallery',
        'controller' => 'App\\Http\\Controllers\\AchievementController@gallery',
        'as' => 'achievement::gallery',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/achievement',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welcomeMessages::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welcomeMessages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\WelcomeController@overview',
        'controller' => 'App\\Http\\Controllers\\WelcomeController@overview',
        'as' => 'welcomeMessages::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/welcomeMessages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welcomeMessages::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welcomeMessages/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\WelcomeController@store',
        'controller' => 'App\\Http\\Controllers\\WelcomeController@store',
        'as' => 'welcomeMessages::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/welcomeMessages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welcomeMessages::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welcomeMessages/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\WelcomeController@destroy',
        'controller' => 'App\\Http\\Controllers\\WelcomeController@destroy',
        'as' => 'welcomeMessages::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/welcomeMessages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::make' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin/make/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@make',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@make',
        'as' => 'tempadmin::make',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::end' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin/end/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@end',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@end',
        'as' => 'tempadmin::end',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::endId' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin/endId/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@endId',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@endId',
        'as' => 'tempadmin::endId',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@edit',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@edit',
        'as' => 'tempadmin::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tempadmin/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@update',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@update',
        'as' => 'tempadmin::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@create',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@create',
        'as' => 'tempadmin::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tempadmin/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@store',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@store',
        'as' => 'tempadmin::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tempadmin::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tempadmin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\TempAdminController@index',
        'controller' => 'App\\Http\\Controllers\\TempAdminController@index',
        'as' => 'tempadmin::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/tempadmin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr::code' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr/code/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\QrAuthController@showCode',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@showCode',
        'as' => 'qr::code',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/qr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr::generate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'qr/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\QrAuthController@generateRequest',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@generateRequest',
        'as' => 'qr::generate',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/qr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr::approved' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr/isApproved',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\QrAuthController@isApproved',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@isApproved',
        'as' => 'qr::approved',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/qr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr::dialog' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrAuthController@showDialog',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@showDialog',
        'as' => 'qr::dialog',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/qr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr::approve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr/{code}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrAuthController@approve',
        'controller' => 'App\\Http\\Controllers\\QrAuthController@approve',
        'as' => 'qr::approve',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/qr',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'short_url::go' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'go/{short?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\ShortUrlController@go',
        'controller' => 'App\\Http\\Controllers\\ShortUrlController@go',
        'as' => 'short_url::go',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'short_url::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'short_url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ShortUrlController@index',
        'controller' => 'App\\Http\\Controllers\\ShortUrlController@index',
        'as' => 'short_url::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/short_url',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'short_url::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'short_url/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ShortUrlController@edit',
        'controller' => 'App\\Http\\Controllers\\ShortUrlController@edit',
        'as' => 'short_url::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/short_url',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'short_url::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'short_url/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ShortUrlController@update',
        'controller' => 'App\\Http\\Controllers\\ShortUrlController@update',
        'as' => 'short_url::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/short_url',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'short_url::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'short_url/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\ShortUrlController@destroy',
        'controller' => 'App\\Http\\Controllers\\ShortUrlController@destroy',
        'as' => 'short_url::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/short_url',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@index',
        'controller' => 'App\\Http\\Controllers\\DmxController@index',
        'as' => 'dmx::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@create',
        'controller' => 'App\\Http\\Controllers\\DmxController@create',
        'as' => 'dmx::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dmx/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@store',
        'controller' => 'App\\Http\\Controllers\\DmxController@store',
        'as' => 'dmx::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@edit',
        'controller' => 'App\\Http\\Controllers\\DmxController@edit',
        'as' => 'dmx::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dmx/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@update',
        'controller' => 'App\\Http\\Controllers\\DmxController@update',
        'as' => 'dmx::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@delete',
        'controller' => 'App\\Http\\Controllers\\DmxController@delete',
        'as' => 'dmx::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/dmx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/override',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideIndex',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideIndex',
        'as' => 'dmx::override::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/override/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideCreate',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideCreate',
        'as' => 'dmx::override::create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dmx/override/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideStore',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideStore',
        'as' => 'dmx::override::store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/override/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideEdit',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideEdit',
        'as' => 'dmx::override::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dmx/override/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideUpdate',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideUpdate',
        'as' => 'dmx::override::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dmx::override::delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dmx/override/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\DmxController@overrideDelete',
        'controller' => 'App\\Http\\Controllers\\DmxController@overrideDelete',
        'as' => 'dmx::override::delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'dmx/override',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'queries::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'queries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\QueryController@index',
        'controller' => 'App\\Http\\Controllers\\QueryController@index',
        'as' => 'queries::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/queries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'queries::activity_overview' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'queries/activity_overview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\QueryController@activityOverview',
        'controller' => 'App\\Http\\Controllers\\QueryController@activityOverview',
        'as' => 'queries::activity_overview',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/queries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'queries::activity_statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'queries/activity_statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\QueryController@activityStatistics',
        'controller' => 'App\\Http\\Controllers\\QueryController@activityStatistics',
        'as' => 'queries::activity_statistics',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/queries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'queries::membership_totals' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'queries/membership_totals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:board',
        ),
        'uses' => 'App\\Http\\Controllers\\QueryController@membershipTotals',
        'controller' => 'App\\Http\\Controllers\\QueryController@membershipTotals',
        'as' => 'queries::membership_totals',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/queries',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'minisites::isalfredthere::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'minisites/isalfredthere',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@index',
        'as' => 'minisites::isalfredthere::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'minisites/isalfredthere',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'minisites::isalfredthere::edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'minisites/isalfredthere/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@edit',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@edit',
        'as' => 'minisites::isalfredthere::edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'minisites/isalfredthere',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'minisites::isalfredthere::update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'minisites/isalfredthere/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:sysadmin|alfred',
        ),
        'uses' => 'App\\Http\\Controllers\\IsAlfredThereController@update',
        'controller' => 'App\\Http\\Controllers\\IsAlfredThereController@update',
        'as' => 'minisites::isalfredthere::update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'minisites/isalfredthere',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@index',
        'controller' => 'App\\Http\\Controllers\\CodexController@index',
        'as' => 'codex::index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::create-codex' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/create-codex',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@addCodex',
        'controller' => 'App\\Http\\Controllers\\CodexController@addCodex',
        'as' => 'codex::create-codex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::create-song' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/create-song',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@addSong',
        'controller' => 'App\\Http\\Controllers\\CodexController@addSong',
        'as' => 'codex::create-song',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::create-song-category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/create-song-category',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@addSongCategory',
        'controller' => 'App\\Http\\Controllers\\CodexController@addSongCategory',
        'as' => 'codex::create-song-category',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::create-text-type' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/create-text-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@addTextType',
        'controller' => 'App\\Http\\Controllers\\CodexController@addTextType',
        'as' => 'codex::create-text-type',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::create-text' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/create-text',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@addText',
        'controller' => 'App\\Http\\Controllers\\CodexController@addText',
        'as' => 'codex::create-text',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::edit-codex' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/edit-codex/{codex}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@editCodex',
        'controller' => 'App\\Http\\Controllers\\CodexController@editCodex',
        'as' => 'codex::edit-codex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::edit-song' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/edit-song/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@editSong',
        'controller' => 'App\\Http\\Controllers\\CodexController@editSong',
        'as' => 'codex::edit-song',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::edit-song-category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/edit-song-category/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@editSongCategory',
        'controller' => 'App\\Http\\Controllers\\CodexController@editSongCategory',
        'as' => 'codex::edit-song-category',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::edit-text-type' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/edit-text-type/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@editTextType',
        'controller' => 'App\\Http\\Controllers\\CodexController@editTextType',
        'as' => 'codex::edit-text-type',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::edit-text' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/edit-text/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@editText',
        'controller' => 'App\\Http\\Controllers\\CodexController@editText',
        'as' => 'codex::edit-text',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::delete-codex' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/delete-codex/{codex}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@deleteCodex',
        'controller' => 'App\\Http\\Controllers\\CodexController@deleteCodex',
        'as' => 'codex::delete-codex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::delete-song' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/delete-song/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@deleteSong',
        'controller' => 'App\\Http\\Controllers\\CodexController@deleteSong',
        'as' => 'codex::delete-song',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::delete-song-category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/delete-song-category/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@deleteSongCategory',
        'controller' => 'App\\Http\\Controllers\\CodexController@deleteSongCategory',
        'as' => 'codex::delete-song-category',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::delete-text-type' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/delete-text-type/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@deleteTextType',
        'controller' => 'App\\Http\\Controllers\\CodexController@deleteTextType',
        'as' => 'codex::delete-text-type',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::delete-text' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/delete-text/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@deleteText',
        'controller' => 'App\\Http\\Controllers\\CodexController@deleteText',
        'as' => 'codex::delete-text',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::store-codex' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/store-codex',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@storeSong',
        'controller' => 'App\\Http\\Controllers\\CodexController@storeSong',
        'as' => 'codex::store-codex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::store-codex-category' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/store-codex-category',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@storeSongCategory',
        'controller' => 'App\\Http\\Controllers\\CodexController@storeSongCategory',
        'as' => 'codex::store-codex-category',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::store-text-type' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/store-text-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@storeTextType',
        'controller' => 'App\\Http\\Controllers\\CodexController@storeTextType',
        'as' => 'codex::store-text-type',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::store-text' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/store-text',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@storeText',
        'controller' => 'App\\Http\\Controllers\\CodexController@storeText',
        'as' => 'codex::store-text',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::update-codex' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/update-codex/{codex}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@updateCodex',
        'controller' => 'App\\Http\\Controllers\\CodexController@updateCodex',
        'as' => 'codex::update-codex',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::update-song' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/update-song/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@updateSong',
        'controller' => 'App\\Http\\Controllers\\CodexController@updateSong',
        'as' => 'codex::update-song',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::update-song-category' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/update-song-category/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@updateSongCategory',
        'controller' => 'App\\Http\\Controllers\\CodexController@updateSongCategory',
        'as' => 'codex::update-song-category',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::update-text-type' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/update-text-type/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@updateTextType',
        'controller' => 'App\\Http\\Controllers\\CodexController@updateTextType',
        'as' => 'codex::update-text-type',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::update-text' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'codex/update-text/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@updateText',
        'controller' => 'App\\Http\\Controllers\\CodexController@updateText',
        'as' => 'codex::update-text',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'codex::export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'codex/export/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
          2 => 'auth',
          3 => 'permission:senate',
        ),
        'uses' => 'App\\Http\\Controllers\\CodexController@exportCodex',
        'controller' => 'App\\Http\\Controllers\\CodexController@exportCodex',
        'as' => 'codex::export',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/codex',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'december::toggle' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'december/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'forcedomain',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:260:"function () {
        \\Illuminate\\Support\\Facades\\Cookie::queue(\'disable-december\', \\Illuminate\\Support\\Facades\\Cookie::get(\'disable-december\') === \'disabled\' ? \'enabled\' : \'disabled\', 43800);

        return \\Illuminate\\Support\\Facades\\Redirect::back();
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000d290000000000000000";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'december::toggle',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
