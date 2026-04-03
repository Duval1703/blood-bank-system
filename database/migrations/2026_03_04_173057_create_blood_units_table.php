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
        Schema::create('blood_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique()->comment('Unique barcode/ID');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->enum('status', ['Available', 'Reserved', 'Near Expiry', 'Expired', 'Used', 'Discarded'])->default('Available');
            $table->date('collection_date');
            $table->date('expiry_date')->comment('Typically 42 days from collection');
            $table->integer('volume')->default(450)->comment('Volume in ml');
            $table->text('screening_results')->nullable()->comment('JSON: HIV, Hepatitis B/C, Syphilis results');
            $table->text('notes')->nullable();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['blood_type', 'status']);
            $table->index('expiry_date');
            $table->index('donor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_units');
    }
};
