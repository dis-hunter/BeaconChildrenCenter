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
        Schema::table('children', function (Blueprint $table) {
            $table->date('dob')->nullable()->change();
            $table->dropUnique('children_birth_cert_unique');
            $table->string('birth_cert')->nullable()->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->date('dob')->change();
            $table->string('birth_cert')->unique()->change(); // Reverting to non-nullable
        });
    }
};
