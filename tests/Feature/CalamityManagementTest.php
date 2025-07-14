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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalamityManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_flooding_calamity_list(): void
    {
        $response = $this->get('/calamity/list-flooding');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_storm_calamity_list(): void
    {
        $response = $this->get('/calamity/list-storm');
        $response->assertStatus(200);
    }

    public function test_guest_can_view_river_bank_calamity_list(): void
    {
        $response = $this->get('/calamity/list-river-bank');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_flooding_calamity_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/calamity/create-flooding');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_storm_calamity_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/calamity/create-storm');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_river_bank_calamity_form(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get('/calamity/create-river-bank');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_new_flooding_calamity(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        $typeOfCalamity = TypeOfCalamities::factory()->create(['slug' => 'ngap-lut']);
        $subTypeOfCalamity = SubTypeOfCalamities::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        $riskLevel = RiskLevel::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        
        $response = $this->actingAs($user)
            ->post('/calamity/create-flooding', [
                'type_of_calamity_id' => $typeOfCalamity->id,
                'sub_type_of_calamity_ids' => [$subTypeOfCalamity->id],
                'commune_ids' => [$commune->id],
                'risk_level_id' => $riskLevel->id,
                'name' => 'Test Flooding Calamity',
                'coordinates' => '10.123,20.456',
                'flood_level' => 2.5,
                'flood_range' => '100m',
                'flooded_area' => 50.0,
                'time_start' => '15 Tháng 7, 2025',
                'time_end' => '16 Tháng 7, 2025',
                'sprint_time' => 24,
                'reason' => 'Heavy rain',
                'number_of_people_affected' => 100,
                'human_damage' => 'None',
                'property_damage' => 'Minor',
                'damaged_infrastructure' => 'Roads',
                'mitigation_measures' => 'Pumping',
                'data_source' => 'Local reports',
            ]);

        $response->assertRedirect('/calamity/list-flooding');
        
        $this->assertDatabaseHas('calamities', [
            'type_of_calamity_id' => $typeOfCalamity->id,
            'risk_level_id' => $riskLevel->id,
            'name' => 'Test Flooding Calamity',
            'coordinates' => '10.123,20.456',
            'flood_level' => 2.5,
            'flood_range' => '100m',
            'flooded_area' => 50.0,
            'sprint_time' => 24,
            'reason' => 'Heavy rain',
            'number_of_people_affected' => 100,
            'human_damage' => 'None',
            'property_damage' => 'Minor',
            'damaged_infrastructure' => 'Roads',
            'mitigation_measures' => 'Pumping',
            'data_source' => 'Local reports',
        ]);
    }

    public function test_authenticated_user_can_create_new_storm_calamity(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        $typeOfCalamity = TypeOfCalamities::factory()->create(['slug' => 'bao-ap-thap-nhiet-doi']);
        $subTypeOfCalamity = SubTypeOfCalamities::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        $riskLevel = RiskLevel::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        
        $response = $this->actingAs($user)
            ->post('/calamity/create-storm', [
                'type_of_calamity_id' => $typeOfCalamity->id,
                'sub_type_of_calamity_ids' => [$subTypeOfCalamity->id],
                'commune_ids' => [$commune->id],
                'risk_level_id' => $riskLevel->id,
                'name' => 'Test Storm Calamity',
                'coordinates' => '10.123,20.456',
                'investment_level' => 'High',
                'time_start' => '15 Tháng 7, 2025',
                'time_end' => '16 Tháng 7, 2025',
                'human_damage' => 'None',
                'property_damage' => 'Minor',
                'mitigation_measures' => 'Evacuation',
            ]);

        $response->assertRedirect('/calamity/list-storm');
        
        $this->assertDatabaseHas('calamities', [
            'type_of_calamity_id' => $typeOfCalamity->id,
            'risk_level_id' => $riskLevel->id,
            'name' => 'Test Storm Calamity',
            'coordinates' => '10.123,20.456',
            'investment_level' => 'High',
            'human_damage' => 'None',
            'property_damage' => 'Minor',
            'mitigation_measures' => 'Evacuation',
        ]);
    }

    public function test_authenticated_user_can_create_new_river_bank_calamity(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        $typeOfCalamity = TypeOfCalamities::factory()->create(['slug' => 'sat-lo-bo-song-bo-bien']);
        $subTypeOfCalamity = SubTypeOfCalamities::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        $riskLevel = RiskLevel::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        
        $response = $this->actingAs($user)
            ->post('/calamity/create-river-bank', [
                'risk_level_id' => $riskLevel->id,
                'name' => 'Test River Bank Calamity',
                'address' => 'Test Address',
                'length' => 150.0,
                'width' => 75.0,
                'acreage' => 50.0,
                'coordinates' => '10.123,20.456',
                'selected_date' => '15 Tháng 7, 2025',
                'reason' => 'Soil erosion',
                'geology' => 'Clay soil',
                'watermark_points' => 'High water level',
                'human_damage' => 'None',
                'property_damage' => 'Minor',
                'investment_level' => 'Medium',
                'mitigation_measures' => 'Reinforcement',
                'support_policy' => 'Government support',
                'commune_id' => [$commune->id],
                'sub_type_of_calamity_id' => [$subTypeOfCalamity->id],
            ]);

        $response->assertRedirect('/calamity/list-river-bank');
        
        $this->assertDatabaseHas('calamities', [
            'risk_level_id' => $riskLevel->id,
            'name' => 'Test River Bank Calamity',
            'address' => 'Test Address',
            'length' => 150.0,
            'width' => 75.0,
            'acreage' => 50.0,
            'coordinates' => '10.123,20.456',
            'reason' => 'Soil erosion',
            'geology' => 'Clay soil',
            'watermark_points' => 'High water level',
            'human_damage' => 'None',
            'property_damage' => 'Minor',
            'investment_level' => 'Medium',
            'mitigation_measures' => 'Reinforcement',
            'support_policy' => 'Government support',
        ]);
    }

    public function test_authenticated_user_can_view_edit_flooding_calamity_form(): void
    {
        $user = User::factory()->create();
        $calamity = Calamities::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/calamity/edit-flooding/{$calamity->id}");

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_update_flooding_calamity(): void
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        $typeOfCalamity = TypeOfCalamities::factory()->create(['slug' => 'ngap-lut']);
        $subTypeOfCalamity = SubTypeOfCalamities::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        $riskLevel = RiskLevel::factory()->create(['type_of_calamity_id' => $typeOfCalamity->id]);
        $calamity = Calamities::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/calamity/update-flooding', [
                'id' => $calamity->id,
                'type_of_calamity_id' => $typeOfCalamity->id,
                'sub_type_of_calamity_ids' => [$subTypeOfCalamity->id],
                'commune_ids' => [$commune->id],
                'risk_level_id' => $riskLevel->id,
                'name' => 'Updated Flooding Calamity',
                'coordinates' => '15.789,25.123',
                'flood_level' => 3.0,
                'flood_range' => '150m',
                'flooded_area' => 75.0,
                'time_start' => '15 Tháng 7, 2025',
                'time_end' => '16 Tháng 7, 2025',
                'sprint_time' => 36,
                'reason' => 'Updated reason',
                'number_of_people_affected' => 150,
                'human_damage' => 'None',
                'property_damage' => 'Minor',
                'damaged_infrastructure' => 'Roads',
                'mitigation_measures' => 'Pumping',
                'data_source' => 'Local reports',
            ]);

        $response->assertRedirect('/calamity/list-flooding');
        
        $calamity->refresh();
        $this->assertEquals('Updated Flooding Calamity', $calamity->name);
        $this->assertEquals('15.789,25.123', $calamity->coordinates);
        $this->assertEquals(3.0, $calamity->flood_level);
        $this->assertEquals('150m', $calamity->flood_range);
        $this->assertEquals(75.0, $calamity->flooded_area);
        $this->assertEquals(36, $calamity->sprint_time);
        $this->assertEquals('Updated reason', $calamity->reason);
        $this->assertEquals(150, $calamity->number_of_people_affected);
    }

    public function test_authenticated_user_can_delete_flooding_calamity(): void
    {
        $user = User::factory()->create();
        $calamity = Calamities::factory()->create();
        
        $response = $this->actingAs($user)
            ->get("/calamity/delete-flooding/{$calamity->id}");

        $response->assertRedirect('/calamity/list-flooding');
        
        $this->assertDatabaseMissing('calamities', ['id' => $calamity->id]);
    }

    public function test_authenticated_user_can_delete_multiple_flooding_calamities(): void
    {
        $user = User::factory()->create();
        $calamities = Calamities::factory()->count(3)->create();
        $calamityIds = $calamities->pluck('id')->toArray();
        
        $response = $this->actingAs($user)
                ->delete('/calamity/delete-multiple-flooding', [
                'ids' => $calamityIds,
            ]);

        $response->assertRedirect();
        
        foreach ($calamityIds as $id) {
            $this->assertDatabaseMissing('calamities', ['id' => $id]);
        }
    }

    public function test_flooding_calamity_list_can_be_searched(): void
    {
        Calamities::factory()->create(['name' => 'Test Flooding Calamity']);
        Calamities::factory()->create(['name' => 'Another Flooding Calamity']);
        
        $response = $this->get('/calamity/list-flooding?search=Test');
        $response->assertStatus(200);
        $response->assertSee('Test Flooding Calamity');
        $response->assertDontSee('Another Flooding Calamity');
    }

    public function test_guest_cannot_access_create_flooding_calamity_form(): void
    {
        $response = $this->get('/calamity/create-flooding');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_storm_calamity_form(): void
    {
        $response = $this->get('/calamity/create-storm');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_create_river_bank_calamity_form(): void
    {
        $response = $this->get('/calamity/create-river-bank');
        $response->assertRedirect('/login');
    }
} 