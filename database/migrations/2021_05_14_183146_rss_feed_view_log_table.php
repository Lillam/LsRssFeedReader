<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RssFeedViewLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_feed_view_log', function (Blueprint $table) {
            $table->unsignedBigInteger('feed_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('views');
            $table->integer('items');
            $table->longText('read_items')->nullable();
        });

        Schema::table('rss_feed_view_log', function (Blueprint $table) {
            $table->primary(['feed_id', 'user_id'], 'feed_user_id');
            $table->foreign('feed_id')
                  ->references('id')
                  ->on('rss_feed')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }
}
