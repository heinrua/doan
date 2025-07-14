<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\RiskLevel;
use App\Models\Calamities;
use App\Models\IncidentReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_works(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_page_works(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login(): void
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

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        
        // Login user
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        // Test logout
        $response = $this->get('/logout');
        $response->assertRedirect('/');

        // Sau khi logout, user không còn authenticated
        $this->assertGuest();
    }

    public function test_city_management_works(): void
    {
        $user = User::factory()->create();
        
        // Test view city list
        $response = $this->get('/list-city');
        $response->assertStatus(200);

        // Test create city form (authenticated only)
        $response = $this->actingAs($user)->get('/create-city');
        $response->assertStatus(200);

        // Test create city
        $response = $this->actingAs($user)->post('/create-city', [
            'name' => 'Test City',
            'code' => 'TC001',
            'coordinates' => '10.123,20.456',
        ]);

        $response->assertRedirect('/list-city');
        $this->assertDatabaseHas('cities', [
            'name' => 'Test City',
            'code' => 'TC001',
        ]);
    }

    public function test_user_management_works(): void
    {
        $user = User::factory()->create();
        
        // Test view user list
        $response = $this->actingAs($user)->get('/list-user');
        $response->assertStatus(200);

        // Test create user form
        $response = $this->actingAs($user)->get('/create-user');
        $response->assertStatus(200);

        // Test create user
        $response = $this->actingAs($user)->post('/create-user', [
            'name' => 'New User',
            'user_name' => 'newuser',
            'password' => 'password123',
            'email' => 'newuser@example.com',
        ]);

        $response->assertRedirect('/list-user');
        $this->assertDatabaseHas('users', [
            'full_name' => 'New User',
            'user_name' => 'newuser',
        ]);
    }

    public function test_incident_report_works(): void
    {
        // Test view incident report page
        $response = $this->get('/incident-report');
        $response->assertStatus(200);

        // Test create incident report page
        $response = $this->get('/create-incident-report');
        $response->assertStatus(200);
    }

    public function test_chat_functionality_works(): void
    {
        $response = $this->get('/chat');
        $response->assertStatus(200);
    }

    public function test_guest_can_subscribe_to_disaster_alerts(): void
    {
        $response = $this->post('/guest-disaster-subscribe', [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('disaster_subscriptions', [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_basic_factories_work(): void
    {
        // Test basic factories that don't have complex relationships
        $user = User::factory()->create();
        $city = City::factory()->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertDatabaseHas('cities', ['id' => $city->id]);
    }

    public function test_public_pages_are_accessible(): void
    {
        $pages = [
            '/list-city',
            '/list-district', 
            '/list-commune',
            '/list-type-of-calamity',
            '/list-risk-level',
            '/list-type-of-construction',
            '/list-sub-type-of-calamity',
            '/list-scenarios',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }
} 