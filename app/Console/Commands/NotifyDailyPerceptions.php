<?php

namespace App\Console\Commands;

use App\Models\Motivation;
use App\Models\Topic;
use App\Models\User;
use App\Notifications\MotivationNotification;
use App\Notifications\NewPerceptionInTopic;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyDailyPerceptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send one random new perception per topic to followers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::now()->subDay();

        User::with([
            'followedTopics',
            'followedTopics.perceptions' => fn($q) =>
                $q
                    ->where('created_at', '>=', $yesterday)
                    ->withCount(['likes', 'comments'])
        ])
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    // If user follows topics, pick one of them at random:
                    $topics = $user->followedTopics;
                    if ($topics->isNotEmpty()) {
                        // collect all new perceptions across their topics
                        $fresh = $topics->flatMap(fn($t) => $t->perceptions);
                        // filter those with >50 engagement?
                        $hot = $fresh->filter(
                            fn($p) =>
                                $p->likes_count >= 50 || $p->comments_count >= 50
                        );
                        if ($hot->isNotEmpty()) {
                            // notify of *one* hot perception
                            $p = $hot->random();
                            $user->notify(new NewPerceptionInTopic($p));
                            continue;
                        }
                        // otherwise pick any fresh:
                        if ($fresh->isNotEmpty()) {
                            $p = $fresh->random();
                            $user->notify(new NewPerceptionInTopic($p));
                            continue;
                        }
                    }

                    // If here, no fresh perceptions – fall back to a random Motivation
                    $m = Motivation::inRandomOrder()->first();
                    if ($m) {
                        $user->notify(new MotivationNotification($m));
                    }
                }
            });
    }
}
