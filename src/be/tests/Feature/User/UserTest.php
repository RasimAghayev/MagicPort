<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken];
    }

    public function test_user_can_list_users(): void
    {
        $admin = User::factory()->create();
        User::factory()->count(3)->create();

        $response = $this->withHeaders($this->authHeaders($admin))
            ->getJson('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_user(): void
    {
        $admin = User::factory()->create();

        $response = $this->withHeaders($this->authHeaders($admin))
            ->postJson('/api/v1/users', [
                'name' => 'New User',
                'email' => 'new@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'status' => 'active',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function test_user_can_show_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['id' => 100]);

        $response = $this->withHeaders($this->authHeaders($admin))
            ->getJson('/api/v1/users/100');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['id' => 100]]);
    }

    public function test_user_can_update_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['id' => 100]);

        $response = $this->withHeaders($this->authHeaders($admin))
            ->putJson('/api/v1/users/100', [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => 100, 'name' => 'Updated Name']);
    }

    public function test_user_can_delete_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['id' => 100]);

        $response = $this->withHeaders($this->authHeaders($admin))
            ->deleteJson('/api/v1/users/100');

        $response->assertStatus(204);
        $this->assertSoftDeleted('users', ['id' => 100]);
    }

    public function test_user_can_restore_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['id' => 100]);
        $user->delete();

        $response = $this->withHeaders($this->authHeaders($admin))
            ->postJson('/api/v1/users/100/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => 100]);
    }

    public function test_user_can_force_delete_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['id' => 100]);
        $user->delete();

        $response = $this->withHeaders($this->authHeaders($admin))
            ->deleteJson('/api/v1/users/100/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => 100]);
    }
}
