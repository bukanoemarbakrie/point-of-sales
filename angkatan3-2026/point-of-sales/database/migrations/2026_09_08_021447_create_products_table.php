<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('product_name');                     // ← Sesuai ERD
            $table->string('product_photo')->nullable();        // ← Sesuai ERD
            $table->decimal('product_price', 15, 2);            // ← Sesuai ERD
            $table->text('product_description')->nullable();    // ← Sesuai ERD
            $table->integer('qty')->default(0);
            $table->boolean('is_active')->default(1);           // ← Tambah sesuai ERD
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
