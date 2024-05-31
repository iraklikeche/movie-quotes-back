<?php

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'GenresTableSeeder']);
});
test('a user can store a quote', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $data = [
        'content' => [
            'en' => 'This is a test quote in English',
            'ka' => 'ეს არის ტესტ ციტატა ქართულად'
        ],
        'movie_id' => $movie->id,
        'image' => UploadedFile::fake()->image('quote.jpg')
    ];

    $response = $this->actingAs($user)->postJson('/api/quotes', $data);

    $quote = $response->json('quote');

    $response->assertStatus(201)
             ->assertJson([
                 'message' => 'Quote created successfully!',
                 'quote' => [
                     'content' => $data['content'],
                     'movie_id' => $movie->id,
                 ]
             ]);

    $this->assertDatabaseHas('quotes', [
        'id' => $quote['id'],
        'content' => json_encode($data['content']),
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);

    Storage::disk('public')->assertExists("{$quote['media'][0]['id']}/quote.jpg");
});

test('a user can retrieve their quotes', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $quoteData1 = [
        'content' => [
            'en' => 'First test quote in English',
            'ka' => 'პირველი ტესტ ციტატა ქართულად'
        ],
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ];

    $quoteData2 = [
        'content' => [
            'en' => 'Second test quote in English',
            'ka' => 'მეორე ტესტ ციტატა ქართულად'
        ],
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ];

    Quote::create($quoteData1);
    Quote::create($quoteData2);

    $response = $this->actingAs($user)->getJson('/api/quotes');

    $response->assertStatus(200)
             ->assertJsonCount(2, 'data')
             ->assertJson([
                 'data' => [
                     ['content' => $quoteData1['content'], 'movie_id' => $movie->id],
                     ['content' => $quoteData2['content'], 'movie_id' => $movie->id],
                 ]
             ]);
});


test('a user can retrieve a specific quote', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $quoteData = [
        'content' => [
            'en' => 'Specific test quote in English',
            'ka' => 'სპეციფიკური ტესტ ციტატა ქართულად'
        ],
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ];

    $quote = Quote::create($quoteData);

    $response = $this->actingAs($user)->getJson("/api/quotes/{$quote->id}");

    $response->assertStatus(200)
             ->assertJson([
                 'content' => $quoteData['content'],
                 'user_id' => $user->id,
                 'movie_id' => $movie->id,
             ]);
});

test('a user can update a quote', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $quoteData = [
        'content' => [
            'en' => 'Original test quote in English',
            'ka' => 'ორიგინალური ტესტ ციტატა ქართულად'
        ],
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ];

    $quote = Quote::create($quoteData);
    $quote->addMedia(UploadedFile::fake()->image('original_quote.jpg'))->toMediaCollection('images');

    $updatedData = [
        'content' => [
            'en' => 'Updated test quote in English',
            'ka' => 'განახლებული ტესტ ციტატა ქართულად'
        ],
        'movie_id' => $movie->id,
        'image' => UploadedFile::fake()->image('updated_quote.jpg')
    ];

    $response = $this->actingAs($user)->patchJson("/api/quotes/{$quote->id}", $updatedData);

    $quote->refresh();
    $updatedMedia = $quote->getMedia('images')->last();

    $quoteId = $response->json('quote.id');
    $updatedImageUrl = $response->json('quote.image_url');

    Log::info("Updated image URL: {$updatedImageUrl}");
    Log::info("Expected storage path: storage/{$updatedMedia->id}/updated_quote.jpg");

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Quote updated successfully!',
                 'quote' => [
                     'content' => $updatedData['content'],
                     'movie_id' => $movie->id,
                     'image_url' => $updatedImageUrl,
                 ]
             ]);

    $this->assertDatabaseHas('quotes', [
        'id' => $quoteId,
        'content' => json_encode($updatedData['content']),
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);

    $originalMedia = $quote->getMedia('images')->first();
    Storage::disk('public')->assertMissing("{$originalMedia->id}/original_quote.jpg");
    Storage::disk('public')->assertExists("{$updatedMedia->id}/updated_quote.jpg");
});


test('a user can delete a quote', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $quoteData = [
        'content' => [
            'en' => 'Test quote to be deleted in English',
            'ka' => 'წასაშლელი ტესტ ციტატა ქართულად'
        ],
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ];

    $quote = Quote::create($quoteData);
    $quote->addMedia(UploadedFile::fake()->image('quote.jpg'))->toMediaCollection('images');

    $quoteId = $quote->id;
    $mediaId = $quote->getMedia('images')->first()->id;

    $response = $this->actingAs($user)->deleteJson("/api/quotes/{$quoteId}");

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Quote deleted successfully!'
             ]);

    $this->assertDatabaseMissing('quotes', [
        'id' => $quoteId
    ]);

    Storage::disk('public')->assertMissing("{$mediaId}/quote.jpg");
});
