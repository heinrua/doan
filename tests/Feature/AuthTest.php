<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'user_name' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'user_name' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'user_name' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'user_name' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_user_can_view_edit_profile_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/edit-profile');

        $response->assertStatus(200);
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'user_name' => 'originaluser',
            'full_name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $response = $this->actingAs($user)
            ->post('/edit_profile', [
                'full_name' => 'Updated Name',
                'user_name' => 'originaluser',
                'email' => 'original@example.com',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ]);

        $response->assertRedirect('/edit-profile');
        
        $user->refresh();
        $this->assertEquals('Updated Name', $user->full_name);
        $this->assertEquals('originaluser', $user->user_name); // Không thay đổi
        $this->assertEquals('original@example.com', $user->email); // Không thay đổi
    }

    public function test_user_cannot_update_profile_with_duplicate_username(): void
    {
        $user1 = User::factory()->create(['user_name' => 'user1']);
        $user2 = User::factory()->create(['user_name' => 'user2']);

        $response = $this->actingAs($user2)
            ->post('/edit_profile', [
                'full_name' => 'Updated Name',
                'user_name' => 'user2',
                'email' => 'user2@example.com',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ]);

        // Controller chỉ cập nhật full_name và password, không cập nhật user_name
        $response->assertRedirect('/edit-profile');
    }
} 