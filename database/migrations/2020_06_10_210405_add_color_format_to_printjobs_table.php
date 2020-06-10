<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorFormatToPrintjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printjobs', function (Blueprint $table) {
            $table->boolean('color_id');
            $table->boolean('format_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printjobs', function (Blueprint $table) {
            $table->dropColumn('color_id');
            $table->dropColumn('format_id');
        });
    }
}
