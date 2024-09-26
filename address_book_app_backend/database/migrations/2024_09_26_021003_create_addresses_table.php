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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street', 150);
            $table->string('external_number', 10);
            $table->string('internal_number', 10)->nullable();
            $table->string('neighbourhood', 255);
            $table->string('zip_code', 5);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->foreignId('contact_id')->constrained('contacts', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
