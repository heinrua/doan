<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleTest extends TestCase
{
    use RefreshDatabase;

    public function test_basic_authentication(): void
    {
        $user = User::factory()->create([
            'user_name' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        // Test login
        $response = $this->post('/login', [
            'user_name' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        
        // Login user
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        // Test logout
        $response = $this->get('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_guest_can_access_public_pages(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
} 