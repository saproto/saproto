<?php

it('loads all the query pages', function () {
    $routes = [
        route('queries::protube_statistics'),
        route('queries::activity_overview'),
        route('queries::activity_statistics'),
        route('queries::activity_overview'),
        route('queries::membership_totals'),
    ];
    visit($routes)->assertNoSmoke();
});
