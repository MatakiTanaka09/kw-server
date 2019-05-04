<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->uuid('event_masters_id');
            $table->string('title');
            $table->text('detail');
            $table->timestamp('started_at');
            $table->timestamp('expired_at');
            $table->integer('capacity_members')->unsigned();
            $table->string('target_min_age');
            $table->string('target_max_age');
            $table->text('pr');
            $table->tinyInteger('parent_attendant')->default(0);
            $table->integer('price')->unsigned();
            $table->string('canceled_at');
            $table->tinyInteger('pub_state')->default(0);
            $table->string('arrived_at');
            $table->string('zip_code1')->nullable();
            $table->string('zip_code2')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
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
        Schema::dropIfExists('event_details');
    }
}
