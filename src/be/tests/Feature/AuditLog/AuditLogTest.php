<?php

namespace Tests\Feature\AuditLog;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken];
    }

    public function test_user_can_list_audit_logs(): void
    {
        $user = User::factory()->create();
        AuditLog::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/audit-logs');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_show_audit_log(): void
    {
        $user = User::factory()->create();
        $auditLog = AuditLog::factory()->create(['id' => 1, 'user_id' => $user->id]);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/audit-logs/1');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['id' => 1]]);
    }
}
