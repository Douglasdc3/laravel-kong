<?php

use DouglasDC3\Kong\Model\Service;
use GuzzleHttp\Exception\GuzzleException;

class ServiceTest extends KongTest
{
    /** @test */
    function it_returns_an_empty_list_when_no_services_registered()
    {
        $services = $this->kong->services()->list();

        $this->assertCount(0, $services);
    }

    /** @test */
    function it_creates_service() {
        $service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'create-service-test']));

        $this->assertEquals('test.example.com', $service->host);
        $this->assertEquals('create-service-test', $service->name);
        $this->assertNotNull($service->id);
    }

    /** @test */
    function it_creates_a_services_from_full_uri()
    {
        $service = $this->kong->services()->create(new Service('https://test.example.com:1234/my-path'));

        $this->assertEquals('https', $service->protocol);
        $this->assertEquals('test.example.com', $service->host);
        $this->assertEquals(1234, $service->port);
        $this->assertEquals('/my-path', $service->path);
        $this->assertNull($service->name);
        $this->assertNotNull($service->id);
    }

    /** @test */
    function it_finds_a_service() {
        $id = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'get-service-test']))->id;

        $service = $this->kong->services()->find($id);

        $this->assertEquals('test.example.com', $service->host);
        $this->assertEquals('get-service-test', $service->name);
        $this->assertNotNull($service->id);
    }

    /** @test */
    function it_throws_exception_if_could_not_find_service()
    {
        $this->expectException(GuzzleException::class);

        $this->kong->services()->find('does-not-exist');
    }

    /** @test */
    function it_updates_service()
    {
        $service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'update-service-test']));
        $this->assertEquals('test.example.com', $service->host);
        $this->assertEquals('update-service-test', $service->name);
        $this->assertNotNull($service->id);

        $service->host = 'foo.example.com';

        $updatedService = $this->kong->services()->update($service);

        $this->assertEquals('foo.example.com', $updatedService->host);
        $this->assertEquals('update-service-test', $updatedService->name);
        $this->assertEquals($service->id, $updatedService->id);
    }

    /** @test */
    function it_deletes_a_service()
    {
        $service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'delete-service-test']));
        $this->assertNotNull($this->kong->services()->list()->where('id', $service->id)->first());

        $this->kong->services()->delete($service);

        $this->assertNull($this->kong->services()->list()->where('id', $service->id)->first());
    }

    /** @test */
    function it_links_to_plugins()
    {
        $service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'plugin-service-test']));

        $plugins = $service->plugins()->list();

        $this->assertCount(0, $plugins);
    }

    /** @test */
    function it_links_to_routes()
    {
        $service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'acl-service-test']));

        $routes = $service->routes()->list();

        $this->assertCount(0, $routes);
    }
}
