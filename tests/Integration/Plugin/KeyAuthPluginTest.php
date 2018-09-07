<?php

use DouglasDC3\Kong\Model\Consumer;
use DouglasDC3\Kong\Model\Plugin\KeyAuthConsumer;
use DouglasDC3\Kong\Model\Plugin\KeyAuthPlugin;

class KeyAuthPluginTest extends KongTest
{
    /** @test */
    function it_creates_and_deletes_key_auth_plugin()
    {
        $this->assertEmpty($this->kong->plugins()->list());

        $plugin = $this->kong->plugins()->create(new KeyAuthPlugin());

        $this->assertCount(1, $this->kong->plugins()->list());
        $this->assertNotNull($plugin->id);

        $this->kong->plugins()->delete($plugin->id);
        $this->assertEmpty($this->kong->plugins()->list());
    }

    /** @test */
    function it_updates_plugin()
    {
        $plugin = $this->kong->plugins()->create(new KeyAuthPlugin());
        $plugin->hide_credentials = true;

        $updated = $this->kong->plugins()->update($plugin);

        $this->assertEquals($plugin->id, $updated->id);
        $this->assertEquals(true, $updated->hide_credentials);

        $this->kong->plugins()->delete($plugin->id);
    }

    /** @test */
    function it_adds_a_jwt_token()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'add-jwt-token']));

        $keyAuth = $consumer->keyAuth()->create('our-secret-key');

        $this->assertNotNull($keyAuth->id);
        $this->assertEquals($consumer->id, $keyAuth->consumer_id);
        $this->assertEquals('our-secret-key', $keyAuth->key);
    }

    /** @test */
    function it_adds_a_jwt_token_with_consumer()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'add-jwt-token-with-consumer']));

        $keyAuth = $consumer->keyAuth()->create(['key' => 'array-our-secret-key', 'consumer_id' => $consumer->id]);

        $this->assertNotNull($keyAuth->id);
        $this->assertEquals($consumer->id, $keyAuth->consumer_id);
        $this->assertEquals('array-our-secret-key', $keyAuth->key);
    }

    /** @test */
    function it_adds_a_jwt_token_with_key_auth_consumer()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'add-jwt-token-with-auth-object']));

        $keyAuth = $consumer->keyAuth()->create(new KeyAuthConsumer([
            'key' => 'object-our-secret-key', 'consumer_id' => $consumer->id
        ]));

        $this->assertNotNull($keyAuth->id);
        $this->assertEquals($consumer->id, $keyAuth->consumer_id);
        $this->assertEquals('object-our-secret-key', $keyAuth->key);
    }

    /** @test */
    function it_finds_a_consumer()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'find-jwt-token']));

        $keyAuth = $consumer->keyAuth()->create(new KeyAuthConsumer([
            'key' => 'find-our-secret-key', 'consumer_id' => $consumer->id
        ]));

        $this->assertNotNull($keyAuth->id);
        $this->assertEquals($consumer->id, $keyAuth->consumer_id);
        $this->assertEquals('find-our-secret-key', $keyAuth->key);

        $found = $consumer->keyAuth()->find($keyAuth->id);

        $this->assertEquals($keyAuth->id, $found->id);
        $this->assertEquals($keyAuth->consumer_id, $found->consumer_id);
        $this->assertEquals($keyAuth->key, $found->key);
    }
}
