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
            $table->uuid('event_master_id');
            $table->unsignedInteger('event_pr_id');
            $table->string('title');
            $table->text('detail');
            $table->timestamp('started_at');
            $table->timestamp('expired_at');
            $table->tinyInteger('pub_state')->default(0);
            $table->string('zip_code1');
            $table->string('zip_code2');
            $table->string('state');
            $table->string('city');
            $table->string('address1');
            $table->string('address2');
            $table->float('longitude')->default(0.0);
            $table->float('latitude')->default(0.0);
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
