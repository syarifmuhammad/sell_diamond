<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherFieldOnPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payment_methods', 'fee') && !Schema::hasColumn('payment_methods', 'is_percent'))
        {
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->float('fee')->after('image');
                $table->boolean('is_percent')->default(0)->after('fee');
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
        if (Schema::hasColumn('payment_methods', 'fee') && Schema::hasColumn('payment_methods', 'is_percent'))
        {
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->dropColumn('fee');
                $table->dropColumn('is_percent');
            });
        }
    }
}
