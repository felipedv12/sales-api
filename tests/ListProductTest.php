<?php
namespace Tests;

use App\Utils\Consts;

class ListProductTest extends Test
{
    public function testListProducts()
    {
        $response = $this->http->request('GET', 'products');
        $this->assertEquals(Consts::HTTP_CODE_OK, $response->getStatusCode());
        $this->assertContains('application/json', $response->getHeader('Content-Type'));
        $this->assertJson($response->getBody());

        $body = json_decode($response->getBody(), true);

        $this->assertIsArray($body);
        $this->assertGreaterThan(0, count($body));
        $this->assertArrayHasKey('success', $body);

    }
}