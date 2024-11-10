<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('plot_locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_locations');
    }
}
