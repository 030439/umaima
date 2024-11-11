<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('plot_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plot_categories');
    }
}
