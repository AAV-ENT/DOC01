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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('clients_id')->index()->nullable();
            $table->string('user_type')->nullable();
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('doctor_id')->index();
            $table->string('appointment_type')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('confirmed')->nullable(); // Yes, No
            $table->string('confirmation_type')->nullable(); // SMS, Phone Call
            $table->string('date');
            $table->string('hour');
            $table->string('minute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
