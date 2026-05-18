<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_student_can_login(): void
    {
        $this->seed();

        $this->post('/login', [
            'email' => 'student@umindanao.edu.ph',
            'password' => 'password',
        ])->assertRedirect('/dashboard');
    }
}
