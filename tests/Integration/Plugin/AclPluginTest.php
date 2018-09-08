<?php

use DouglasDC3\Kong\Model\Consumer;

class AclPluginTest extends KongTest
{
    /** @test */
    function it_creates_and_deletes_acl()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'add-acl-token']));

        $this->assertEmpty($consumer->acl()->list());

        $acl = $consumer->acl()->create('our-secret-acl');

        $this->assertNotEmpty($consumer->acl()->list());
        $this->assertNotNull($acl->id);
        $this->assertEquals($consumer->id, $acl->consumer_id);
        $this->assertEquals('our-secret-acl', $acl->group);

        $consumer->acl()->delete($acl->group);
        $this->assertEmpty($consumer->acl()->list());
    }

    /** @test */
    function it_finds_acl()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'find-acl-token']));

        $acl = $consumer->acl()->create('find-secret-acl');
        $found = $consumer->acl()->find($acl->id);

        $this->assertEquals($acl->id, $found->id);
        $this->assertEquals($acl->consumer_id, $found->consumer_id);
    }

    /** @test */
    function it_returns_false_when_deleting_a_non_existing_acl_group()
    {
        $consumer = $this->kong->consumers()->create(new Consumer(['username' => 'delete-not-exist-acl']));

        $this->assertFalse($consumer->acl()->delete('this-does-not-exist'));
    }
}
