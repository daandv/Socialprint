<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printjobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('printer_id');
            $table->foreignId('requester_id');
            $table->string('status', 100);
            $table->boolean('notification_printer')->nullable();
            $table->boolean('notification_requester')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printjobs');
    }
}
