<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->unsignedBigInteger('roomid')->nullable()->after('gameid');
            $table->foreign('roomid')->references('id')->on('rooms')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropForeign(['roomid']);
            $table->dropColumn('roomid');
        });
    }
};
