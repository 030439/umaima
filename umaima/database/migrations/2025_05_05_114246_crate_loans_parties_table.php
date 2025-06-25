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
        Schema::create('loan_parties', function (Blueprint $table) {
        $table->id();
        $table->string('phone')->nullable();
        $table->string('fullname')->nullable();
        $table->string('address')->nullable();
        
        
        // Add a status field
        $table->string('status')->default('1'); // Default status can be 'active'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
