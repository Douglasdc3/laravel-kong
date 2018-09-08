<?php

use DouglasDC3\Kong\Model\Consumer;

class JwtPluginTest extends KongTest
{
    /** @test */
    function it_creates_jwt()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'add-jwt-token']));

        $this->assertEmpty($consumer->jwt()->list());

        $jwt = $consumer->jwt()->create('our-secret-jwt');

        $this->assertNotEmpty($consumer->jwt()->list());
        $this->assertNotNull($jwt->id);
        $this->assertEquals($consumer->id, $jwt->consumer_id);
        $this->assertEquals('our-secret-jwt', $jwt->key);
    }

    /** @test */
    function it_finds_jwt()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'find-jwt-token']));

        $jwt = $consumer->jwt()->create('find-secret-jwt');
        $found = $consumer->jwt()->find($jwt->id);

        $this->assertEquals($jwt->id, $found->id);
        $this->assertEquals($jwt->consumer_id, $found->consumer_id);
    }
}
