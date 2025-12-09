<?php

namespace Tests;

abstract class TestBase extends TestCase
{
    protected function login(string $email = 'admin@example.com', string $password = '123')
    {
        $uri = '/api/users/login';
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        $data = [
            'email' => $email,
            'password' => $password,
        ];
        $response = $this
            ->withHeaders($headers)
            ->postJson($uri, $data);

        return $response;
    }

    protected function logout($token)
    {
        $uri = '/api/users/logout';
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ];
        $response = $this
            ->withHeaders($headers)
            ->postJson($uri);

        return $response;            
    }


}