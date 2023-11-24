<?php

declare(strict_types=1);

use App\Constants\PreferenceTargetType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('target_type', [
                PreferenceTargetType::Author->value,
                PreferenceTargetType::Category->value,
                PreferenceTargetType::Source->value,
            ]);
            $table->unsignedBigInteger('target_id');
            $table->timestamps();

            $table->unique(['target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
