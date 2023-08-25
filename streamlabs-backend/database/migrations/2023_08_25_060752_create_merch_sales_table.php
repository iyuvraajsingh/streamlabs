<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merch_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();;
            $table->unsignedBigInteger('sale_user_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('amount', 8, 2);
            $table->string('currency');
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sale_user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade'); 

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merch_sales');
    }
};
