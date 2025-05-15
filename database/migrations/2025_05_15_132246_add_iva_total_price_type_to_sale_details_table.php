<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->decimal('iva', 10, 2)->after('subtotal')->default(0);
            $table->decimal('total', 10, 2)->after('iva')->default(0);
            $table->enum('price_type', ['mayorista', 'distribuidor', 'instalador', 'publico'])->after('total')->default('publico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn(['iva', 'total', 'price_type']);
        });
    }
};
