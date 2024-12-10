<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPlotsTable extends Migration
{
    public function up()
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->dropUnique(['plot_number']); // Drop unique index on plot_number
            $table->dropUnique(['plot_number', 'scheme_id']); // Drop composite unique index
        });
    }

    public function down()
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->unique(['plot_number']); // Re-add unique index on plot_number
            $table->unique(['plot_number', 'scheme_id']); // Re-add composite unique index
        });
    }
}
