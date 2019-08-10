<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source', 20);
            $table->string('key')->unique();
            $table->string('type', 10)->index();
            $table->string('title');
            $table->string('slug')->nullable()->unique()->comment('url slug');
            $table->string('image_path')->nullable();
            $table->string('download_url')->nullable();
            $table->string('source_url')->nullable();
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
        Schema::dropIfExists('media');
    }
}
