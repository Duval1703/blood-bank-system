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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->enum('alert_type', ['Critical Stock', 'Low Stock', 'Expiring Soon', 'Surplus']);
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->enum('severity', ['Critical', 'Warning', 'Info'])->default('Warning');
            $table->string('message');
            $table->integer('current_level')->comment('Current stock level');
            $table->integer('threshold_level')->comment('Threshold that triggered alert');
            $table->boolean('is_active')->default(true);
            $table->datetime('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('establishment_id')->constrained()->onDelete('cascade');
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
            
            $table->index(['alert_type', 'is_active']);
            $table->index(['severity', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
