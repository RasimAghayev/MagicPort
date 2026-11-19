<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken];
    }

    public function test_user_can_list_companies(): void
    {
        $user = User::factory()->create();
        Company::factory()->count(3)->create();

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/companies');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_company(): void
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/companies', [
                'code' => 'C001',
                'name' => 'Test Company',
                'email' => 'company@example.com',
                'is_active' => true,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', ['code' => 'C001']);
    }

    public function test_user_can_show_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/companies/C001');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['code' => 'C001']]);
    }

    public function test_user_can_update_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->putJson('/api/v1/companies/C001', [
                'name' => 'Updated Company',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', ['code' => 'C001', 'name' => 'Updated Company']);
    }

    public function test_user_can_delete_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/companies/C001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('companies', ['code' => 'C001']);
    }

    public function test_user_can_restore_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['code' => 'C001']);
        $company->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/companies/C001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', ['code' => 'C001']);
    }

    public function test_user_can_force_delete_company(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['code' => 'C001']);
        $company->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/companies/C001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('companies', ['code' => 'C001']);
    }
}
