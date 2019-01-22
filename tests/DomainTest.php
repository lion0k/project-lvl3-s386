<?php

class DomainTest extends TestCase
{
    public function testAddDomain()
    {
        $url = 'https://example.com';
        $this->post('/domains', ['name' => $url]);
        $this->seeInDatabase('domains', ['name' => $url]);
    }
}