<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Entries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id('entry_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id')->on('users')
                ->onDelete('cascade');
            $table->string('title')->unique();
            $table->text('description');
            $table->string('slug')->unique();
            $table->boolean('active');
            $table->timestamps();

            $table->index(['entry_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entries');
    }
}
