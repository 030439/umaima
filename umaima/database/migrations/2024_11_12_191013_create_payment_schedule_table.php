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
            $table->string('payment');
            $table->integer('amount');
            $table->string('pay_date');
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_schedule');
    }
}
