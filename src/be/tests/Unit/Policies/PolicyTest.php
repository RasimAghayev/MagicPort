<?php

namespace Tests\Unit\Policies;

use App\Models\Company;
use App\Models\User;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;
    public function test_company_policy_view_any(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();

        $this->assertTrue($policy->viewAny($user));
    }

    public function test_company_policy_view(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertTrue($policy->view($user, $company));
    }

    public function test_company_policy_create(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();

        $this->assertTrue($policy->create($user));
    }

    public function test_company_policy_update(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertTrue($policy->update($user, $company));
    }

    public function test_company_policy_delete(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertTrue($policy->delete($user, $company));
    }

    public function test_company_policy_restore(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertTrue($policy->restore($user, $company));
    }

    public function test_company_policy_force_delete(): void
    {
        $policy = new CompanyPolicy();
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->assertTrue($policy->forceDelete($user, $company));
    }
}
