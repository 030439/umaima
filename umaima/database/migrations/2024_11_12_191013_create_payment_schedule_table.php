<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('payment_schedule', function (Blueprint $table) {
            $table->id();  // auto-incrementing primary key
            $table->foreignId('allocation_details_id')->constrained('allocation_details')->onDelete('cascade');
            $table->string('payment')->default(0);;
            $table->integer('amount')->default(0);;
            $table->integer('amount_paid')->default(0);;
            $table->string('paid_on')->default(0);;
            $table->integer('surcharge')->default(0);
            $table->integer('outstanding')->default(0);
            $table->string('pay_date')->default(0);;
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_schedule');
    }
}
