<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use App\Models\District;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistrictManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_district_list(): void
    {
        $response = $this->get('/list-district');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_district_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/create-district');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_district(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/create-district', [
                'name' => 'Test District',
                'code' => 'TD001',
                'city_id' => $city->id,
                'coordinates' => '10.123,20.456',
                'population' => 50000,
                'map' => '[]',
            ]);

        $response->assertRedirect('/list-district');
        
        $this->assertDatabaseHas('districts', [
            'name' => 'Test District',
            'code' => 'TD001',
            'city_id' => $city->id,
            'coordinates' => '10.123,20.456',
            'population' => 50000,
        ]);
    }

    public function test_cannot_create_district_with_duplicate_name(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        District::factory()->create(['name' => 'Existing District']);
        
        $response = $this->actingAs($user)
            ->post('/create-district', [
                'name' => 'Existing District', // Duplicate name
                'code' => 'TD002',
                'city_id' => $city->id,
                'coordinates' => '10.123,20.456',
                'population' => 50000,
                'map' => '[]',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_cannot_create_district_with_duplicate_code(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        District::factory()->create(['code' => 'TD001']);
        
        $response = $this->actingAs($user)
            ->post('/create-district', [
                'name' => 'New District',
                'code' => 'TD001', // Duplicate code
                'city_id' => $city->id,
                'coordinates' => '10.123,20.456',
                'population' => 50000,
                'map' => '[]',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_authenticated_user_can_view_edit_district_form(): void
    {
        $user = User::factory()->create();
        $district = District::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/edit-district/{$district->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_district(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/update-district', [
                'id' => $district->id,
                'name' => 'Updated District',
                'code' => 'UD001',
                'city_id' => $city->id,
                'coordinates' => '15.789,25.123',
                'population' => 60000,
                'map' => '[]',
            ]);

        $response->assertRedirect('/list-district');
        
        $district->refresh();
        $this->assertEquals('Updated District', $district->name);
        $this->assertEquals('UD001', $district->code);
        $this->assertEquals('15.789,25.123', $district->coordinates);
        $this->assertEquals(60000, $district->population);
    }

    public function test_authenticated_user_can_delete_district(): void
    {
        $user = User::factory()->create();
        $district = District::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/delete-district/{$district->id}");

        $response->assertRedirect('/list-district');
        
        $this->assertDatabaseMissing('districts', ['id' => $district->id]);
    }

    public function test_authenticated_user_can_delete_multiple_districts(): void
    {
        $user = User::factory()->create();
        $districts = District::factory()->count(3)->create();
        $districtIds = $districts->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
            ->delete('/delete-multiple-district', [
                'ids' => $districtIds,
            ]);

        $response->assertRedirect();
        
        foreach ($districtIds as $id) {
            $this->assertDatabaseMissing('districts', ['id' => $id]);
        }
    }

    public function test_district_list_can_be_searched(): void
    {
        District::factory()->create(['name' => 'Test District']);
        District::factory()->create(['name' => 'Another District']);
        
        $response = $this->get('/list-district?type=name&search=Test');
        $response->assertStatus(200);
        $response->assertSee('Test District');
        $response->assertDontSee('Another District');
    }

    public function test_guest_cannot_access_create_district_form(): void
    {
        $response = $this->get('/create-district');
        $response->assertRedirect('/login');
    }
} 