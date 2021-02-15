<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReceiptsOrderCodeSumIndex extends Migration
{
    const TABLE_NAME = 'receipts';
    const INDEX_NAME = 'order_code_sum';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->index(['order_code', 'sum'], self::INDEX_NAME);
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
