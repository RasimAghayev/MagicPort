<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_users(): void
    {
        $admin = User::factory()->create();
        User::factory()->count(3)->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['current_page', 'per_page', 'total', 'last_page'],
        ]);
        $response->assertJsonCount(4, 'data');
    }

    public function test_user_can_create_user(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/users', [
                'name'     => 'New User',
                'email'    => 'new@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'status'   => 'active',
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name'  => 'New User',
                'email' => 'new@example.com',
            ],
        ]);

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function test_user_can_show_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id'    => $user->id,
                'name'  => 'Test User',
                'email' => 'test@example.com',
            ],
        ]);
    }

    public function test_user_can_update_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson('/api/v1/users/' . $user->id, [
                'name'  => 'Updated User',
                'status'=> 'inactive',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name'  => 'Updated User',
                'status'=> 'inactive',
            ],
        ]);
    }

    public function test_user_can_delete_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson('/api/v1/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_user_can_restore_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $user->delete();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/users/' . $user->id . '/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_user_can_force_delete_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $user->delete();

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson('/api/v1/users/' . $user->id . '/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
