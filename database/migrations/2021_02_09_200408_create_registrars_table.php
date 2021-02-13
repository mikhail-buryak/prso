<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrarsTable extends Migration
{
    const TABLE_NAME = 'registrars';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id');
            $table->string('number_local');
            $table->unsignedInteger('next_number_local')->default(0);
            $table->string('number_fiscal');
            $table->unsignedInteger('last_number_fiscal')->default(0);
            $table->string('name');
            $table->unsignedTinyInteger('on')->default(0);
            $table->unsignedTinyInteger('closed')->default(1);

            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->foreign('unit_id')
                ->references('id')->on(CreateUnitsTable::TABLE_NAME)
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
