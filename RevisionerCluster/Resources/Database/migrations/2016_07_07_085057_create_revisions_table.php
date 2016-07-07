<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function ( Blueprint $table ) {
            $table->increments('id');
            $table->integer('item_id')->unsigned()->nullable()->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('model', 240);
            $table->longText('before');
            $table->longText('after')->nullable();
            $table->boolean('approved')->default(0);
            $table->boolean('revised')->default(0);
            $table->timestamps();
        });

        Schema::table('revisions', function ( Blueprint $table ) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('revisions');
    }
}
