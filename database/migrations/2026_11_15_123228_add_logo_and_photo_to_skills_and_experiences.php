<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('level');
            $table->string('icon_slug', 60)->nullable()->after('icon');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['icon', 'icon_slug']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
