<?php

use DouglasDC3\Kong\Model\Route;
use DouglasDC3\Kong\Model\Service;

class RouteTest extends KongTest 
{
    protected static $service;

    /** @test */
    function it_creates_routes()
    {
        $route = $this->kong->routes()->create(new Route(['hosts' => ['create.example.com'], 'service' => $this->getService()]));

        $this->assertNotNull($route->id);
        $this->assertEquals(['create.example.com'], $route->hosts);
        $this->assertEquals(static::$service->id, $route->service);
        $this->assertEquals("routes/{$route->id}", $route->getPath());
    }

    /** @test */
    function it_finds_routes()
    {
        $id = $this->kong->routes()->create(new Route(['hosts' => ['find.example.com'], 'service' => $this->getService()]))->id;

        $route = $this->kong->routes()->find($id);

        $this->assertNotNull($route->id);
        $this->assertEquals(['find.example.com'], $route->hosts);
        $this->assertEquals(static::$service->id, $route->service);
    }

    /** @test */
    function it_updates_routes()
    {
        $route = $this->kong->routes()->create(new Route(['hosts' => ['updates.example.com'], 'service' => $this->getService()]));

        $route->paths = ['/foobar'];
        $updatedRoute = $this->kong->routes()->update($route);

        $this->assertNotNull($route->id);
        $this->assertEquals(['updates.example.com'], $updatedRoute->hosts);
        $this->assertEquals(['/foobar'], $updatedRoute->paths);
        $this->assertEquals(static::$service->id, $updatedRoute->service);
    }

    /** @test */
    function it_lists_routes()
    {
         $this->kong->routes()->create(new Route(['hosts' => ['list.example.com'], 'service' => $this->getService()]));
         
         $routes = $this->kong->routes()->list();

         $this->assertTrue($routes->count() > 0);
         $this->assertEquals(1, $routes->where('hosts', ['list.example.com'])->count());
    }

    /** @test */
    function it_deletes_route_using_id()
    {
        $route = $this->kong->routes()->create(new Route(['hosts' => ['delete-id.example.com'], 'service' => $this->getService()]));
         
        $this->kong->routes()->delete($route->id);

        $routes = $this->kong->routes()->list();
        $this->assertEquals(0, $routes->where('hosts', ['delete-id.example.com'])->count());
    }

    /** @test */
    function it_deletes_route_using_instance()
    {
        $route = $this->kong->routes()->create(new Route(['hosts' => ['delete.example.com'], 'service' => $this->getService()]));
         
        $this->kong->routes()->delete($route);

        $routes = $this->kong->routes()->list();
        $this->assertEquals(0, $routes->where('hosts', ['delete.example.com'])->count());
    }

    /** @test */
    function it_links_to_plugins()
    {
        $route = $this->kong->routes()->create(new Route(['hosts' => ['delete.example.com'], 'service' => $this->getService()]));

        $plugins = $route->plugins()->list();

        $this->assertCount(0, $plugins);
    }

    private function getService() {
        if (!static::$service) {
            static::$service = $this->kong->services()->create(new Service(['host' => 'test.example.com', 'name' => 'route-service-test']));
        }

        return static::$service;
    }
}
