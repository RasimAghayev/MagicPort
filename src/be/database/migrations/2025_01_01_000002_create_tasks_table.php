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
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('project_code')->constrained('projects', 'code');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['todo', 'in_progress', 'review', 'done'])->default('todo');
            $table->date('due_date')->nullable();
            $table->integer('priority')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('project_code');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
