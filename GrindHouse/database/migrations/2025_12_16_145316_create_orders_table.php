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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Data derived from the checkout.php file
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->text('address');
            $table->decimal('total', 8, 2); // E.g., 999999.99
            
            // Optional: Foreign key to a 'users' table if you implement proper login
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps(); // created_at is the order date
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
