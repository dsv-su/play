<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomToAdminHandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_handlers', function (Blueprint $table) {
            $table->boolean('custom')->default(false)->after('role');
            $table->string('user')->after('custom')->nullable();
            $table->string('username')->after('user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_handlers', function (Blueprint $table) {
            $table->dropColumn('custom');
            $table->dropColumn('user');
            $table->dropColumn('username');
        });
    }
}
