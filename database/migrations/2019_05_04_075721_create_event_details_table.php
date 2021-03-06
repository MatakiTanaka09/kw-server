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
            $table->unsignedInteger('event_school_master_id');
            $table->unsignedInteger('event_pr_id');
            $table->string('title');
            $table->text('detail');
            $table->text('handing');
            $table->timestamp('started_at');
            $table->timestamp('expired_at');
            $table->unsignedInteger('capacity_members');
            $table->unsignedInteger('event_minutes');
            $table->string('target_min_age');
            $table->string('target_max_age');
            $table->tinyInteger('parent_attendant')->default(0);
            $table->unsignedInteger('price');
            $table->unsignedInteger('cancel_deadline');
            $table->text('cancel_policy');
            $table->tinyInteger('pub_state')->default(0);
            $table->string('arrived_at');
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
