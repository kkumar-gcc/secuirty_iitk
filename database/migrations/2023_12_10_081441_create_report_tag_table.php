<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')
                ->constrained("reports")
                ->onUpdate('cascade');
            $table->foreignId('tag_id')
                ->constrained("tags")
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tag');
    }
};
