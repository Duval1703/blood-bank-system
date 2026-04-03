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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_id')->unique()->comment('Human-readable ID');
            $table->foreignId('blood_unit_id')->constrained()->onDelete('cascade');
            $table->enum('department', ['Emergency', 'Surgery', 'Maternity', 'ICU', 'Pediatrics', 'General Ward', 'Other']);
            $table->enum('status', ['Reserved', 'Issued', 'Cancelled'])->default('Reserved');
            $table->string('purpose')->comment('Surgery, Accident, Transfusion, etc.');
            $table->string('patient_name')->nullable();
            $table->string('patient_id')->nullable();
            $table->datetime('reserved_until')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->datetime('issued_date')->nullable();
            $table->datetime('cancelled_date')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'department']);
            $table->index('blood_unit_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
