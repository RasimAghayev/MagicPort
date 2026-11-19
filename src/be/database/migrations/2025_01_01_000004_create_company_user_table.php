<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_code')->constrained('companies', 'code');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['active', 'hold', 'disable', 'removed'])->default('active');
            $table->timestamps();

            $table->unique(['company_code', 'user_id']);
            $table->index('company_code');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};
