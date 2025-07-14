<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Models\Administrative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministrativeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_school_list(): void
    {
        $response = $this->get('/administrative/list-school');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_medical_list(): void
    {
        $response = $this->get('/administrative/list-medical');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_center_list(): void
    {
        $response = $this->get('/administrative/list-center');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_school_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/administrative/create-school');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_medical_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/administrative/create-medical');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_center_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/administrative/create-center');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_school(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
        $response = $this->actingAs($user)
            ->post('/administrative/create-school', [
                'name' => 'Test School',
                'type' => 'school',
                'commune_id' => $commune->id,
                'coordinates' => '10.123,20.456',
                'address' => 'Test Address',
                'description' => 'Test Description',
                'code' => 'TS001',
                'classify' => 'Primary',
                'population' => 500,
            ]);

        $response->assertRedirect('/administrative/list-school');
        
        $this->assertDatabaseHas('administratives', [
            'name' => 'Test School',
            'type' => 'school',
            'commune_id' => $commune->id,
            'coordinates' => '10.123,20.456',
            'address' => 'Test Address',
            'description' => 'Test Description',
            'code' => 'TS001',
            'classify' => 'Primary',
            'population' => 500,
        ]);
    }

    public function test_authenticated_user_can_create_new_medical(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
        $response = $this->actingAs($user)
            ->post('/administrative/create-medical', [
                'name' => 'Test Medical',
                'type' => 'medical',
                'commune_id' => $commune->id,
                'coordinates' => '10.123,20.456',
                'address' => 'Test Address',
                'description' => 'Test Description',
                'code' => 'TM001',
                'classify' => 'Hospital',
                'population' => 1000,
            ]);

        $response->assertRedirect('/administrative/list-medical');
        
        $this->assertDatabaseHas('administratives', [
            'name' => 'Test Medical',
            'type' => 'medical',
            'commune_id' => $commune->id,
            'coordinates' => '10.123,20.456',
            'address' => 'Test Address',
            'description' => 'Test Description',
            'code' => 'TM001',
            'classify' => 'Hospital',
            'population' => 1000,
        ]);
    }

    public function test_authenticated_user_can_create_new_center(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
        $response = $this->actingAs($user)
            ->post('/administrative/create-center', [
                'name' => 'Test Center',
                'type' => 'center',
                'commune_id' => $commune->id,
                'coordinates' => '10.123,20.456',
                'address' => 'Test Address',
                'description' => 'Test Description',
                'code' => 'TC001',
                'classify' => 'Community',
                'population' => 2000,
            ]);

        $response->assertRedirect('/administrative/list-center');
        
        $this->assertDatabaseHas('administratives', [
            'name' => 'Test Center',
            'type' => 'center',
            'commune_id' => $commune->id,
            'coordinates' => '10.123,20.456',
            'address' => 'Test Address',
            'description' => 'Test Description',
            'code' => 'TC001',
            'classify' => 'Community',
            'population' => 2000,
        ]);
    }

    public function test_cannot_create_administrative_with_duplicate_name(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        Administrative::factory()->create(['name' => 'Existing School', 'type' => 'school']);
        
        $response = $this->actingAs($user)
            ->post('/administrative/create-school', [
                'name' => 'Existing School', // Duplicate name
                'type' => 'school',
                'commune_id' => $commune->id,
                'coordinates' => '10.123,20.456',
                'address' => 'Test Address',
                'description' => 'Test Description',
                'code' => 'TS002',
                'classify' => 'Primary',
                'population' => 500,
            ]);

        $response->assertSessionHasErrors();
    }

    public function test_authenticated_user_can_view_edit_school_form(): void
    {
        $user = User::factory()->create();
        $school = Administrative::factory()->create(['type' => 'school']);
        
        $response = $this->actingAs($user)
            ->get("/administrative/edit-school/{$school->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_school(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        $school = Administrative::factory()->create(['type' => 'school']);
        
        $response = $this->actingAs($user)
            ->post('/administrative/edit-school', [
                'id' => $school->id,
                'name' => 'Updated School',
                'type' => 'school',
                'commune_id' => $commune->id,
                'coordinates' => '15.789,25.123',
                'address' => 'Updated Address',
                'description' => 'Updated Description',
                'code' => 'US001',
                'classify' => 'Secondary',
                'population' => 800,
            ]);

        $response->assertRedirect('/administrative/list-school');
        
        $school->refresh();
        $this->assertEquals('Updated School', $school->name);
        $this->assertEquals('15.789,25.123', $school->coordinates);
        $this->assertEquals('Updated Address', $school->address);
        $this->assertEquals('Updated Description', $school->description);
        $this->assertEquals('US001', $school->code);
        $this->assertEquals('Secondary', $school->classify);
        $this->assertEquals(800, $school->population);
    }

    public function test_authenticated_user_can_delete_school(): void
    {
        $user = User::factory()->create();
        $school = Administrative::factory()->create(['type' => 'school']);
        
        $response = $this->actingAs($user)
            ->get("/administrative/delete-school/{$school->id}?type=school");

        $response->assertRedirect('/administrative/list-school');
        
        $this->assertDatabaseMissing('administratives', ['id' => $school->id]);
    }

    public function test_authenticated_user_can_delete_multiple_schools(): void
    {
        $user = User::factory()->create();
        $schools = Administrative::factory()->count(3)->create(['type' => 'school']);
        $schoolIds = $schools->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
            ->delete('/administrative/delete-multiple-school', [
                'ids' => $schoolIds,
            ]);

        $response->assertRedirect();
        
        foreach ($schoolIds as $id) {
            $this->assertDatabaseMissing('administratives', ['id' => $id]);
        }
    }

    public function test_school_list_can_be_searched(): void
    {
        Administrative::factory()->create(['name' => 'Test School', 'type' => 'school']);
        Administrative::factory()->create(['name' => 'Another School', 'type' => 'school']);
        
        $response = $this->get('/administrative/list-school?name=Test');
        $response->assertStatus(200);
        $response->assertSee('Test School');
        $response->assertDontSee('Another School');
    }

    public function test_guest_cannot_access_create_school_form(): void
    {
        $response = $this->get('/administrative/create-school');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_medical_form(): void
    {
        $response = $this->get('/administrative/create-medical');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_center_form(): void
    {
        $response = $this->get('/administrative/create-center');
        $response->assertRedirect('/login');
    }
} 