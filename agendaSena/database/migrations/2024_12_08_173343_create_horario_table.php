<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToHorarioTable extends Migration
{
    public function up()
    {
        Schema::table('horario', function (Blueprint $table) {
            $table->unique(['pla_amb_id', 'inicio', 'fin']);
        });
    }

    public function down()
    {
        Schema::table('horario', function (Blueprint $table) {
            $table->dropUnique(['pla_amb_id', 'inicio', 'fin']);
        });
    }
}