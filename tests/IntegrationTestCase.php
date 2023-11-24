<?php

namespace Superscript\Loqate\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Superscript\Loqate\Loqate;

abstract class IntegrationTestCase extends BaseTestCase
{
    public Loqate $loqate;

    protected function setUp(): void
    {
        if (! isset($_ENV['LOQATE_API_KEY'])) {
            $this->markTestSkipped('Please provide a LOQATE_API_KEY to run the integration tests.');
        }

        $this->loqate = new Loqate($_ENV['LOQATE_API_KEY']);
    }
}
