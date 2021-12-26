{{-- Blade variable can be accessed through this config object. --}}
<script type="text/javascript" nonce="{{ csp_nonce() }}">
    const config = {
        routes: {
            api_search_user: "{{ route('api::search::user') }}",
            api_search_event: "{{ route('api::search::event') }}",
            api_search_product: "{{ route('api::search::product') }}",
            api_search_committee: "{{ route('api::search::committee') }}",
        },
        analytics_url: "{{ config('proto.analytics_url') }}",
        discord_server_id: "{{ config('proto.discord_server_id') }}",
        theme: "{{ Auth::check() && Auth::user()->theme !== null ? config('proto.themes')[Auth::user()->theme] : 'light' }}",
        @isset($companies) company_count: {{ count($companies) }} @endisset
    }
</script>

<script type="text/javascript" src="{{ mix('/js/manifest.js') }}"></script>
@foreach(glob('js/*vendor.js') as $chunk)
    <script type="text/javascript" src="{{ mix("$chunk") }}"></script>
@endforeach
<script type="text/javascript" src="{{ mix('/js/application.js') }}"></script>