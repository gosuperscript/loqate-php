<?php

namespace Superscript\Loqate\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Superscript\Loqate\Loqate;

abstract class IntegrationTestCase extends BaseTestCase
{
    public Loqate $loqate;

    protected function setUp(): void
    {
        Config::preventStrayRequests();

        $this->loqate = (new Loqate($_ENV['LOQATE_API_KEY']));

        $this->withFixture($this->name());
    }

    public function withFixture(string $name): self
    {
        $this->loqate->withMockClient(new MockClient([MockResponse::fixture($name)]));

        return $this;
    }
}
