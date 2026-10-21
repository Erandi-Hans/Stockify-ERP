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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Added product relationship
            $table->integer('quantity'); // Added quantity
            $table->decimal('unit_cost', 10, 2); // Added unit cost
            $table->decimal('total_cost', 10, 2); // Added total cost
            $table->date('purchase_date');
            $table->text('notes')->nullable(); // Added notes
            $table->string('status')->default('completed'); // e.g., pending, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
