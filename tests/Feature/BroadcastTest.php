<?php

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Events\QuoteUnliked;
use App\Models\Like;
use App\Notifications\CommentAddedNotification;
use App\Notifications\QuoteLikedNotification;
use Database\Seeders\GenresTableSeeder;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(GenresTableSeeder::class);
    Event::fake();
    Notification::fake();
});


test('a user is notified when a quote is liked', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $quote->user->notify(new QuoteLikedNotification($quote, $user));

    Notification::assertSentTo(
        [$quote->user],
        QuoteLikedNotification::class,
        function ($notification, $channels) use ($quote, $user) {
            return $notification->quote->id === $quote->id && $notification->user->id === $user->id;
        }
    );
});


test('a user is notified when a quote is commented', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $comment = Comment::create([
        'content' => 'This is a test comment',
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);

    $quote->user->notify(new CommentAddedNotification($comment, $user, $quote));

    Notification::assertSentTo(
        [$quote->user],
        CommentAddedNotification::class,
        function ($notification, $channels) use ($comment, $user, $quote) {
            return $notification->quote->id === $quote->id &&
                   $notification->comment->id === $comment->id &&
                   $notification->user->id === $user->id;
        }
    );
});

test('an event is broadcasted when a quote is unliked', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    Like::create(['user_id' => $user->id, 'quote_id' => $quote->id]);

    Log::info('Unliking the quote', ['quote_id' => $quote->id, 'user_id' => $user->id]);

    $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/likes")
         ->assertStatus(200);

    Event::assertDispatched(QuoteUnliked::class, function ($event) use ($quote, $user) {
        Log::info('QuoteUnliked event dispatched', ['quote_id' => $event->quote->id, 'user_id' => $event->user->id]);
        return $event->quote->id === $quote->id && $event->user->id === $user->id;
    });
});
