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
        Schema::create('loans', function (Blueprint $table) {
        $table->id();  // auto-incrementing primary key
        $table->string('party');
        $table->string('bank')->default(0);
        $table->integer('amount')->default(0);
        $table->string('narration')->default(0);
        $table->string('pay_date')->default(0);
        $table->timestamps();  // created_at and updated_at
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
