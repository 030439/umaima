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
        Schema::create('plot_paymnets', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->foreignId('allocation_details_id')->constrained('allocation_details')->onDelete('cascade');

            $table->date('paydate'); // Payment date
            $table->decimal('amount', 15, 2); // Amount with precision
            $table->text('narration'); // Narration

            $table->timestamps(); // created_at and updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plot_paymnets');
    }
};
