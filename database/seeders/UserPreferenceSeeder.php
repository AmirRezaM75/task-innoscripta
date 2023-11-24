<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\TargetType;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;

class UserPreferenceSeeder extends Seeder
{
    public function run(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $authors = Author::query()->limit(5)->get();

        foreach ($authors as $author) {
            UserPreference::query()->create([
                'user_id' => $user->id,
                'target_id' => $author->id,
                'target_type' => TargetType::Author
            ]);
        }

        $categories = Category::query()->limit(5)->get();

        foreach ($categories as $category) {
            UserPreference::query()->create([
                'user_id' => $user->id,
                'target_id' => $category->id,
                'target_type' => TargetType::Category
            ]);
        }

        $sources = Source::query()->limit(5)->get();

        foreach ($sources as $source) {
            UserPreference::query()->create([
                'user_id' => $user->id,
                'target_id' => $source->id,
                'target_type' => TargetType::Source
            ]);
        }
    }
}
