<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->string('code')->unique()->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('company_code')->constrained('companies', 'code');
            $table->foreignId('project_code')->constrained('projects', 'code');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['todo', 'in_progress', 'review', 'done', 'blocked'])->default('todo');
            $table->date('due_date')->nullable();
            $table->integer('priority')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_code');
            $table->index('project_code');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
