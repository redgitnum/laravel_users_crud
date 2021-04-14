<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('postal_state');
            $table->string('postal_city');
            $table->string('postal_code');
            $table->string('postal_street');
            $table->string('postal_number');
            $table->string('address_state');
            $table->string('address_city');
            $table->string('address_code');
            $table->string('address_street');
            $table->string('address_number');
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
        Schema::dropIfExists('administrative_workers');
    }
}
