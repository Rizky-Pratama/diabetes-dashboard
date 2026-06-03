<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prediction_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        DB::statement('ALTER TABLE prediction_histories MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('prediction_histories', function (Blueprint $table) {
            $table->foreignId('input_by')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            $table->string('patient_name')->nullable()->after('input_by');

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        DB::table('prediction_histories')->whereNotNull('result')->update([
            'result' => DB::raw("CASE
                WHEN LOWER(result) IN ('risiko diabetes', 'diabetes') THEN 'diabetes'
                WHEN LOWER(result) IN ('prediabetes', 'pre diabetes', 'pra diabetes') THEN 'prediabetes'
                ELSE 'normal'
            END"),
        ]);

        DB::statement("ALTER TABLE prediction_histories MODIFY result ENUM('normal', 'prediabetes', 'diabetes') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE prediction_histories MODIFY result VARCHAR(255) NULL');

        Schema::table('prediction_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['input_by']);
        });

        Schema::table('prediction_histories', function (Blueprint $table) {
            $table->dropColumn(['input_by', 'patient_name']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
