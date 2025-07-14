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

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_workflow_from_login_to_calamity_management(): void
    {
        // 1. Tạo user và đăng nhập
        $user = User::factory()->create([
            'user_name' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'user_name' => 'admin',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();

        // 2. Tạo dữ liệu cơ bản
        $city = City::factory()->create(['name' => 'Test City']);
        $district = District::factory()->create(['city_id' => $city->id]);
        $commune = Commune::factory()->create(['district_id' => $district->id]);
        
        $typeOfCalamity = TypeOfCalamities::factory()->create(['name' => 'Sạt lở']);
        $subTypeOfCalamity = SubTypeOfCalamities::factory()->create([
            'type_of_calamity_id' => $typeOfCalamity->id
        ]);
        $riskLevel = RiskLevel::factory()->create([
            'type_of_calamity_id' => $typeOfCalamity->id
        ]);

        // 3. Tạo calamity
        $calamity = Calamities::factory()->create([
            'risk_level_id' => $riskLevel->id,
            'name' => 'Test Calamity'
        ]);

        // 4. Tạo incident report
        $incidentReport = IncidentReport::factory()->create([
            'sub_type_of_calamity_id' => $subTypeOfCalamity->id,
            'commune_id' => $commune->id,
            'reporter_name' => 'Test User',
            'description' => 'Test incident'
        ]);

        // 5. Kiểm tra dashboard hiển thị dữ liệu
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Test Calamity');

        // 6. Kiểm tra incident report list
        $response = $this->get('/incident-report');
        $response->assertStatus(200);
        $response->assertSee('Test User');
        $response->assertSee('Test incident');

        // 7. Kiểm tra city management
        $response = $this->actingAs($user)->get('/list-city');
        $response->assertStatus(200);
        $response->assertSee('Test City');

        // 8. Kiểm tra user management
        $response = $this->actingAs($user)->get('/list-user');
        $response->assertStatus(200);
        $response->assertSee('admin');
    }

    public function test_guest_can_access_public_features(): void
    {
        // Tạo dữ liệu test
        $city = City::factory()->create(['name' => 'Public City']);
        $district = District::factory()->create(['name' => 'Public District']);
        $commune = Commune::factory()->create(['name' => 'Public Commune']);

        // Kiểm tra access public pages
        $response = $this->get('/list-city');
        $response->assertStatus(200);
        $response->assertSee('Public City');

        $response = $this->get('/list-district');
        $response->assertStatus(200);
        $response->assertSee('Public District');

        $response = $this->get('/list-commune');
        $response->assertStatus(200);
        $response->assertSee('Public Commune');
    }

    public function test_authentication_flow(): void
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

        // Test logout
        $response = $this->get('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_data_relationships_work_correctly(): void
    {
        // Tạo dữ liệu có quan hệ
        $city = City::factory()->create(['name' => 'Test City']);
        $district = District::factory()->create([
            'name' => 'Test District',
            'city_id' => $city->id
        ]);
        $commune = Commune::factory()->create([
            'name' => 'Test Commune',
            'district_id' => $district->id
        ]);

        // Kiểm tra quan hệ
        $this->assertEquals($city->id, $district->city_id);
        $this->assertEquals($district->id, $commune->district_id);
        $this->assertEquals('Test City', $district->city->name);
        $this->assertEquals('Test District', $commune->district->name);
    }

    public function test_search_functionality(): void
    {
        City::factory()->create(['name' => 'Searchable City']);
        City::factory()->create(['name' => 'Another City']);

        $response = $this->get('/list-city?name=Searchable');
        $response->assertStatus(200);
        $response->assertSee('Searchable City');
        $response->assertDontSee('Another City');
    }

    public function test_bulk_operations(): void
    {
        $user = User::factory()->create();
        $cities = City::factory()->count(3)->create();
        $cityIds = $cities->pluck('id')->toArray();

        // Test bulk delete
        $response = $this->actingAs($user)
            ->delete('/delete-multiple-city', ['ids' => $cityIds]);

        $response->assertRedirect();

        foreach ($cityIds as $id) {
            $this->assertDatabaseMissing('cities', ['id' => $id]);
        }
    }
} 