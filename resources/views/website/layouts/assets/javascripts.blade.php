<script type="text/javascript">
    // Any information you need to get through blade syntax
    // can be communicated to JS using this config object.
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