<?php
declare(strict_types=1);

use Superscript\Loqate\Data\Address;
use Superscript\Loqate\Data\Feature;
use Superscript\Loqate\Tests\IntegrationTestCase;

uses(IntegrationTestCase::class);

it('can find an address', function () {
    $response = $this->loqate->address()->find('1 Infinite Loop, Cupertino, CA 95014, USA');

    expect($response->first())->toBeInstanceOf(Feature::class);
});

it('can retrieve an address', function () {
    $response = $this->loqate->address()->retrieve('US|US|B|Z228061793|1');

    expect($response->first())->toBeInstanceOf(Address::class);
});

it('can retrieve an address with extra fields', function () {
    $response = $this->loqate->address()->retrieve(
        id: 'US|US|B|Z228061793|1',
        with: ['latitude', 'longitude'],
    );

    expect($response->first())->toBeInstanceOf(Address::class)
        ->extra->latitude->not->toBeEmpty()
        ->extra->longitude->not->toBeEmpty()
        ->extra->notThere->toBeEmpty();
});

it('can retrieve an address with custom formats', function () {
    $response = $this->loqate->address()->retrieve(
        id: 'US|US|B|Z228061793|1',
        with: [
            'coordinates' => '{Latitude},{Longitude}'
        ],
    );

    expect($response->first())->toBeInstanceOf(Address::class)
        ->extra->coordinates->not->toBeEmpty();
});
