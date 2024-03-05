<?php

declare(strict_types=1);

namespace Metamel\Addresses\Tests\Feature;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Metamel\Addresses\Providers\AddressesServiceProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ServiceProviderTest extends TestCase
{
    /** Get the service provider class. */
    protected function getServiceProviderClass(): string
    {
        return AddressesServiceProvider::class;
    }

    /** @test */
    public function isServiceProvider(): void
    {
        $class = $this->getServiceProviderClass();

        $reflection = new ReflectionClass($class);

        $provider = new ReflectionClass(ServiceProvider::class);

        $msg = "Expected class '{$class}' to be a service provider.";

        $this->assertTrue($reflection->isSubclassOf($provider), $msg);
    }

    /** @test */
    public function hasProvidesMethod(): void
    {
        $class = $this->getServiceProviderClass();
        $reflection = new ReflectionClass($class);

        $method = $reflection->getMethod('provides');
        $method->setAccessible(true);

        $msg = "Expected class '{$class}' to provide a valid list of services.";

        $this->assertIsArray($method->invoke(new $class(new Container())), $msg);
    }
}
