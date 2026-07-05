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
        Schema::create('donation', function (Blueprint $table) {
            $table->id();
            $table->string('food_name');
            $table->string('category');
            $table->integer('quantity');
            $table->string('unit');
            $table->integer('serves');
            $table->dateTime('expiry');
            $table->dateTime('pickup_from');
            $table->dateTime('pickup_to');
            $table->string('pickup_address');
            $table->string('pickup_contact');
            $table->string('storage');
            $table->string('packaging');
            $table->string('allergens')->nullable();
            $table->string('dietary')->nullable();
            $table->text('notes')->nullable();
            $table->string('visibility');
            $table->boolean('emergency')->default(false);
            $table->string('donor_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation');
    }
};
