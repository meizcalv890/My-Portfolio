<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('availability', 200)->nullable()->after('headline');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('year', 4)->nullable()->after('slug');
            $table->string('role', 150)->nullable()->after('year');
            $table->text('problem')->nullable()->after('description');
            $table->text('result')->nullable()->after('problem');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('availability');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['year', 'role', 'problem', 'result']);
        });
    }
};
