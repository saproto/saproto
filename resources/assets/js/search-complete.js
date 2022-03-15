$(".user-search").select2({
    ajax: {
        url: config.routes.api_search_user,
        dataType: 'json',
        delay: 50,
        data: function (params) {
            return {
                q: params.term
            };
        },
        processResults: function (data) {
            return { results: data };
        },
        cache: false
    },
    placeholder: 'Start typing a name...',
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 3,
    templateResult: function (item) {
        if (item.loading) {
            return item.text;
        } else if (item.is_member) {
            opacity = 1;
        } else {
            opacity = 0.3;
        }
        return "<span style='opacity: " + opacity + "'>" + item.name + " (#" + item.id + ")</span>";
    },
    templateSelection: function (item) {
        if (item.id === "") return item.text;
        else return item.name + " (#" + item.id + ")";

    }
});

$(".event-search").select2({
    ajax: {
        url: config.routes.api_search_event,
        dataType: 'json',
        delay: 50,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: false
    },
    placeholder: 'Start typing...',
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 3,
    templateResult: function (item) {
        if (item.loading) return item.text;
        else if (item.is_future) opacity = 1;
        else opacity = 0.3;
        return "<span style='opacity: " + opacity + "'>" + item.title + " (" + item.formatted_date.simple + ")</span>";
    },
    templateSelection: function (item) {
        if (item.id === "") return item.text;
        else return item.title + " (" + item.formatted_date.simple + ")";
    },
    sorter: function (data) {
        return data.sort(function (a, b) {
            if (a.start < b.start) return 1;
            else if (a.start > b.start) return -1;
            else return 0;
        });
    }
});

$(".product-search").select2({
    ajax: {
        url: config.routes.api_search_product,
        dataType: 'json',
        delay: 50,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return { results: data };
        },
        cache: false
    },
    placeholder: 'Start typing a name...',
    escapeMarkup: function (markup) { return markup; },
    minimumInputLength: 3,
    templateResult: function (item) {
        if (item.loading) return item.text;
        else if (item.is_visible) opacity = 1;
        else opacity = 0.3;
        return "<span style='opacity: " + opacity + "'>" + item.name + " (€" + item.price.toFixed(2) + "; " + item.stock + " in stock)</div>";
    },
    templateSelection: function (item) {
        if (item.id === "") return item.text;
        else return item.name;
    },
    sorter: function (data) {
        return data.sort(function (a, b) {
            if (a.is_visible === 0 && b.is_visible === 1) return 1;
            else if (a.is_visible === 1 && b.is_visible === 0) return -1;
            else return 0;
        });
    }
});

$(".committee-search").select2({
    ajax: {
        url: config.routes.api_search_committee,
        dataType: 'json',
        delay: 50,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return { results: data };
        },
        cache: false
    },
    placeholder: 'Start typing a name...',
    minimumInputLength: 1,
    templateResult: function (item) {
        if (item.loading) return item.text;
        else return item.name;
    },
    templateSelection: function (item) {
        if (item.id === "") return item.text;
        else return item.name;
    }
});