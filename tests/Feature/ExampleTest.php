<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // O teste tenta acessar a página inicial sem estar logado
        $response = $this->get('/');

        // Redirecionando (302) para o LOGIN
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}