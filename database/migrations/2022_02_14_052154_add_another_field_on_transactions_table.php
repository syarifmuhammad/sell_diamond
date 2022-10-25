<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherFieldOnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('transactions', 'session_id') && !Schema::hasColumn('transactions', 'uuid'))
        {
            Schema::table('transactions', function (Blueprint $table) {
                $table->uuid('uuid')->after('id')->unique();
                $table->string('session_id')->default(null)->after('uuid');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('transactions', 'session_id') && Schema::hasColumn('transactions', 'uuid'))
        {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('uuid');
                $table->dropColumn('session_id');
            });
        }
    }
}
