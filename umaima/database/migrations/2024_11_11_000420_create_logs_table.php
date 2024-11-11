<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // ID of the user performing the action
            $table->string('action'); // A short description of the action
            $table->text('details')->nullable(); // Additional details about the action
            $table->string('ip_address')->nullable(); // User's IP address
            $table->timestamps();
            $table->softDeletes(); // Allow soft deletes if needed
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
