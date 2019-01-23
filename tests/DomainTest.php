<?php

class DomainTest extends TestCase
{
    public function testAddDomain()
    {
        $url = 'https://example.com';
        $this->post('/domains', ['name' => $url]);
        $this->seeInDatabase('domains', ['name' => $url]);
    }

    public function testNotFoundPage()
    {
        $this->get('/domains/0');
        $this->assertResponseStatus(\Illuminate\Http\Response::HTTP_NOT_FOUND);
    }

    public function testValidationError()
    {
        $url = 'example.com';
        $this->post('/domains', ['name' => $url]);
        $this->assertResponseStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRequiredFields()
    {
        $url = '';
        $this->post('/domains', ['name' => $url]);
        $this->assertResponseStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}