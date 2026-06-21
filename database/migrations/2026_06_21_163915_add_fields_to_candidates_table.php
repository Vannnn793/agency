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
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('full_name');
            $table->string('email')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('email');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('date_of_birth');
            $table->enum('status', ['tersedia', 'disalurkan', 'tidak_aktif'])->default('tersedia')->after('availability');

            // Make user_id nullable since candidates are managed by admin
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email', 'date_of_birth', 'gender', 'status']);
        });
    }
};
