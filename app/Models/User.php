<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'avatar_url',
        'profession',
        'password',
    ];

    public function perceptions()
    {
        return $this->hasMany(Perception::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followedTopics()
    {
        return $this
            ->belongsToMany(Topic::class, 'topic_follows')
            ->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // All messages this user sent
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    // All messages this user received
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    /**
     * All the other users this user has ever conversed with,
     * with a dynamic `unread` count on each.
     */
    public function conversations()
    {
        $meId = $this->id;

        // subquery to get all peer IDs (either wrote to me or I wrote to them)
        $peers = DB::table('messages')
            ->select('from_user_id as peer_id')
            ->where('to_user_id', $meId)
            ->union(
                DB::table('messages')
                    ->select('to_user_id as peer_id')
                    ->where('from_user_id', $meId)
            );

        return User::query()
            ->whereIn('id', $peers)
            ->withCount([
                // count unread messages *from* that peer to me
                'receivedMessages as unread' => function ($q) use ($meId) {
                    $q
                        ->where('to_user_id', $meId)
                        ->whereNull('read_at');
                },
            ]);
    }
}
