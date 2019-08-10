<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_media', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('media_id');
            $table->timestamps();

            $table->unique(['media_id', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_media');
    }
}
