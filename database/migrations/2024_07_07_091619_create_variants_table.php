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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->double('price');
            $table->string('unit',10)->nullable();

            $table->boolean('default')->default(false);
            $table->boolean('active')->default(false);
            $table->jsonb('props')->nullable();
            $table->string('origin_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
