<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('therapy_goals', function (Blueprint $table) {
            $table->unsignedBigInteger('visit_id')->after('data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('therapy_goals', function (Blueprint $table) {
            $table->dropColumn('visit_id');
        });
    }
};
