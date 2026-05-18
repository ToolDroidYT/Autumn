<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status')->default('open')->index();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->unsignedInteger('slot_limit')->default(50);
            $table->decimal('price_override', 10, 2)->nullable();
            $table->unsignedTinyInteger('min_downpayment_percent')->default(50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
