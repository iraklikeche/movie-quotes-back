<?php

use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'GenresTableSeeder']);
});

test('a user can like a quote', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $response = $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/likes");

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Like added successfully!',
                 'like_count' => 1,
                 'liked_by_user' => true
             ]);

    $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);
});


test('a user can unlike a quote', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    // First, like the quote
    $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/likes");

    // Then, unlike the quote
    $response = $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/likes");

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Like removed successfully!',
                 'like_count' => 0,
                 'liked_by_user' => false
             ]);

    $this->assertDatabaseMissing('likes', [
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);
});
