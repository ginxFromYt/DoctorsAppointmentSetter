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
        Schema::create('doc_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('u_id');
            $table->string('firstname');
            $table->string('middlename'); 
            $table->string('lastname');
            $table->string('specialization_id'); //from specializations.id
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_profiles');
    }
};
