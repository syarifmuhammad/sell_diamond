<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodFieldOnPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payment_methods', 'payment_method'))
        {
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->string('payment_method')->after('id');
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
        if (Schema::hasColumn('payment_methods', 'payment_method'))
        {
            Schema::table('payment_methods', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
}
