<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->string('code')->unique()->primary();
            $table->string('contract_number')->unique();
            $table->foreignId('company_code')->constrained('companies', 'code')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('value', 12, 2);
            $table->enum('status', ['draft', 'active', 'expired', 'terminated', 'renewed'])->default('draft');
            $table->date('signed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_code');
            $table->index('status');
            $table->index('contract_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
