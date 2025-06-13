<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motivation;

class MotivationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $positives = [
            ['body' => 'Every great idea started with a single thought.Put your Thoughts into writing..thats were everything becomes tangible', 'topic_id' => 21],
            ['body' => 'Success is not the key to happiness. Happiness is the key to success.', 'topic_id' => 21],
            ['body' => 'Believe you can and you are halfway there.', 'topic_id' => 21],
            ['body' => 'The only way to do great work is to love what you do.', 'topic_id' => 21],
            ['body' => 'Your limitation— it’s only your imagination.', 'topic_id' => 21],
            ['body' => 'Push yourself, because no one else is going to do it for you.', 'topic_id' => 21],
            ['body' => 'Great things never come from comfort zones.', 'topic_id' => 21],
            ['body' => 'Dream it. Wish it. Do it.', 'topic_id' => 21],
            ['body' => 'Success doesn’t just find you. You have to go out and get it.', 'topic_id' => 9],
            ['body' => 'The harder you work for something, the greater you’ll feel when you achieve it.', 'topic_id' => 21],
            ['body' => 'Dream bigger. Do bigger.', 'topic_id' => 21],
            ['body' => 'Don’t stop when you’re tired. Stop when you’re done.', 'topic_id' => 21],
            ['body' => 'Wake up with determination. Go to bed with satisfaction.', 'topic_id' => 21],
            ['body' => 'Little things make big days.', 'topic_id' => 21],
            ['body' => 'It’s going to be hard, but hard does not mean impossible.', 'topic_id' => 21],
            ['body' => 'Don’t wait for opportunity. Create it.', 'topic_id' => 21],
            ['body' => 'Sometimes we’re tested not to show our weaknesses, but to discover our strengths.', 'topic_id' => 21],
            ['body' => 'The key to success is to focus on goals, not obstacles.', 'topic_id' => 21],
            ['body' => 'Dream it. Wish it. Do it.', 'topic_id' => 21],
            ['body' => 'Don’t stop when you’re tired. Stop when you’re done.', 'topic_id' => 21],
            ['body' => 'Wake up with determination. Go to bed with satisfaction.', 'topic_id' => 21],
            ['body' => 'Do something today that your future self will thank you for.', 'topic_id' => 21],
            ['body' => 'Little things make big days.', 'topic_id' => 21],

            // …
        ];

        foreach ($positives as $row) Motivation::create($row);
    }
}
