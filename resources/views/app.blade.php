<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @routes(nonce: csp_nonce())
    @inertiaHead
</head>
<body class="font-sans antialiased" data-theme='{{config('proto.themes')[Auth::user()->theme?0:0]}}'>
@inertia
</body>
</html>
