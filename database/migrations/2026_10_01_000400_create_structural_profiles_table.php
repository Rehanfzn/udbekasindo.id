<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('structural_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // IWF, UNP, CNP, WF, dll
            $table->string('size'); // contoh: "IWF 200", "UNP 100"
            $table->decimal('weight_per_m', 8, 2); // kg per meter
            $table->timestamps();

            $table->unique(['type', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('structural_profiles');
    }
};
