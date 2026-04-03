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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['System Administrator', 'Blood Bank Manager'])->default('Blood Bank Manager');
            $table->foreignId('establishment_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            
            $table->index('role');
            $table->index('establishment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'establishment_id', 'phone']);
        });
    }
};
