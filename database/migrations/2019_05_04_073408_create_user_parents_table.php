<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_parents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->integer('user_masters_id')->unsigned();
            $table->string('sexes_id');
            $table->string('icon');
            $table->string('full_name',50);
            $table->string('full_kana',50);
            $table->string('tel');
            $table->string('zip_code1');
            $table->string('zip_code2');
            $table->string('state');
            $table->string('city');
            $table->string('address1');
            $table->string('address2');
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
        Schema::dropIfExists('user_parents');
    }
}
