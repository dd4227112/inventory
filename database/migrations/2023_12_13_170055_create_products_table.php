<?php

use App\Models\Product;
use App\Models\User;
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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->bigInteger('quantity');
            $table->string('code');
            $table->float('cost');
            $table->float('price');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->OnDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('unit_id');
            // $table->foreign('unit_id')->references('id')->on('units')->OnDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('category_id');
            // $table->foreign('category_id')->references('id')->on('categories')->OnDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('deleted_by')->nullable();
            // $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->uuid('uuid');
            $table->unique(['code', 'name', 'shop_id']);
            $table->unique(['code', 'shop_id']);
            $table->softDeletes();
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
