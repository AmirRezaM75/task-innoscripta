<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('news_api_sources', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')
                ->comment('ID which is assigned by NewsApi.')
                ->unique();
            $table->string('name');
            $table->string('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_api_sources');
    }
};
