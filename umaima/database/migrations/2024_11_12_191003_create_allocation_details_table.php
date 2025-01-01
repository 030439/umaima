<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('allocation_details', function (Blueprint $table) {
            $table->id();  // auto-incrementing primary key
            $table->integer('allote');
            $table->integer('scheme');
            $table->string('status')->default('1'); 
            $table->integer('plot');  
            $table->date('bdate');
            $table->integer('onbooking');
            $table->integer('allocation');
            $table->integer('confirmation');
            $table->integer('installment');
            $table->integer('duration');
            $table->string('extra');
            $table->integer('percentage');
            $table->integer('possession');
            $table->integer('demargation');
            $table->softDeletes();
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('allocation_details');
    }
}
