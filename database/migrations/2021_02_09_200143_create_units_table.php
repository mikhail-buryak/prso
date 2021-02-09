<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    const TABLE_NAME = 'units';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_id');
            $table->string('tax_id');
            $table->string('tin', 10);
            $table->string('ipn', 12);
            $table->string('name');
            $table->string('org_name');
            $table->string('address');

            $table->timestamps();

            $table->foreign('legal_id')
                ->references('id')->on(CreateLegalsTable::TABLE_NAME)
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
