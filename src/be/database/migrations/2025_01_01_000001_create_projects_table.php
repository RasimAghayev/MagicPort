<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('code')->unique()->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('company_code')->constrained('companies', 'code');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
