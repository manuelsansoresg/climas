<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalesTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Add any missing columns
            if (!Schema::hasColumn('sales', 'user_id')) {
                $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('sales', 'client_id')) {
                $table->foreignId('client_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('sales', 'total')) {
                $table->decimal('total', 10, 2);
            }
            if (!Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 10, 2);
            }
            if (!Schema::hasColumn('sales', 'iva')) {
                $table->decimal('iva', 10, 2);
            }
            if (!Schema::hasColumn('sales', 'status')) {
                $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            }
            if (!Schema::hasColumn('sales', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'credit_card', 'transfer'])->default('cash');
            }
            if (!Schema::hasColumn('sales', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            }
            if (!Schema::hasColumn('sales', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Remove columns if they exist
            $columns = [
                'user_id',
                'client_id',
                'total',
                'subtotal',
                'iva',
                'status',
                'payment_method',
                'payment_status',
                'notes'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('sales', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
