<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $topics = [
            ['name' => 'Technology','description' => 'Latest trends and news in technology'],
            ['name' => 'Culture', 'description' => 'Cultural events and discussions'],
            ['name' => 'Education', 'description' => 'Educational Perception and news'],
            ['name' => 'Environment', 'description' => 'Environmental issues and solutions'],
            ['name' => 'Finance', 'description' => 'Financial tips and market news'],
            ['name' => 'Fashion', 'description' => 'Latest trends in fashion and style'],
            ['name' => 'Art', 'description' => 'Artistic expressions and exhibitions'],
            ['name' => 'History', 'description' => 'Historical events and discussions'],
            ['name' => 'Science', 'description' => 'Discoveries and advancements in science'],
            ['name' => 'Health', 'description' => 'Health tips and medical news'],
            ['name' => 'Sports', 'description' => 'Updates on various sports events'],
            ['name' => 'Entertainment', 'description' => 'Movies, music, and celebrity news'],
            ['name' => 'Politics', 'description' => 'Political news and discussions'],
            ['name' => 'Business', 'description' => 'Business trends and financial news'],
            ['name' => 'Travel', 'description' => 'Travel tips and destination guides'],
            ['name' => 'Food', 'description' => 'Recipes and food culture'],
            ['name' => 'Lifestyle', 'description' => 'Lifestyle tips and trends'],

        ];

        foreach ($topics as $t) {
            Topic::updateOrCreate(
                ['name' => $t['name']],
                ['description' => $t['description']]
            );
        }
    }
}
