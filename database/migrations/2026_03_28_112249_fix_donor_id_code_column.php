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
        // First drop the existing column if it exists
        if (Schema::hasColumn('donors', 'donor_id_code')) {
            Schema::table('donors', function (Blueprint $table) {
                $table->dropColumn('donor_id_code');
            });
        }
        
        // Then add the new column
        Schema::table('donors', function (Blueprint $table) {
            $table->string('donor_id_code')->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->dropColumn('donor_id_code');
        });
    }
};
