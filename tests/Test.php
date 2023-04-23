<?php
namespace Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class Test extends TestCase
{
    protected $http;

    public function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8080/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }
}