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
        Schema::create('displays', function (Blueprint $table) {
            $table->id();
            $table->integer('xiboId')->nullable(); 
            $table->boolean('isLoggedIn')->nullable();
            $table->boolean('isAuthorized')->nullable();
            $table->string('displayName')->nullable();
            $table->string('displayLayout')->nullable();
            $table->string('displayLayoutId')->nullable();
            //defaultLayoutId
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('displays');
    }
};
