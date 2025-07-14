<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommuneManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_commune_list(): void
    {
        $response = $this->get('/list-commune');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_commune_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/create-commune');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_commune(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        
        $response = $this->actingAs($user)
            ->post('/create-commune', [
                'name' => 'Test Commune',
                'code' => 'TC001',
                'district_id' => $district->id,
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertRedirect('/list-commune');
        
        $this->assertDatabaseHas('communes', [
            'name' => 'Test Commune',
            'code' => 'TC001',
            'district_id' => $district->id,
            'coordinates' => '10.123,20.456',
        ]);
    }

    public function test_cannot_create_commune_with_duplicate_name(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        Commune::factory()->create(['name' => 'Existing Commune']);
        
        $response = $this->actingAs($user)
            ->post('/create-commune', [
                'name' => 'Existing Commune', // Duplicate name
                'code' => 'TC002',
                'district_id' => $district->id,
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_cannot_create_commune_with_duplicate_code(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        Commune::factory()->create(['code' => 'TC001']);
        
        $response = $this->actingAs($user)
            ->post('/create-commune', [
                'name' => 'New Commune',
                'code' => 'TC001', // Duplicate code
                'district_id' => $district->id,
                'coordinates' => '10.123,20.456',
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_authenticated_user_can_view_edit_commune_form(): void
    {
        $user = User::factory()->create();
        $commune = Commune::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/edit-commune/{$commune->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_commune(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/update-commune', [
                'id' => $commune->id,
                'name' => 'Updated Commune',
                'code' => 'UC001',
                'district_id' => $district->id,
                'coordinates' => '15.789,25.123',
            ]);

        $response->assertRedirect('/list-commune');
        
        $commune->refresh();
        $this->assertEquals('Updated Commune', $commune->name);
        $this->assertEquals('UC001', $commune->code);
        $this->assertEquals('15.789,25.123', $commune->coordinates);
        $this->assertEquals($district->id, $commune->district_id);
    }

    public function test_authenticated_user_can_delete_commune(): void
    {
        $user = User::factory()->create();
        $commune = Commune::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/delete-commune/{$commune->id}");

        $response->assertRedirect('/list-commune');
        
        $this->assertDatabaseMissing('communes', ['id' => $commune->id]);
    }

    public function test_authenticated_user_can_delete_multiple_communes(): void
    {
        $user = User::factory()->create();
        $communes = Commune::factory()->count(3)->create();
        $communeIds = $communes->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
            ->delete('/delete-multiple-commune', [
                'ids' => $communeIds,
            ]);

        $response->assertRedirect();
        
        foreach ($communeIds as $id) {
            $this->assertDatabaseMissing('communes', ['id' => $id]);
        }
    }

    public function test_commune_list_can_be_searched(): void
    {
        Commune::factory()->create(['name' => 'Test Commune']);
        Commune::factory()->create(['name' => 'Another Commune']);
        
        $response = $this->get('/list-commune?type=name&search=Test');
        $response->assertStatus(200);
        $response->assertSee('Test Commune');
        $response->assertDontSee('Another Commune');
    }

    public function test_can_get_communes_by_district(): void
    {
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
            $response = $this->get("/get-communes/{$district->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $commune->id]);
    }

    public function test_guest_cannot_access_create_commune_form(): void
    {
        $response = $this->get('/create-commune');
        $response->assertRedirect('/login');
    }
} 