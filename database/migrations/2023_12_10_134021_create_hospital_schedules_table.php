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
        Schema::create('hospital_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_name');
            $table->string('hospital_address');
            $table->string('doc_profile_id');

            $table->string('available_days');
            $table->time('available_start_time');
            $table->time('available_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_schedules');
    }
};
