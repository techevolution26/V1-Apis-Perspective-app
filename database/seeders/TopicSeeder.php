<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $topics = [
            [
                'name' => 'Technology',
                'description' => "Exploring diverse perceptions of technology's impact and future.",
                'image_url' => '/storage/topics/technology.jpg'
            ],
            [
                'name' => 'Religion',
                'description' => 'Sharing and understanding different perceptions of faith, spirituality, and religious practices.',
                'image_url' => '/storage/topics/Religion.png'
            ],
            [
                'name' => 'Politics',
                'description' => 'Examining varied perceptions of political events, ideologies, and figures.',
                'image_url' => '/storage/topics/politics.jpg'
            ],
            [
                'name' => 'Economy',
                'description' => 'Understanding how different groups perceive economic trends, policies, and their personal impact.',
                'image_url' => '/storage/topics/economy.png'
            ],
            [
                'name' => 'Society',
                'description' => 'Discussing varying perceptions of social norms, issues, and community dynamics.',
                'image_url' => '/storage/topics/Society.webp'
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Exploring different perceptions of what constitutes a fulfilling or aspirational lifestyle.',
                'image_url' => '/storage/topics/lifestyle.avif'
            ],
            [
                'name' => 'Health',
                'description' => 'Sharing diverse perceptions on wellness, healthcare, and medical information.',
                'image_url' => '/storage/topics/health.png'
            ],
            [
                'name' => 'Education',
                'description' => 'Discussing varying perceptions of educational systems, methods, and their effectiveness.',
                'image_url' => '/storage/topics/Education.webp'
            ],
            [
                'name' => 'Nature',
                'description' => 'Sharing diverse perceptions of natural landscapes, wildlife, and conservation efforts.',
                'image_url' => '/storage/topics/environment.jpg'
            ],
            [
                'name' => 'Science',
                'description' => 'Examining how scientific discoveries and advancements are perceived and understood.',
                'image_url' => '/storage/topics/science.avif'
            ],
            [
                'name' => 'Culture',
                'description' => 'Sharing diverse perceptions of cultural expressions, traditions, and societal values.',
                'image_url' => '/storage/topics/culture.jpg'
            ],
            [
                'name' => 'Finance',
                'description' => 'Understanding different perceptions of financial management, investment, and market behavior.',
                'image_url' => '/storage/topics/finance.jpg'
            ],
            [
                'name' => 'Fashion',
                'description' => 'Exploring diverse perceptions of style, trends, and self-expression through clothing.',
                'image_url' => '/storage/topics/fashion.avif'
            ],
            [
                'name' => 'Art',
                'description' => 'Discussing varied perceptions and interpretations of artistic creations and movements.',
                'image_url' => '/storage/topics/art.webp'
            ],
            [
                'name' => 'History',
                'description' => 'Examining different perceptions and interpretations of historical events and their significance.',
                'image_url' => '/storage/topics/history.png'
            ],
            [
                'name' => 'Sports',
                'description' => 'Sharing diverse perceptions of athletic performance, team dynamics, and sporting culture.',
                'image_url' => '/storage/topics/sports.jpg'
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Exploring varying perceptions of movies, music, and the impact of celebrity culture.',
                'image_url' => '/storage/topics/entertainment.webp'
            ],
            [
                'name' => 'Business',
                'description' => 'Understanding different perceptions of business practices, entrepreneurship, and market forces.',
                'image_url' => '/storage/topics/business.jpg'
            ],
            [
                'name' => 'Travel',
                'description' => 'Sharing diverse perceptions of destinations, travel experiences, and cultural encounters.',
                'image_url' => '/storage/topics/travel.avif'
            ],
            [
                'name' => 'Food',
                'description' => 'Exploring varying perceptions of culinary traditions, taste, and the culture surrounding food.',
                'image_url' => '/storage/topics/food.webp'
            ],
            [
                'name' => 'Philosophy',
                'description' => 'Examining varied perceptions of philosophical concepts, ethics, and existential questions.',
                'image_url' => '/storage/topics/philosophy.jpeg'
            ],
        ];

        foreach ($topics as $t) {
            Topic::updateOrCreate(
                ['name' => $t['name']],
                [
                    'description' => $t['description'],
                    'image_url' => $t['image_url'],
                ]
            );
        }
    }
}
