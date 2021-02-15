<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionsTypeSubTypeIndex extends Migration
{
    const TABLE_NAME = 'transactions';
    const INDEX_NAME = 'type_sub_type';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->index(['type', 'sub_type'], self::INDEX_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropIndex(self::INDEX_NAME);
        });
    }
}
