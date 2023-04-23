<?php
namespace Tests;
use App\Utils\Consts;

class ListProductTypeTest extends Test
{
    public function testListProduct()
    {
        $response = $this->http->request('GET', 'product-types');
        $this->assertEquals(Consts::HTTP_CODE_OK, $response->getStatusCode());
    }
}