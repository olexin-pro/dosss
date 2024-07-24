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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained();

            $table->string('slug')->unique();
            $table->string('title');

            $table->text('description')->nullable();

            $table->text('search_keys')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();


            $table->string('barcode')->nullable()->unique();
            $table->string('product_code')->nullable()->unique();

            $table->double('price')->nullable();

            $table->jsonb('options')->nullable();
            $table->jsonb('params')->nullable();
            $table->boolean('active')->default(false);
            $table->string('origin_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
