<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address_infos', function (Blueprint $table) {
            $table->id();
            $table->string('street_and_number');
            $table->string('city');
            $table->string('zip');
            $table->string('bus_number')->nullable();
            $table->decimal('lng', 10, 7);
            $table->decimal('lat', 10, 7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address_infos');
    }
}
