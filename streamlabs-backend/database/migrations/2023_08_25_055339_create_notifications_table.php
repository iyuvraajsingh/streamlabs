<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Constants;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();; 
            $table->unsignedBigInteger('action_id'); 
            $table->enum('action_type', [Constants::AT_FOLLOWER, Constants::AT_SUBSCRIBER, Constants::AT_DONATION, Constants::AT_MERCH_SALE]);
            $table->text('message'); 
            $table->boolean('read'); 
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
