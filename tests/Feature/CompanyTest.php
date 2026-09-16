<?php

use App\Models\Company;

it('does not fault on the committee pages', function () {
    $company = Company::factory()->create();
    $routes = [
        route('companies::admin'),
        route('companies::create'),
        route('companies::edit', ['company' => $company]),
        route('companies::show', ['company' => $company]),
    ];
    visit($routes)->assertNoSmoke();
});
