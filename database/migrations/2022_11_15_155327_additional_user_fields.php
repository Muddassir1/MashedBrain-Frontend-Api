<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("phone", 50)->after('password')->nullable();
            $table->integer("status")->after('about')->default(0);
            $table->bigInteger("access_level")->unsigned()->after('about')->default(1);
            $table->foreign("access_level")->references("id")->on("access_level");
            $table->text("avatar")->after('about')->nullable();
            $table->boolean("phone_verified")->after('about')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('status');
            $table->dropColumn('access_level');
            $table->dropColumn('avatar');
        });
    }
};
