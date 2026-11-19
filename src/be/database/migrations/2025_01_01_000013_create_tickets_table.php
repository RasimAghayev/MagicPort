<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('code')->unique()->primary();
            $table->string('ticket_number')->unique();
            $table->foreignId('company_code')->constrained('companies', 'code')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->date('resolved_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_code');
            $table->index('user_id');
            $table->index('status');
            $table->index('priority');
            $table->index('ticket_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
