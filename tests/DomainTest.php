<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as Resp;

class DomainTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddDomain()
    {
        $url = 'http://example.com';
        $this->post('/domains', ['name' => $url, ]);
        $this->seeInDatabase('domains', ['name' => $url]);
    }

    public function testNotFoundPage()
    {
        $this->get('/domains/0');
        $this->assertResponseStatus(Resp::HTTP_NOT_FOUND);
    }

    public function testRequiredFields()
    {
        $url = '';
        $this->post('/domains', ['name' => $url]);
        $this->assertResponseStatus(Resp::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testWrongDomain()
    {
        $url = 'http://ru.yandex.ru';
        $this->post('/domains', ['name' => $url]);
        $this->seeInDatabase('domains', ['name' => $url, 'status_code' => 0]);
    }

    public function testGuzzleAddDomain()
    {
        $name = 'http://yandex.ru/oi3n911ndn230awh8dhqu20nd2mq029mdq2md-q';
        $mock = new MockHandler([ new Response(Resp::HTTP_OK, ['Content-Length' => 8], 'sometext') ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $client);
        $expectedParameters = [
            'name' => $name,
            'body' => 'sometext',
            'status_code' => Resp::HTTP_OK,
            'content_length' => 8
        ];
        $this->post("/domains", ['name' => $name], []);
        $this->seeInDatabase("domains", $expectedParameters);
    }

    public function testSEOGuzzleAddDomain()
    {
        $name = 'http://yandex.ru/oi3n911ndn230awh8dhqu20nd2mq029mdq2md-q';
        $body = file_get_contents('tests/fixtures/example.html');
        $mock = new MockHandler([ new Response(Resp::HTTP_OK, [], $body) ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $client);
        $expectedParameters = [
            'name' => $name,
            'status_code' => Resp::HTTP_OK,
            'h1' => 'Hello World',
            'keywords' => 'keywords',
            'description' => 'description'
        ];
        $this->post("/domains", ['name' => $name], []);
        $this->seeInDatabase("domains", $expectedParameters);
    }
}
