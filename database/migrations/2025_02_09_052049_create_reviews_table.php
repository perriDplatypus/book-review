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
        Schema::create(table: 'reviews', callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignId(column: 'book_id')->constrained()->cascadeOnDelete();
            $table->text(column: 'review');
            $table->unsignedTinyInteger(column: 'rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'reviews');
    }
};
