<?php

use DouglasDC3\Kong\Model\Consumer;

class ConsumersTest extends KongTest
{
    /** @test */
    function it_creates_a_consumer()
    {
        $consumer = new Consumer(['username' => 'create-consumer-john', 'custom_id' => 'create-foobar']);

        $createdConsumer = $this->kong->consumers()->create($consumer);

        $this->assertNotNull($createdConsumer->id);
        $this->assertNotNull($createdConsumer->created_at);
        $this->assertEquals('create-consumer-john', $createdConsumer->username);
        $this->assertEquals('create-foobar', $createdConsumer->custom_id);
    }

    /** @test */
    function it_lists_consumers()
    {
        $this->kong->consumers()->create(new Consumer(['username' => 'list-consumer-john', 'custom_id' => 'list-foobar']));

        $consumers = $this->kong->consumers()->list();

        $this->assertTrue($consumers->count() > 0);
        $this->assertEquals(1, $consumers->where('username', 'list-consumer-john')->count());
    }

    /** @test */
    function it_finds_consumer()
    {
        $id = $this->kong->consumers()->create(new Consumer(['username' => 'find-consumer-john', 'custom_id' => 'find-foobar']))->id;

        $consumer = $this->kong->consumers()->find($id);

        $this->assertNotNull($consumer->id);
        $this->assertNotNull($consumer->created_at);
        $this->assertEquals('find-consumer-john', $consumer->username);
        $this->assertEquals('find-foobar', $consumer->custom_id);
    }

    /** @test */
    function it_updates_consumer()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'update-consumer-john', 'custom_id' => 'update-foobar']));

        $consumer->custom_id = 'foobarbaz';
        $updatedConsumer = $this->kong->consumers()->update($consumer);

        $this->assertEquals($consumer->id, $updatedConsumer->id);
        $this->assertEquals($consumer->created_at, $updatedConsumer->created_at);
        $this->assertEquals($consumer->username, $updatedConsumer->username);
        $this->assertEquals('foobarbaz', $updatedConsumer->custom_id);
    }

    /** @test */
    function it_deletes_conumser_using_id()
    {
         $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'delete-consumer-john-id', 'custom_id' => 'delete-foobar']));

         $this->kong->consumers()->delete($consumer->id);

         $this->assertEquals(0, $this->kong->consumers()->list()->where('username', 'delete-consumer-john-id')->count());
    }

    /** @test */
    function it_deletes_consumer_using_instance()
    {
         $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'delete-consumer-john', 'custom_id' => 'delete-id-foobar']));

         $this->kong->consumers()->delete($consumer);

         $this->assertEquals(0, $this->kong->consumers()->list()->where('username', 'delete-consumer-john')->count());
    }

    /** @test */
    function it_links_to_acl()
    {
         $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'acl-consumer-john', 'custom_id' => 'acl-foobar']));

         $acl = $consumer->acl()->list();

         $this->assertCount(0, $acl);
    }

    /** @test */
    function it_links_to_jwt()
    {
         $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'jwt-consumer-john', 'custom_id' => 'jwt-foobar']));

         $jwt = $consumer->jwt()->list();

         $this->assertCount(0, $jwt);
    }

    /** @test */
    function it_links_to_keyAuth()
    {
         $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'keyAuth-consumer-john', 'custom_id' => 'keyAuth-foobar']));

         $keyAuth = $consumer->keyAuth()->list();

         $this->assertCount(0, $keyAuth);
    }
}
