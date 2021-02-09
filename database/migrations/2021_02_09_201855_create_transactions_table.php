<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    const TABLE_NAME = 'transactions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('legal_id');
            $table->foreignId('registrar_id');
            $table->foreignId('receipt_id')->nullable();
            $table->unsignedInteger('number_local')->default(0);
            $table->string('number_fiscal')->nullable()->unique();
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedTinyInteger('sub_type')->default(0);
            $table->unsignedSmallInteger('status')->default(0);
            $table->timestamp('fiscal_at')->nullable();

            $table->longText('request');
            $table->longText('response');

            $table->timestamps();

            $table->foreign('legal_id')
                ->references('id')->on(CreateLegalsTable::TABLE_NAME)
                ->onDelete('cascade');

            $table->foreign('registrar_id')
                ->references('id')->on(CreateRegistrarsTable::TABLE_NAME)
                ->onDelete('cascade');

            $table->foreign('receipt_id')
                ->references('id')->on(CreateReceiptsTable::TABLE_NAME)
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
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
