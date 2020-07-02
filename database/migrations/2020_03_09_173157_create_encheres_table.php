<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncheresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encheres', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->float('cout_mise');
            $table->float('prix_indicatif');     //Cout réel du produit associé à l'enchère
            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('id')->on('produits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encheres');
    }
}
