<?php

namespace Tests\Feature\Company;

use App\Models\V1\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_companies(): void
    {
        $user = User::factory()->create();
        Company::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/companies');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['current_page', 'per_page', 'total', 'last_page'],
        ]);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_company(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/companies', [
                'user_id' => $user->id,
                'name'    => 'Test Company',
                'code'    => 'TC001',
                'status'  => 'active',
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name'  => 'Test Company',
                'code'  => 'TC001',
                'status'=> 'active',
            ],
        ]);

        $this->assertDatabaseHas('companies', ['code' => 'TC001']);
    }

    public function test_user_can_show_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'code'    => 'TC001',
            'name'    => 'Test Company',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/companies/TC001');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'code' => 'TC001',
                'name' => 'Test Company',
            ],
        ]);
    }

    public function test_user_can_update_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'code'    => 'TC001',
            'name'    => 'Test Company',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/companies/TC001', [
                'name'  => 'Updated Company',
                'status'=> 'inactive',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name'  => 'Updated Company',
                'status'=> 'inactive',
            ],
        ]);

        $this->assertDatabaseHas('companies', [
            'code'  => 'TC001',
            'name'  => 'Updated Company',
        ]);
    }

    public function test_user_can_delete_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'code'    => 'TC001',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/companies/TC001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('companies', ['code' => 'TC001']);
    }

    public function test_user_can_restore_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'code'    => 'TC001',
        ]);
        $company->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/companies/TC001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', ['code' => 'TC001']);
    }

    public function test_user_can_force_delete_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'code'    => 'TC001',
        ]);
        $company->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/companies/TC001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('companies', ['code' => 'TC001']);
    }

    public function test_returns_404_for_missing_company(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/companies/NONEXISTENT');

        $response->assertStatus(404);
    }
}
