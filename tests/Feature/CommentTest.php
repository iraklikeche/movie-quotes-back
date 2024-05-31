<?php

use App\Models\Comment;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'GenresTableSeeder']);
});

test('a user can add a comment to a quote', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $commentContent = 'This is a test comment';

    $response = $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/comments", [
        'content' => $commentContent,
    ]);

    $response->assertStatus(201)
             ->assertJson([
                 'message' => 'Comment added successfully!',
                 'comment' => [
                     'content' => $commentContent,
                     'user_id' => $user->id,
                     'quote_id' => $quote->id,
                 ]
             ]);

    $this->assertDatabaseHas('comments', [
        'content' => $commentContent,
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);
});


test('a user can retrieve comments for a quote', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $comment1 = Comment::create([
        'content' => 'First test comment',
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);

    $comment2 = Comment::create([
        'content' => 'Second test comment',
        'user_id' => $user->id,
        'quote_id' => $quote->id,
    ]);

    $response = $this->actingAs($user)->getJson("/api/quotes/{$quote->id}/comments");

    $response->assertStatus(200)
             ->assertJson([
                 [
                     'content' => 'First test comment',
                     'user_id' => $user->id,
                     'quote_id' => $quote->id,
                 ],
                 [
                     'content' => 'Second test comment',
                     'user_id' => $user->id,
                     'quote_id' => $quote->id,
                 ]
             ]);
});


test('a user cannot add a comment with invalid data', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $quote = Quote::factory()->create(['movie_id' => $movie->id, 'user_id' => $user->id]);

    $response = $this->actingAs($user)->postJson("/api/quotes/{$quote->id}/comments", [
        'content' => '',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['content']);
});



test('a user cannot retrieve comments for a non-existent quote', function () {
    $user = User::factory()->create();

    $nonExistentQuoteId = 999;

    $response = $this->actingAs($user)->getJson("/api/quotes/{$nonExistentQuoteId}/comments");

    $response->assertStatus(404);
});
