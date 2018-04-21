<?php

use DouglasDC3\Kong\Model\Certificate;
use PHPUnit\Framework\TestCase;

class CertificateTest extends TestCase
{
    /** @test */
    function it_creates_a_new_certificate_using_fields()
    {
        $cert = new Certificate('our-cert', 'secret-pem', [
            'example.com',
        ]);

        $this->assertEquals('our-cert', $cert->cert);
        $this->assertEquals('secret-pem', $cert->key);
        $this->assertEquals(['example.com'], $cert->snis);
    }

    /** @test */
    function it_creates_a_new_certificate_from_array()
    {
        $cert = new Certificate([
            'cert' => 'our-cert',
            'key' => 'secret-pem',
            'snis' => ['example.com'],
            'created_at' => 123456,
        ]);

        $this->assertEquals('our-cert', $cert->cert);
        $this->assertEquals('secret-pem', $cert->key);
        $this->assertEquals(['example.com'], $cert->snis);
        $this->assertEquals(123456, $cert->created_at);
    }
}
