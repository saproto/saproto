<?php return array (
  8 => 'concurrency',
  'api-postcode' => 
  array (
    'token' => '',
  ),
  'app' => 
  array (
    'name' => 'S.A. Proto',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8080',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'Europe/Amsterdam',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:6kXOP2sQngESDqeS+XWMUn80UoXSQkU19XwMPW9LqgU=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      12 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      13 => 'Illuminate\\Queue\\QueueServiceProvider',
      14 => 'Illuminate\\Redis\\RedisServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Session\\SessionServiceProvider',
      17 => 'Illuminate\\Translation\\TranslationServiceProvider',
      18 => 'Illuminate\\Validation\\ValidationServiceProvider',
      19 => 'Illuminate\\View\\ViewServiceProvider',
      20 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      21 => 'App\\Providers\\AppServiceProvider',
      22 => 'App\\Providers\\EventServiceProvider',
      23 => 'App\\Providers\\RouteServiceProvider',
      24 => 'Illuminate\\Mail\\MailServiceProvider',
      25 => 'PragmaRX\\Google2FA\\Vendor\\Laravel\\ServiceProvider',
      26 => 'Biscolab\\ReCaptcha\\ReCaptchaServiceProvider',
      27 => 'Milon\\Barcode\\BarcodeServiceProvider',
      28 => 'GrahamCampbell\\Markdown\\MarkdownServiceProvider',
      29 => 'Vinkla\\Hashids\\HashidsServiceProvider',
      30 => 'nickurt\\PwnedPasswords\\ServiceProvider',
      31 => 'Aacotroneo\\Saml2\\Saml2ServiceProvider',
      32 => 'Sentry\\Laravel\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Input' => 'Illuminate\\Support\\Facades\\Request',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Role' => 'Spatie\\Permission\\Models\\Role',
      'Permission' => 'Spatie\\Permission\\Models\\Permission',
      'Image' => 'Image',
      'PDF' => 'Spipu\\Html2Pdf\\Html2Pdf',
      'DNS1D' => 'Milon\\Barcode\\Facades\\DNS1DFacade',
      'DNS2D' => 'Milon\\Barcode\\Facades\\DNS2DFacade',
      'Carbon' => 'Carbon\\Carbon',
      'Markdown' => 'GrahamCampbell\\Markdown\\Facades\\Markdown',
      'ReCaptcha' => 'Biscolab\\ReCaptcha\\Facades\\ReCaptcha',
      'Mollie' => 'Mollie\\Laravel\\Facades\\Mollie',
      'Hashids' => 'Vinkla\\Hashids\\Facades\\Hashids',
      'PwnedPasswords' => 'nickurt\\PwnedPasswords\\Facade',
    ),
    'ssl' => false,
    'forcedomain' => NULL,
  ),
  'app-proto' => 
  array (
    'primary-domain' => 'http://localhost:8080',
    'app-url' => 'http://localhost:8080',
    'assets-domain' => 'http://localhost:8080',
    'fishcam-url' => 'https://fish.cam',
    'debug-whitelist' => NULL,
    'personal-proto-key' => 'personal_proto_key',
    'printer-host' => 'printer.proto.utwente.nl',
    'printer-port' => '12345',
    'printer-secret' => 'SomeKey',
    'google-key-public' => 'API_KEY',
    'google-key-private' => 'API_KEY',
    'spotify-clientkey' => 'SpotifyKey',
    'spotify-secretkey' => 'SpotifySecret',
    'spotify-user' => 'studyassociationproto',
    'spotify-alltime-playlist' => 'AllTimePlayListId',
    'spotify-pastyears-playlist' => 'PastYearsPlaylistId',
    'spotify-recent-playlist' => 'RecentPlayListId',
    'sentry-dsn' => NULL,
    'proboto-secret' => 'EVEN_BIGGER_SECRET',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'passport',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'barcode' => 
  array (
    'store_path' => '/var/www/html/public/',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/var/www/html/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => NULL,
        'secret' => NULL,
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'oauth/token',
      1 => 'oauth/token/*',
      2 => 'api/*',
      3 => 'image/*',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'csp' => 
  array (
    'policy' => 'App\\Csp\\Policies\\ProtoPolicy',
    'report_only_policy' => '',
    'report_uri' => '',
    'enabled' => true,
    'nonce_generator' => 'App\\Support\\LaravelViteNonceGenerator',
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'saproto',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => 'host.docker.internal',
        'port' => '3306',
        'database' => 'saproto',
        'username' => 'saproto',
        'password' => 'saproto',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => 'host.docker.internal',
        'port' => '3306',
        'database' => 'saproto',
        'username' => 'saproto',
        'password' => 'saproto',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'host.docker.internal',
        'port' => '3306',
        'database' => 'saproto',
        'username' => 'saproto',
        'password' => 'saproto',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'host.docker.internal',
        'port' => '3306',
        'database' => 'saproto',
        'username' => 'saproto',
        'password' => 'saproto',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'directadmin' => 
  array (
    'da-password' => NULL,
    'da-username' => NULL,
    'da-hostname' => NULL,
    'da-port' => NULL,
    'da-domain' => NULL,
  ),
  'dmx' => 
  array (
    'lecture_types' => 
    array (
      0 => 'Lecture',
      1 => 'Exam',
    ),
    'colors' => 
    array (
      'lecture' => 
      array (
        0 => 255,
        1 => 40,
        2 => 0,
      ),
      'tutorial' => 
      array (
        0 => 100,
        1 => 0,
        2 => 255,
      ),
      'free' => 
      array (
        0 => 0,
        1 => 255,
        2 => 0,
      ),
    ),
  ),
  'feeds' => 
  array (
    'cache.location' => '/var/www/html/storage/framework/cache',
    'cache.life' => 3600,
    'ssl_check.disabled' => false,
    'cache.disabled' => false,
    'strip_html_tags.disabled' => false,
    'strip_html_tags.tags' => 
    array (
      0 => 'base',
      1 => 'blink',
      2 => 'body',
      3 => 'doctype',
      4 => 'embed',
      5 => 'font',
      6 => 'form',
      7 => 'frame',
      8 => 'frameset',
      9 => 'html',
      10 => 'iframe',
      11 => 'input',
      12 => 'marquee',
      13 => 'meta',
      14 => 'noscript',
      15 => 'object',
      16 => 'param',
      17 => 'script',
      18 => 'style',
    ),
    'strip_attribute.disabled' => false,
    'strip_attributes.tags' => 
    array (
      0 => 'bgsound',
      1 => 'class',
      2 => 'expr',
      3 => 'id',
      4 => 'style',
      5 => 'onclick',
      6 => 'onerror',
      7 => 'onfinish',
      8 => 'onmouseover',
      9 => 'onmouseout',
      10 => 'onfocus',
      11 => 'onblur',
      12 => 'lowsrc',
      13 => 'dynsrc',
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/html/storage/app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/html/storage/app/public',
        'url' => 'http://localhost:8080/storage',
        'visibility' => 'public',
        'throw' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
      ),
    ),
    'links' => 
    array (
      '/var/www/html/public/storage' => '/var/www/html/storage/app/public',
    ),
  ),
  'hashids' => 
  array (
    'default' => 'users',
    'connections' => 
    array (
      'event' => 
      array (
        'salt' => 'RAND_STRING',
        'length' => 16,
      ),
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
    'rehash_on_login' => true,
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'models_filename' => '_ide_helper_models.php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_external_builder_methods' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/var/www/html/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'model_hooks' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
      'Log' => 
      array (
        'debug' => 'Monolog\\Logger::addDebug',
        'info' => 'Monolog\\Logger::addInfo',
        'notice' => 'Monolog\\Logger::addNotice',
        'warning' => 'Monolog\\Logger::addWarning',
        'error' => 'Monolog\\Logger::addError',
        'critical' => 'Monolog\\Logger::addCritical',
        'alert' => 'Monolog\\Logger::addAlert',
        'emergency' => 'Monolog\\Logger::addEmergency',
      ),
    ),
    'interfaces' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
    'force_fqn' => false,
    'use_generics_annotations' => true,
    'additional_relation_types' => 
    array (
    ),
    'additional_relation_return_types' => 
    array (
    ),
    'post_migrate' => 
    array (
    ),
    'format' => 'php',
    'custom_db_types' => 
    array (
    ),
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'imagecache' => 
  array (
    'route' => NULL,
    'paths' => 
    array (
    ),
    'templates' => 
    array (
      'small' => 'Intervention\\Image\\Templates\\Small',
      'medium' => 'Intervention\\Image\\Templates\\Medium',
      'large' => 'Intervention\\Image\\Templates\\Large',
    ),
    'lifetime' => 43200,
  ),
  'ldap' => 
  array (
    'proxy' => 
    array (
      'utwente' => 
      array (
        'url' => 'https://path.to/proxy',
        'key' => 'VERY_SECRET_KEY',
      ),
    ),
  ),
  'logging' => 
  array (
    'default' => 'daily',
    'deprecations' => 
    array (
      'channel' => 'null',
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/var/www/html/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/var/www/html/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 7,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/var/www/html/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'log',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => 2525,
        'encryption' => 'tls',
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'haveyoutriedturningitoffandonagain@proto.utwente.nl',
      'name' => 'S.A. Proto Have You Tried Turning It Off And On Again committee',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/var/www/html/resources/views/vendor/mail',
      ),
    ),
    'driver' => 'smtp',
    'host' => 'mailpit',
    'port' => '1025',
    'encryption' => false,
    'username' => NULL,
    'password' => NULL,
  ),
  'markdown' => 
  array (
    'views' => true,
    'extensions' => 
    array (
      0 => 'League\\CommonMark\\Extension\\CommonMark\\CommonMarkCoreExtension',
      1 => 'League\\CommonMark\\Extension\\Table\\TableExtension',
    ),
    'renderer' => 
    array (
      'block_separator' => '
',
      'inner_separator' => '
',
      'soft_break' => '<br/>',
    ),
    'commonmark' => 
    array (
      'enable_em' => true,
      'enable_strong' => true,
      'use_asterisk' => true,
      'use_underscore' => true,
      'unordered_list_markers' => 
      array (
        0 => '-',
        1 => '+',
        2 => '*',
      ),
    ),
    'html_input' => 'allow',
    'allow_unsafe_links' => true,
    'max_nesting_level' => 9223372036854775807,
    'slug_normalizer' => 
    array (
      'max_length' => 255,
      'unique' => 'document',
    ),
  ),
  'omnomcom' => 
  array (
    'stores' => 
    array (
      'protopolis' => 
      (object) array(
         'name' => 'Protopolis',
         'categories' => 
        array (
          0 => 12,
          1 => 1,
          2 => 4,
          3 => 5,
          4 => 6,
          5 => 22,
          6 => 24,
          7 => 7,
          8 => 9,
          9 => 11,
          10 => 26,
        ),
         'addresses' => 
        array (
          0 => '130.89.190.22',
          1 => '130.89.190.235',
          2 => '2001:67c:2564:318:baae:edff:fe79:9aa3',
        ),
         'roles' => 
        array (
          0 => 'board',
          1 => 'omnomcom',
        ),
         'cash_allowed' => false,
         'bank_card_allowed' => false,
         'alcohol_time_constraint' => true,
      ),
      'tipcie' => 
      (object) array(
         'name' => 'TIPCie',
         'categories' => 
        array (
          0 => 15,
          1 => 18,
          2 => 25,
        ),
         'addresses' => 
        array (
        ),
         'roles' => 
        array (
          0 => 'board',
          1 => 'tipcie',
          2 => 'drafters',
        ),
         'cash_allowed' => false,
         'bank_card_allowed' => true,
         'col_override' => 3,
         'alcohol_time_constraint' => false,
      ),
    ),
    'cookiemonsters' => 
    array (
      0 => 
      (object) array(
         'name' => 'valentine',
         'start' => 'February 14',
         'end' => 'February 15',
      ),
      1 => 
      (object) array(
         'name' => 'stpatrick',
         'start' => 'March 10',
         'end' => 'March 18',
      ),
      2 => 
      (object) array(
         'name' => 'easter',
         'start' => 'Mar-31-2024',
         'end' => 'Mar-31-2024 +1 day',
      ),
      3 => 
      (object) array(
         'name' => 'dies',
         'start' => 'April 1',
         'end' => 'April 21',
      ),
      4 => 
      (object) array(
         'name' => 'may4th',
         'start' => 'May 4',
         'end' => 'May 5',
      ),
      5 => 
      (object) array(
         'name' => 'talklikeapirate',
         'start' => 'September 19',
         'end' => 'September 20',
      ),
      6 => 
      (object) array(
         'name' => 'oktoberfest',
         'start' => 'September 22',
         'end' => 'October 3',
      ),
      7 => 
      (object) array(
         'name' => 'halloween',
         'start' => 'October 24',
         'end' => 'November 1',
      ),
      8 => 
      (object) array(
         'name' => 'sinterklaas',
         'start' => 'November 25',
         'end' => 'December 6',
      ),
      9 => 
      (object) array(
         'name' => 'autumn',
         'start' => 'September 23',
         'end' => 'December 22',
      ),
      10 => 
      (object) array(
         'name' => 'christmas',
         'start' => 'December 6',
         'end' => 'December 31',
      ),
    ),
    'alfred-account' => 43,
    'omnomcom-account' => 1,
    'tipcie-account' => 4,
    'mollie' => 
    array (
      'fee_id' => 887,
      'free_methods' => 
      array (
        0 => 'creditcard',
      ),
      'use_fees' => false,
      'has_webhook' => false,
    ),
    'fee' => 
    array (
      'regular' => 292,
      'reduced' => 293,
      'remitted' => 889,
    ),
    'protube-skip' => 40,
    'alcohol-start' => '14:00',
    'alcohol-end' => '08:00',
    'failed-withdrawal' => 1055,
    'dinnerform-product' => 1404,
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'permission_role',
    ),
    'column_names' => 
    array (
      'model_morph_key' => 'model_id',
    ),
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'teams' => false,
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => 
    array (
      'expiration_time' => 
      \DateInterval::__set_state(array(
         'from_string' => true,
         'date_string' => '24 hours',
      )),
      'key' => 'spatie.permission.cache',
      'model_key' => 'name',
      'store' => 'default',
    ),
    'permissions' => 
    array (
      'sysadmin' => 
      (object) array(
         'display_name' => 'System Admin',
         'description' => 'Gives admin access to the application.',
      ),
      'board' => 
      (object) array(
         'display_name' => 'Board Access',
         'description' => 'Gives access to the association administration.',
      ),
      'protube' => 
      (object) array(
         'display_name' => 'Protube Admin',
         'description' => 'Gives Protube admin access.',
      ),
      'omnomcom' => 
      (object) array(
         'display_name' => 'OmNomCom Access',
         'description' => 'Gives access to the OmNomCom administration.',
      ),
      'finadmin' => 
      (object) array(
         'display_name' => 'Financial Admin',
         'description' => 'Gives access to the financial administration.',
      ),
      'tipcie' => 
      (object) array(
         'display_name' => 'TIPCie Access',
         'description' => 'Gives access to the TIPCie tools.',
      ),
      'drafters' => 
      (object) array(
         'display_name' => 'Guild of Drafters Access',
         'description' => 'Gives access to the relevant tools for drafters.',
      ),
      'alfred' => 
      (object) array(
         'display_name' => 'Alfred\'s Workshop',
         'description' => 'Manages OmNomCom for workshop functionality.',
      ),
      'header-image' => 
      (object) array(
         'display_name' => 'Update Header Image',
         'description' => 'Allows updating the site\'s header images.',
      ),
      'protography' => 
      (object) array(
         'display_name' => 'Photo Access',
         'description' => 'Allows managing photos and albums.',
      ),
      'publishalbums' => 
      (object) array(
         'display_name' => 'Publish Albums',
         'description' => 'Allows publishing photo albums.',
      ),
      'registermembers' => 
      (object) array(
         'display_name' => 'Register Members',
         'description' => 'Allows finalisation of memberships.',
      ),
      'senate' => 
      (object) array(
         'display_name' => 'Codex Access',
         'description' => 'Allows managing of codices.',
      ),
      'closeactivities' => 
      (object) array(
         'display_name' => 'Activity Closer',
         'description' => 'Allows closing of activities.',
      ),
    ),
    'roles' => 
    array (
      'sysadmin' => 
      (object) array(
         'display_name' => 'System Administrator',
         'description' => 'Can access all website functionality',
         'permissions' => '*',
      ),
      'admin' => 
      (object) array(
         'display_name' => 'Application Administrator',
         'description' => 'Can administrate the website',
         'permissions' => 
        array (
          0 => 'board',
          1 => 'omnomcom',
          2 => 'finadmin',
          3 => 'tipcie',
          4 => 'protube',
          5 => 'drafters',
          6 => 'header-image',
          7 => 'protography',
          8 => 'publishalbums',
          9 => 'registermembers',
          10 => 'closeactivities',
        ),
      ),
      'protube' => 
      (object) array(
         'display_name' => 'Protube Administrator',
         'description' => 'Can access Protube admin interface',
         'permissions' => 'protube',
      ),
      'board' => 
      (object) array(
         'display_name' => 'Association Board',
         'description' => 'Can administrate the website',
         'permissions' => 
        array (
          0 => 'board',
          1 => 'omnomcom',
          2 => 'tipcie',
          3 => 'protube',
          4 => 'drafters',
          5 => 'registermembers',
        ),
      ),
      'omnomcom' => 
      (object) array(
         'display_name' => 'OmNomCom',
         'description' => 'Can manage the OmNomCom store',
         'permissions' => 
        array (
          0 => 'omnomcom',
        ),
      ),
      'finadmin' => 
      (object) array(
         'display_name' => 'Financial Administrator',
         'description' => 'Can manage all financials',
         'permissions' => 
        array (
          0 => 'finadmin',
          1 => 'closeactivities',
        ),
      ),
      'tipcie' => 
      (object) array(
         'display_name' => 'TipCie',
         'description' => 'Can manage the TipCie store',
         'permissions' => 
        array (
          0 => 'tipcie',
          1 => 'drafters',
          2 => 'omnomcom',
        ),
      ),
      'drafters' => 
      (object) array(
         'display_name' => 'Guild of Drafters',
         'description' => 'Can access the TipCie store',
         'permissions' => 'drafters',
      ),
      'alfred' => 
      (object) array(
         'display_name' => 'Alfred',
         'description' => 'This person is Alfred',
         'permissions' => 
        array (
          0 => 'alfred',
          1 => 'omnomcom',
        ),
      ),
      'protography-admin' => 
      (object) array(
         'display_name' => 'Protography Administrator',
         'description' => 'Can manage photos and albums',
         'permissions' => 
        array (
          0 => 'header-image',
          1 => 'protography',
          2 => 'publishalbums',
        ),
      ),
      'protography' => 
      (object) array(
         'display_name' => 'Protography',
         'description' => 'Can upload photos',
         'permissions' => 'protography',
      ),
      'registration-helper' => 
      (object) array(
         'display_name' => 'Registration Helper',
         'description' => 'Can help register members',
         'permissions' => 
        array (
          0 => 'registermembers',
        ),
      ),
      'senate' => 
      (object) array(
         'display_name' => 'Senate',
         'description' => 'May view and edit codexes',
         'permissions' => 
        array (
          0 => 'senate',
        ),
      ),
      'activity-closer' => 
      (object) array(
         'display_name' => 'Activity Closer',
         'description' => 'May close activities',
         'permissions' => 
        array (
          0 => 'closeactivities',
        ),
      ),
    ),
  ),
  'proto' => 
  array (
    'rootcommittee' => 'haveyoutriedturningitoffandonagain',
    'rootrole' => 12,
    'emaildomain' => 'proto.utwente.nl',
    'additional_mailboxes' => 
    array (
      0 => 'boardarchive',
    ),
    'tfaroles' => 
    array (
      0 => 'sysadmin',
      1 => 'admin',
      2 => 'board',
      3 => 'finadmin',
      4 => 'omnomcom',
      5 => 'tipcie',
    ),
    'committee' => 
    array (
      'board' => 2108,
      'omnomcom' => 26,
      'tipcie' => 3583,
      'drafters' => 3336,
      'ero' => 1364,
      'protography' => 294,
    ),
    'printproduct' => 17,
    'weeklynewsletter' => 1,
    'autoSubscribeUser' => 
    array (
    ),
    'autoSubscribeMember' => 
    array (
      0 => 8,
      1 => 12,
    ),
    'discord_server_id' => '600338792766767289',
    'discord_client_id' => 'oauth_client_id',
    'discord_secret' => 'BIG_SECRET',
    'fontawesome_kit' => 'KIT_URL',
    'google-calendar' => 
    array (
      'timetable-id' => 'timetable_id@import.calendar.google.com',
      'smartxp-id' => 'smartxp_id@import.calendar.google.com',
      'protopeners-id' => 'protopeners_id@import.calendar.google.com',
    ),
    'internal' => 'Jona Patig',
    'treasurer' => 'Badr Boubric',
    'secretary' => 'Bart van Dorst',
    'boardnumber' => '14.0',
    'mainstudy' => 1,
    'maxtickets' => 10,
    'domains' => 
    array (
      'protube' => 
      array (
        0 => 'protu.be',
        1 => 'www.protu.be',
        2 => 'protube.nl',
        3 => 'www.protube.nl',
      ),
      'omnomcom' => 
      array (
        0 => 'omnomcom.nl',
        1 => 'www.omnomcom.nl',
      ),
      'smartxp' => 
      array (
        0 => 'smartxp.nl',
        1 => 'www.smartxp.nl',
        2 => 'caniworkinthesmartxp.nl',
        3 => 'www.caniworkinthesmartxp.nl',
      ),
      'developers' => 
      array (
        0 => 'haveyoutriedturningitoffandonagain.nl',
        1 => 'www.haveyoutriedturningitoffandonagain.nl',
      ),
      'isalfredthere' => 
      array (
        0 => 'isalfredthere.nl',
        1 => 'www.isalfredthere.nl',
      ),
      'static' => 
      array (
        0 => '',
      ),
    ),
    'soundboardSounds' => 
    array (
      1337 => 9,
      'new-member' => 60,
    ),
    'sepa_info' => 
    (object) array(
       'iban' => 'IBAN',
       'bic' => 'BIC',
       'creditor_id' => 'CREDITOR_ID',
    ),
    'themes' => 
    array (
      0 => 'light',
      1 => 'dark',
      2 => 'rainbowbarf',
      3 => 'broto',
      4 => 'nightMode',
    ),
    'logoThemes' => 
    array (
      0 => 'regular',
      1 => 'inverse',
      2 => 'regular',
      3 => 'broto-inverse',
      4 => 'inverse',
    ),
    'analytics_url' => 'analytics.saproto.nl',
  ),
  'protube' => 
  array (
    'server' => 'https://host.docker.internal:3001',
    'laravel_to_protube_secret' => '321',
    'protube_to_laravel_secret' => 'SECRET_KEY',
    'remote_url' => 'https://protu.be/remote',
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'backoff' => 30,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => NULL,
        'secret' => NULL,
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'high' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'high',
        'backoff' => 30,
      ),
      'medium' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'medium',
        'backoff' => 60,
      ),
      'low' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'low',
        'backoff' => 120,
      ),
    ),
    'batching' => 
    array (
      'database' => 'sqlite',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => NULL,
      'table' => 'failed_jobs',
    ),
  ),
  'recaptcha' => 
  array (
    'api_site_key' => 'PUBLIC_KEY',
    'api_secret_key' => 'PRIVATE_KEY',
    'version' => 'v2',
    'curl_timeout' => 1,
    'skip_ip' => 
    array (
    ),
    'default_validation_route' => 'biscolab-recaptcha/validate',
    'default_token_parameter_name' => 'token',
    'default_language' => 'en-GB',
    'default_form_id' => 'biscolab-recaptcha-invisible-form',
    'explicit' => false,
    'api_domain' => 'www.google.com',
    'empty_message' => false,
    'error_message_key' => 'validation.recaptcha',
    'tag_attributes' => 
    array (
      'theme' => 'light',
      'size' => 'normal',
      'tabindex' => 0,
      'callback' => NULL,
      'expired-callback' => NULL,
      'error-callback' => NULL,
    ),
  ),
  'saml2-attr' => 
  array (
    'givenname' => 'urn:mace:dir:attribute-def:givenName',
    'surname' => 'urn:mace:dir:attribute-def:sn',
    'email' => 'urn:mace:dir:attribute-def:mail',
    'uid' => 'urn:mace:dir:attribute-def:uid',
    'institute' => 'urn:mace:terena.org:attribute-def:schacHomeOrganization',
  ),
  'saml2' => 
  array (
    'surfconext_idp_settings' => 
    array (
      'strict' => true,
      'debug' => true,
      'sp' => 
      array (
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
        'x509cert' => 'X509_CERT_DATA',
        'privateKey' => 'X509_KEY_DATA',
        'entityId' => NULL,
        'assertionConsumerService' => 
        array (
          'url' => 'http://localhost:8080/saml2/surfconext/acs',
        ),
        'singleLogoutService' => 
        array (
          'url' => 'http://localhost:8080/saml2/surfconext/logout',
        ),
      ),
      'idp' => 
      array (
        'entityId' => 'https://idp.provider.tld',
        'singleSignOnService' => 
        array (
          'url' => 'https://sos.url',
        ),
        'singleLogoutService' => 
        array (
          'url' => 'https://sls.url',
        ),
        'x509cert' => 'X509_CERT_DATA',
        'validate.authnrequest' => true,
        'saml20.sign.assertion' => true,
      ),
      'security' => 
      array (
        'nameIdEncrypted' => false,
        'authnRequestsSigned' => true,
        'logoutRequestSigned' => true,
        'logoutResponseSigned' => true,
        'signMetadata' => true,
        'wantMessagesSigned' => false,
        'wantAssertionsSigned' => true,
        'wantNameIdEncrypted' => false,
        'requestedAuthnContext' => true,
      ),
      'contactPerson' => 
      array (
        'technical' => 
        array (
          'givenName' => 'Have You Tried Turning It Off And On Again committee',
          'emailAddress' => 'sysadmin@proto.utwente.nl',
        ),
        'support' => 
        array (
          'givenName' => 'Have You Tried Turning It Off And On Again committee',
          'emailAddress' => 'sysadmin@proto.utwente.nl',
        ),
      ),
      'organization' => 
      array (
        'en-US' => 
        array (
          'name' => 'S.A. Proto SAML 2.0 Service Provider / UTwente SSO',
          'displayname' => 'S.A. Proto SAML 2.0 SP',
          'url' => 'http://localhost:8080',
        ),
      ),
    ),
  ),
  'saml2_settings' => 
  array (
    'idpNames' => 
    array (
      0 => 'surfconext',
    ),
    'useRoutes' => true,
    'routesPrefix' => '/saml2',
    'routesMiddleware' => 
    array (
      0 => 'web',
      1 => 'saml',
    ),
    'retrieveParametersFromServer' => false,
    'logoutRoute' => '/',
    'loginRoute' => '/surfconext/post',
    'errorRoute' => '/',
  ),
  'sentry' => 
  array (
    'dsn' => 'https://xyz:xyz@sentry.io/123',
    'release' => NULL,
    'environment' => NULL,
    'sample_rate' => 1.0,
    'traces_sample_rate' => NULL,
    'profiles_sample_rate' => NULL,
    'send_default_pii' => false,
    'ignore_transactions' => 
    array (
      0 => '/up',
    ),
    'breadcrumbs' => 
    array (
      'logs' => true,
      'sql_queries' => true,
      'sql_bindings' => true,
      'queue_info' => true,
      'command_info' => true,
    ),
    'tracing' => 
    array (
      'queue_job_transactions' => true,
      'queue_jobs' => true,
      'sql_queries' => true,
      'sql_bindings' => false,
      'sql_origin' => true,
      'sql_origin_threshold_ms' => 100,
      'views' => true,
      'livewire' => true,
      'http_client_requests' => true,
      'cache' => true,
      'redis_commands' => false,
      'redis_origin' => true,
      'notifications' => true,
      'missing_routes' => false,
      'continue_after_response' => true,
      'default_integrations' => true,
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 10080,
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => '/var/www/html/storage/framework/sessions',
    'connection' => 'mysql',
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'proto_session',
    'path' => '/',
    'domain' => 'localhost',
    'secure' => true,
    'http_only' => true,
    'same_site' => 'none',
    'partitioned' => false,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/var/www/html/resources/views',
    ),
    'compiled' => '/var/www/html/storage/framework/views',
  ),
  'youtube' => 
  array (
    'key' => 'API_KEY',
  ),
  'concurrency' => 
  array (
    'driver' => 'process',
  ),
  'clockwork' => 
  array (
    'enable' => NULL,
    'features' => 
    array (
      'cache' => 
      array (
        'enabled' => true,
        'collect_queries' => true,
        'collect_values' => false,
      ),
      'database' => 
      array (
        'enabled' => true,
        'collect_queries' => true,
        'collect_models_actions' => true,
        'collect_models_retrieved' => false,
        'slow_threshold' => NULL,
        'slow_only' => false,
        'detect_duplicate_queries' => false,
      ),
      'events' => 
      array (
        'enabled' => true,
        'ignored_events' => 
        array (
        ),
      ),
      'log' => 
      array (
        'enabled' => true,
      ),
      'notifications' => 
      array (
        'enabled' => true,
      ),
      'performance' => 
      array (
        'client_metrics' => true,
      ),
      'queue' => 
      array (
        'enabled' => true,
      ),
      'redis' => 
      array (
        'enabled' => true,
      ),
      'routes' => 
      array (
        'enabled' => false,
        'only_namespaces' => 
        array (
          0 => 'App',
        ),
      ),
      'views' => 
      array (
        'enabled' => true,
        'collect_data' => false,
        'use_twig_profiler' => false,
      ),
    ),
    'web' => true,
    'toolbar' => true,
    'requests' => 
    array (
      'on_demand' => false,
      'errors_only' => false,
      'slow_threshold' => NULL,
      'slow_only' => false,
      'sample' => false,
      'except' => 
      array (
        0 => '/horizon/.*',
        1 => '/telescope/.*',
        2 => '/_tt/.*',
        3 => '/_debugbar/.*',
      ),
      'only' => 
      array (
      ),
      'except_preflight' => true,
    ),
    'artisan' => 
    array (
      'collect' => false,
      'except' => 
      array (
      ),
      'only' => 
      array (
      ),
      'collect_output' => false,
      'except_laravel_commands' => true,
    ),
    'queue' => 
    array (
      'collect' => false,
      'except' => 
      array (
      ),
      'only' => 
      array (
      ),
    ),
    'tests' => 
    array (
      'collect' => false,
      'except' => 
      array (
      ),
    ),
    'collect_data_always' => false,
    'storage' => 'files',
    'storage_files_path' => '/var/www/html/storage/clockwork',
    'storage_files_compress' => false,
    'storage_sql_database' => '/var/www/html/storage/clockwork.sqlite',
    'storage_sql_table' => 'clockwork',
    'storage_redis' => 'default',
    'storage_redis_prefix' => 'clockwork',
    'storage_expiration' => 10080,
    'authentication' => false,
    'authentication_password' => 'VerySecretPassword',
    'stack_traces' => 
    array (
      'enabled' => true,
      'limit' => 10,
      'skip_vendors' => 
      array (
      ),
      'skip_namespaces' => 
      array (
      ),
      'skip_classes' => 
      array (
      ),
    ),
    'serialization_depth' => 10,
    'serialization_blackbox' => 
    array (
      0 => 'Illuminate\\Container\\Container',
      1 => 'Illuminate\\Foundation\\Application',
      2 => 'Laravel\\Lumen\\Application',
    ),
    'register_helpers' => true,
    'headers' => 
    array (
    ),
    'server_timing' => 10,
  ),
  'passport' => 
  array (
    'guard' => 'web',
    'private_key' => NULL,
    'public_key' => NULL,
    'connection' => NULL,
    'client_uuids' => false,
    'personal_access_client' => 
    array (
      'id' => NULL,
      'secret' => NULL,
    ),
  ),
  'mollie' => 
  array (
    'key' => 'test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
