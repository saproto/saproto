{{-- Blade variable can be accessed through this config object. --}}
<script type="text/javascript">
    const config = {
        routes: {
            api_search_user: "{{ route('api::search::user') }}",
            api_search_event: "{{ route('api::search::event') }}",
            api_search_product: "{{ route('api::search::product') }}",
            api_search_committee: "{{ route('api::search::committee') }}",
            api_slack_count: "{{ route('api::slack::count') }}",
            api_slack_invite: "{{ route('api::slack::invite') }}"
        },
        discord_server_id: "{{ config('proto.discord_server_id') }}"
    }
</script>

<script type="text/javascript" src="{{ mix('/assets/manifest.js') }}"></script>
<script type="text/javascript" src="{{ mix('/assets/vendor.js') }}"></script>
<script type="text/javascript" src="{{ mix('/assets/application.js') }}"></script>

@if(Auth::check() && Auth::user()->theme !== null)

    <!-- Theme JavaScript -->
    <script type="text/javascript">
        try {
            {{ config('proto.themes')[Auth::user()->theme] }}()
        } catch { console.log("Can't execute theme javascript") }
    </script>

@endif