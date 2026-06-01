<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prediction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->decimal('glucose', 8, 2)->nullable();
            $table->decimal('blood_pressure', 8, 2)->nullable();
            $table->decimal('insulin', 8, 2)->nullable();
            $table->decimal('bmi', 6, 2)->nullable();
            $table->integer('age')->nullable();

            $table->decimal('probability', 5, 4)->nullable();
            $table->string('result')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction_histories');
    }
};
