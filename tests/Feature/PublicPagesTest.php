<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->seed();
        $this->get('/')->assertOk()->assertSee('AUTUMN')->assertSee('Shop by');
    }

    public function test_registration_rejects_non_umindanao_email(): void
    {
        $this->seed();
        $this->post('/register', [
            'name' => 'Invalid User',
            'email' => 'invalid@example.com',
            'program' => 'IT',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('email');
    }
}
