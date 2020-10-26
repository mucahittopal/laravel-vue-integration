<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('country_id');
            $table->integer('state_id')->nullable();
            $table->integer('city_id');
            $table->integer('zipcode_id');
            $table->longText('description')->nullable();
            $table->integer('hourly_rate');
            $table->integer('experience');
            $table->string('phone', 45);
            $table->boolean('onsite_service')->nullable();
            $table->string('reference', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
