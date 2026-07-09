<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_requests', function (Blueprint $table) {
            $table->id();

            // Which donation is being requested
            $table->unsignedBigInteger('donation_id')->nullable();

            // Requester identity (from ngo_volunteer table)
            $table->string('requester_name');
            $table->string('requester_email');
            $table->string('requester_phone');
            $table->string('organisation')->nullable();
            $table->enum('receiver_type', ['ngo', 'volunteer', 'shelter'])->default('ngo');
            $table->string('requester_city');

            // Request details
            $table->unsignedInteger('requested_quantity');
            $table->string('quantity_unit');
            $table->unsignedInteger('beneficiary_count');   // how many people will benefit
            $table->string('purpose');                      // e.g. shelter feeding, flood relief
            $table->enum('transport', ['self', 'need_help'])->default('self');
            $table->dateTime('preferred_pickup_from');
            $table->dateTime('preferred_pickup_to');
            $table->text('delivery_address');
            $table->string('priority', 20)->default('normal'); // normal | urgent | emergency
            $table->text('notes')->nullable();

            // Status lifecycle
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_requests');
    }
};

