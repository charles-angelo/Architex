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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('type_id');
            $table->string('lot_name');
            $table->decimal('area', 10, 2);
            $table->decimal('price', 15, 2);
            $table->enum('status', ['available', 'sold', 'reserved'])->default('available');
            $table->enum('listing_type', ['for_sale', 'for_rent'])->default('for_sale');
            $table->text('description')->nullable();
            $table->text('position')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('lots_categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('lots_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
