<?php

use DouglasDC3\Kong\Model\Info;

class InfoTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    function it_sets_defaults()
    {
        $info = new Info();

        $this->assertEquals('', $info->version);
        $this->assertEquals('', $info->hostname);
    }

    /** @test */
    function it_maps_a_array_to_object()
    {
        $params = [
            'version'  => '0.13.0',
            'hostname' => 'KongBar',
        ];

        $info = new Info($params);

        $this->assertEquals($params, $info->toArray());
    }
}
