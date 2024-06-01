<?php

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Database\Seeders\GenresTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(GenresTableSeeder::class);
});

test('a user can store a movie', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    // Get a seeded genre
    $genre = DB::table('genres')->first();

    $data = [
        'name' => [
            'en' => 'Movie Name English',
            'ka' => 'ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Director Name English',
            'ka' => 'დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Description in English',
            'ka' => 'აღწერა ქართულად'
        ],
        'year' => 2023,
        'genres' => [$genre->id],
        'image' => UploadedFile::fake()->image('movie.jpg')
    ];

    $response = $this->actingAs($user)->postJson('/api/movies', $data);

    $movieId = $response->json('data.id');

    $response->assertStatus(201)
             ->assertJson([
                 'data' => [
                     'movie_name' => $data['name']['en'],
                     'year' => 2023,
                     'image_url' => Storage::url("$movieId/movie.jpg")
                 ]
             ]);

    $this->assertDatabaseHas('movies', [
        'user_id' => $user->id,
        'year' => 2023,
    ]);

    Storage::disk('public')->assertExists("$movieId/movie.jpg");
});



test('a user can retrieve their movies', function () {
    $user = User::factory()->create();
    $genre = DB::table('genres')->first();

    $movieData = [
        'name' => [
            'en' => 'Movie Name English',
            'ka' => 'ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Director Name English',
            'ka' => 'დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Description in English',
            'ka' => 'აღწერა ქართულად'
        ],
        'year' => 2023,
        'user_id' => $user->id,
    ];

    $movie1 = Movie::create($movieData);
    $movie1->genres()->sync([$genre->id]);

    $movie2 = Movie::create(array_merge($movieData, ['name' => ['en' => 'Second Movie English', 'ka' => 'მეორე ფილმი ქართულად']]));
    $movie2->genres()->sync([$genre->id]);

    $response = $this->actingAs($user)->getJson('/api/movies');

    $response->assertStatus(200)
             ->assertJsonCount(2, 'data')
             ->assertJson([
                 'data' => [
                     ['movie_name' => 'Movie Name English', 'year' => 2023],
                     ['movie_name' => 'Second Movie English', 'year' => 2023],
                 ]
             ]);
});

test('a user can retrieve a specific movie', function () {
    $user = User::factory()->create();
    $genre = DB::table('genres')->first();

    $movieData = [
        'name' => [
            'en' => 'Movie Name English',
            'ka' => 'ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Director Name English',
            'ka' => 'დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Description in English',
            'ka' => 'აღწერა ქართულად'
        ],
        'year' => 2023,
        'user_id' => $user->id,
    ];

    $movie = Movie::create($movieData);
    $movie->genres()->sync([$genre->id]);

    $response = $this->actingAs($user)->getJson("/api/movies/{$movie->id}");

    $response->assertStatus(200)
             ->assertJson([
                 'data' => [
                     'id' => $movie->id,
                     'movie_name' => $movieData['name'],
                     'year' => 2023,
                     'image_url' => null,
                     'director' => $movieData['director'],
                     'description' => $movieData['description'],
                     'genres' => [
                         [
                             'id' => $genre->id,
                             'name' => json_decode($genre->name, true)['en']
                         ]
                     ]
                 ]
             ]);
});
test('a user can update a movie', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $genre = DB::table('genres')->first();

    $movieData = [
        'name' => [
            'en' => 'Original Movie Name English',
            'ka' => 'ორიგინალური ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Original Director Name English',
            'ka' => 'ორიგინალური დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Original Description in English',
            'ka' => 'ორიგინალური აღწერა ქართულად'
        ],
        'year' => 2023,
        'user_id' => $user->id,
    ];

    $movie = Movie::create($movieData);
    $movie->genres()->sync([$genre->id]);

    $updatedData = [
        'name' => [
            'en' => 'Updated Movie Name English',
            'ka' => 'განახლებული ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Updated Director Name English',
            'ka' => 'განახლებული დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Updated Description in English',
            'ka' => 'განახლებული აღწერა ქართულად'
        ],
        'year' => 2024,
        'genres' => [$genre->id],
        'image' => UploadedFile::fake()->image('updated_movie.jpg')
    ];

    $response = $this->actingAs($user)->patchJson("/api/movies/{$movie->id}", $updatedData);

    $movieId = $response->json('data.id');

    $response->assertStatus(200)
             ->assertJson([
                 'data' => [
                     'id' => $movie->id,
                     'movie_name' => $updatedData['name'],
                     'year' => 2024,
                     'image_url' => Storage::url("$movieId/updated_movie.jpg"),
                     'director' => $updatedData['director'],
                     'description' => $updatedData['description'],
                     'genres' => [
                         [
                             'id' => $genre->id,
                             'name' => json_decode($genre->name, true)['en']
                         ]
                     ]
                 ]
             ]);

    $this->assertDatabaseHas('movies', [
        'id' => $movie->id,
        'name' => json_encode($updatedData['name'], JSON_UNESCAPED_UNICODE),
        'director' => json_encode($updatedData['director'], JSON_UNESCAPED_UNICODE),
        'description' => json_encode($updatedData['description'], JSON_UNESCAPED_UNICODE),
        'year' => 2024,
        'user_id' => $user->id,
    ]);

    Storage::disk('public')->assertExists("$movieId/updated_movie.jpg");
});

test('a user can delete a movie', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $genre = DB::table('genres')->first();

    $movieData = [
        'name' => [
            'en' => 'Movie Name English',
            'ka' => 'ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Director Name English',
            'ka' => 'დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Description in English',
            'ka' => 'აღწერა ქართულად'
        ],
        'year' => 2023,
        'user_id' => $user->id,
    ];

    $movie = Movie::create($movieData);
    $movie->genres()->sync([$genre->id]);
    $movie->addMedia(UploadedFile::fake()->image('movie.jpg'))->toMediaCollection('movies');

    $movieId = $movie->id;

    $response = $this->actingAs($user)->deleteJson("/api/movies/{$movieId}");

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Movie deleted successfully'
             ]);

    $this->assertDatabaseMissing('movies', [
        'id' => $movieId
    ]);

    Storage::disk('public')->assertMissing("movies/{$movieId}/movie.jpg");
});
