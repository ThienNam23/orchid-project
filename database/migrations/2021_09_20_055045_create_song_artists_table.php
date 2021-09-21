<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_artists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('artist_id');
            $table->bigInteger('song_id');
            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('song_id')
                ->references('id')
                ->on('songs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_artists');
    }
}
