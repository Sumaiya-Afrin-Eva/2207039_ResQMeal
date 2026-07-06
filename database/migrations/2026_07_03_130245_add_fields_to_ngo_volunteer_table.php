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
        Schema::table('ngo_volunteer', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('organisation')->nullable();
            $table->enum('receiver_type', ['ngo', 'volunteer', 'shelter'])->default('ngo');
            $table->string('city');
            $table->string('password');
        });
    }

     /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('ngo_volunteer', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'email', 'phone',
                'organisation', 'receiver_type', 'city', 'password',
            ]);
        });
    }
};

