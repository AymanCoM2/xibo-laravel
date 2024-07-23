<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceNumber')->nullable();
            $table->string('invoiceUserName')->nullable();
            $table->timestamps();
        });

        DB::table('invoices')->insert([
            [
                'invoiceNumber' => '001',
                'invoiceUserName' => 'Ayman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '002',
                'invoiceUserName' => 'Omnea',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '003',
                'invoiceUserName' => 'Hassan',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
