<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();;
            $table->unsignedBigInteger('subscriber_id'); 
            $table->unsignedBigInteger('subscription_tier_id'); ;
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscriber_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_tier_id')->references('id')->on('subscription_tiers');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};

