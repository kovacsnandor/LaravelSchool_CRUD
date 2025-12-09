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

    protected function myGetToken($response)
    {
        $token = $response->json('data')['token'];
        return $token;
    }

    protected function myGet(string $uri, string $token)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        $response = $this
            ->withHeaders($headers)
            ->get($uri);
        return $response;    
    }


    protected function myPost(string $uri, array $data, string $token)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        
        $response = $this
            ->withHeaders($headers)
            ->postJson($uri, $data); // postJson() az adatok JSON-ként való küldéséhez
            
        return $response;
    }

    protected function myPatch(string $uri, array $data, string $token)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        
        $response = $this
            ->withHeaders($headers)
            ->patchJson($uri, $data); // patchJson() az adatok JSON-ként való küldéséhez
            
        return $response;
    }

        protected function myDelete(string $uri, string $token)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];
        
        $response = $this
            ->withHeaders($headers)
            ->delete($uri); // delete() metódus használata
            
        return $response;
    }


}