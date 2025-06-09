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
        //  DB::table('roles')->insert([
        //     ['name' => 'admin', 'created_at' => now(),'updated_at' => now()],
        //     ['name' => 'user', 'created_at' => now(),'updated_at' => now()]
        // ]);
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('admin');
            $table->string('user');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
