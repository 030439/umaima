<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotsTable extends Migration
{
    public function up()
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('plot_number')->unique();
            $table->boolean('status')->default(1);
            $table->foreignId('scheme_id')->constrained('schemes')->onDelete('cascade');
            $table->foreignId('plot_size_id')->constrained('plot_sizes')->onDelete('cascade');
            $table->foreignId('plot_location_id')->constrained('plot_locations')->onDelete('cascade');
            $table->foreignId('plot_category_id')->constrained('plot_categories')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['plot_number', 'scheme_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('plots');
    }
}
