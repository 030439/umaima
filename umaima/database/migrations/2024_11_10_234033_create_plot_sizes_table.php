<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotSizesTable extends Migration
{
    public function up()
    {
        Schema::create('plot_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_sizes');
    }
}
