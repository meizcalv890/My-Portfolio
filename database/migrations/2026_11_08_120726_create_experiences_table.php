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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('work'); // work | education
            $table->string('title');                     // jabatan atau jurusan/gelar
            $table->string('organization');              // perusahaan atau sekolah/kampus
            $table->string('location', 100)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();        // kosong = masih berlangsung
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
