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
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceNumber')->nullable();
            $table->string('prizeName')->nullable();
            // TODO : Prize Could be Taken From Products or Whatever
            $table->timestamps();
        });


        DB::table('prizes')->insert([
            [
                'invoiceNumber' => '001',
                'prizeName' => 'AirPods',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '002',
                'prizeName' => 'IPhone 15',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '001',
                'prizeName' => 'Cable',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '002',
                'prizeName' => 'Apple watch',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '001',
                'prizeName' => 'Adapter',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoiceNumber' => '002',
                'prizeName' => 'MacBook',
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
        Schema::dropIfExists('prizes');
    }
};
