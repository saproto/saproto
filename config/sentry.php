<?php

return array(
    'dsn' => env('SENTRY_DSN'),
    
    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,
);
