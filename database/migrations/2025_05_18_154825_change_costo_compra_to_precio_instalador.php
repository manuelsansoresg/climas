<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCostoCompraToPrecioInstalador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('costo_compra');
            $table->decimal('precio_instalador', 10, 2)->nullable()->after('precio_distribuidor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('precio_instalador');
            $table->decimal('costo_compra', 10, 2)->nullable()->after('precio_distribuidor');
        });
    }
}
