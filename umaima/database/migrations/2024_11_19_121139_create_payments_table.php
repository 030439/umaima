<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('paydate'); // Payment date
            $table->integer('payment_type'); // Payment type
            $table->foreignId('from_account')->constrained('banks')->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Amount with precision
            $table->text('narration'); // Narration
            $table->integer('allotees')->default(0); // Allotees with default value
            $table->integer('expense_heads')->default(0); // Expense heads with default value
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
