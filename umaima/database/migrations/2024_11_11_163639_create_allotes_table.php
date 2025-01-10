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
        Schema::create('allotes', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('cellno')->nullable();
            $table->string('phone')->nullable();
            $table->string('fullname')->nullable();
            $table->string('cnic')->nullable();
            $table->string('guardian')->nullable();
            $table->string('gcnic')->nullable();
            $table->string('father')->nullable();
            $table->string('fcnic')->nullable();
            $table->string('occupation')->nullable();
            $table->string('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residence_no')->nullable();
            $table->string('address')->nullable();
            
            // Add a status field
            $table->string('status')->default('1'); // Default status can be 'active'
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allotes');
    }
};
