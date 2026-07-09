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
        Schema::create('donor_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_request_id');
            $table->unsignedBigInteger('donation_id');
            $table->enum('status', ['approved', 'rejected']);
            $table->text('message')->nullable();
            $table->timestamps();

            $table->foreign('food_request_id')->references('id')->on('food_requests')->onDelete('cascade');
            $table->foreign('donation_id')->references('id')->on('donation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_responses');
    }
};
