<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->date('birth_date');
            $table->integer('age');
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->json('residential_proof')->nullable(); // multiple files
            $table->string('profile_image')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->timestamps();
            $table->softDeletes(); // soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
