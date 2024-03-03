<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('serial_number')->unique();
            $table->text('description')->nullable();
            $table->string('shift')->nullable();
            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::NORMAL->value);
            $table->string('venue')->nullable();
            $table->string('reporter')->nullable();
            $table->boolean('approved')->default(false);
            $table->foreignUuid('approved_by')->nullable()
                ->constrained("users")
                ->onUpdate('cascade');
            $table->foreignUuid('dealing_officer')->nullable()
                ->constrained("users")
                ->onUpdate('cascade');
            $table->foreignUuid('user_id')
                ->constrained("users")
                ->onUpdate('cascade');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
