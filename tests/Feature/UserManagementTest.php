<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_user_list(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/list-user');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_user_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/create-user');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_user(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/create-user', [
                'user_name' => 'testuser',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'full_name' => 'Test User',
                'phone' => '0123456789',
            ]);

        $response->assertRedirect('/list-user');
        
        $this->assertDatabaseHas('users', [
            'user_name' => 'testuser',
            'email' => 'test@example.com',
            'full_name' => 'Test User',
            'phone' => '0123456789',
        ]);
    }

    public function test_cannot_create_user_with_duplicate_user_name(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['user_name' => 'existinguser']);
        
        $response = $this->actingAs($user)
            ->post('/create-user', [
                'user_name' => 'existinguser', // Duplicate user_name
                'email' => 'new@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'full_name' => 'New User',
                'phone' => '0123456789',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_cannot_create_user_with_duplicate_email(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['email' => 'existing@example.com']);
        
        $response = $this->actingAs($user)
            ->post('/create-user', [
                'user_name' => 'newuser',
                'email' => 'existing@example.com', // Duplicate email
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'full_name' => 'New User',
                'phone' => '0123456789',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_authenticated_user_can_view_edit_user_form(): void
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/edit-user/{$targetUser->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_user(): void
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/update-user', [
                'id' => $targetUser->id,
                'user_name' => 'updateduser',
                'email' => 'updated@example.com',
                'full_name' => 'Updated User',
                'phone' => '0987654321',
            ]);

        $response->assertRedirect('/list-user');
        
        $targetUser->refresh();
        $this->assertEquals('updateduser', $targetUser->user_name);
        $this->assertEquals('updated@example.com', $targetUser->email);
        $this->assertEquals('Updated User', $targetUser->full_name);
        $this->assertEquals('0987654321', $targetUser->phone);
    }

    public function test_authenticated_user_can_delete_user(): void
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/delete-user/{$targetUser->id}");

        $response->assertRedirect('/list-user');
        
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_authenticated_user_can_delete_multiple_users(): void
    {
        $user = User::factory()->create();
        $targetUsers = User::factory()->count(3)->create();
        $targetUserIds = $targetUsers->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
            ->delete('/delete-multiple-user', [
                'ids' => $targetUserIds,
            ]);

        $response->assertRedirect();
        
        foreach ($targetUserIds as $id) {
            $this->assertDatabaseMissing('users', ['id' => $id]);
        }
    }

    public function test_user_list_can_be_searched(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['full_name' => 'Test User']);
        User::factory()->create(['full_name' => 'Another User']);
        
        $response = $this->actingAs($user)
            ->get('/list-user?name=Test');

        $response->assertStatus(200);
        $response->assertSee('Test User');
        $response->assertDontSee('Another User');
    }

    public function test_guest_cannot_access_user_management(): void
    {
        $response = $this->get('/list-user');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_user_form(): void
    {
        $response = $this->get('/create-user');
        $response->assertRedirect('/login');
    }
} 