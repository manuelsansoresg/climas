<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('subcategories2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
            $table->foreign('subcategory_id')->references('id')->on('subcategories');
        });

        Schema::create('subcategories3', function (Blueprint $table) {
            $table->id();   
            $table->unsignedBigInteger('subcategory2_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
            $table->foreign('subcategory2_id')->references('id')->on('subcategories2');
        }); 

        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->default(true);
            $table->text('description')->nullable();
            $table->text('opening_hours')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
        

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('pdf')->nullable();
            $table->string('image')->nullable();
            $table->decimal('precio_mayorista', 10, 2)->nullable();
            $table->decimal('precio_distribuidor', 10, 2)->nullable();
            $table->decimal('precio_publico', 10, 2)->nullable();
            $table->decimal('costo_compra', 10, 2)->nullable();
            $table->integer('stock')->nullable();

            $table->string('discount')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('subcategory2_id')->nullable();
            $table->unsignedBigInteger('subcategory3_id')->nullable();
            $table->smallInteger('status')->nullable();

            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');
            $table->foreign('subcategory2_id')->references('id')->on('subcategories2');
            $table->foreign('subcategory3_id')->references('id')->on('subcategories3');
        });

        Schema::create('product_sucursal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->integer('stock');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sucursal');   
        Schema::dropIfExists('products');
        Schema::dropIfExists('subcategories3');
        Schema::dropIfExists('subcategories2');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sucursales');
    }
}
