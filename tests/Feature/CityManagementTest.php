<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_city_list(): void
    {
        $response = $this->get('/list-city');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_city_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/create-city');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_city(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/create-city', [
                'name' => 'Test City',
                'code' => 'TC001',
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertRedirect('/list-city');
        
        $this->assertDatabaseHas('cities', [
            'name' => 'Test City',
            'code' => 'TC001',
            'coordinates' => '10.123,20.456',
        ]);
    }

    public function test_cannot_create_city_with_duplicate_name(): void
    {
        $user = User::factory()->create();
        City::factory()->create(['name' => 'Existing City']);
        
        $response = $this->actingAs($user)
            ->post('/create-city', [
                'name' => 'Existing City', // Duplicate name
                'code' => 'TC002',
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_cannot_create_city_with_duplicate_code(): void
    {
        $user = User::factory()->create();
        City::factory()->create(['code' => 'TC001']);
        
        $response = $this->actingAs($user)
            ->post('/create-city', [
                'name' => 'New City',
                'code' => 'TC001', // Duplicate code
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_authenticated_user_can_view_edit_city_form(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/edit-city/{$city->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_city(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/update-city', [
                'id' => $city->id,
                'name' => 'Updated City',
                'code' => 'UC001',
                'coordinates' => '15.789,25.123',
            ]);

        $response->assertRedirect('/list-city');
        
        $city->refresh();
        $this->assertEquals('Updated City', $city->name);
        $this->assertEquals('UC001', $city->code);
        $this->assertEquals('15.789,25.123', $city->coordinates);
    }

    public function test_authenticated_user_can_delete_city(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/delete-city/{$city->id}");

        $response->assertRedirect('/list-city');
        
        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }

    public function test_authenticated_user_can_delete_multiple_cities(): void
    {
        $user = User::factory()->create();
        $cities = City::factory()->count(3)->create();
        $cityIds = $cities->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
            ->delete('/delete-multiple-city', [
                'ids' => $cityIds,
            ]);

        $response->assertRedirect();
        
        foreach ($cityIds as $id) {
            $this->assertDatabaseMissing('cities', ['id' => $id]);
        }
    }

    public function test_city_list_can_be_searched(): void
    {
        City::factory()->create(['name' => 'Test City']);
        City::factory()->create(['name' => 'Another City']);
        
        $response = $this->get('/list-city?name=Test');
        $response->assertStatus(200);
        $response->assertSee('Test City');
        $response->assertDontSee('Another City');
    }

    public function test_guest_cannot_access_create_city_form(): void
    {
        $response = $this->get('/create-city');
        $response->assertRedirect('/login');
    }
} 