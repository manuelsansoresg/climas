<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('factura')->nullable();
            $table->foreignId('idusuarioagrega')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('fechaingresa')->nullable();
            $table->string('serie')->nullable();
            $table->decimal('costo_compra', 10, 2)->nullable();
            $table->string('idmov')->nullable();
            $table->string('campo1')->nullable();
            $table->string('campo2')->nullable();
            $table->string('campo3')->nullable();
            $table->string('campo4')->nullable();
            $table->string('campo5')->nullable();
            $table->integer('cantidad')->nullable();
            $table->foreignId('provedor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes(); // Agregamos esta línea para SoftDeletes
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
        Schema::dropIfExists('warehouses');
    }
}
