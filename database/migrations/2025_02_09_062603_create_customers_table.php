<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('phone');
            $table->string('password');
            $table->string('status', 20)->default('active');
            $table->string('state', 20)->default('pending');
            $table->integer('reputationPoints')->default(500); // Changed to integer if it's a numeric value
            $table->string('contractId')->nullable();
            $table->ipAddress('customerIP')->nullable(); // Using ipAddress helper for IP addresses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
