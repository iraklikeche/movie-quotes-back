<?php

use App\Models\Quote;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\getJson;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->movie = Movie::factory()->create();
    $this->quotes = Quote::factory()
        ->count(3)
        ->for($this->user, 'user')
        ->for($this->movie, 'movie')
        ->create();

    $this->quotes[1]->update(['content' => ['en' => 'DifferentContent1', 'ka' => 'DifferentContentKa1']]);
    $this->quotes[2]->update(['content' => ['en' => 'DifferentContent2', 'ka' => 'DifferentContentKa2']]);
});

it('searches quotes by content in English', function () {
    $searchTerm = 'UniqueContent'.time();
    $this->quotes->first()->update(['content' => ['en' => $searchTerm, 'ka' => 'SomeContent']]);

    actingAs($this->user);

    $response = getJson(route('quotes.index', ['search' => '#'.$searchTerm, 'per_page' => 10]))
        ->assertStatus(200);

    $response->assertJsonCount(1, 'data');

    expect($response->json('data.0.content.en'))->toBe($searchTerm);
});

it('searches quotes by content in Georgian', function () {
    Log::info('Quote content:', ['content' => $this->quotes->first()->content]);

    $searchTerm = $this->quotes->first()->content['ka'];

    actingAs($this->user);

    $response = getJson(route('quotes.index', ['search' => '#'.$searchTerm]))
        ->assertStatus(200)
        ->assertJsonCount(1, 'data');

    expect($response->json('data.0.content.ka'))->toBe($searchTerm);
});


it('searches quotes by movie name in English', function () {
    $movie = Movie::find($this->movie->id);

    $name = json_decode($movie->getAttributes()['name'], true);

    $searchTerm = $name['en'];

    actingAs($this->user);

    $response = getJson(route('quotes.index', ['search' => '@'.$searchTerm, 'per_page' => 10]))
        ->assertStatus(200);

    $response->assertJsonCount(3, 'data');

    foreach ($response->json('data') as $quote) {
        expect($quote['movie']['name']['en'])->toBe($searchTerm);
    }
});



it('searches quotes by movie name in Georgian', function () {
    $movie = Movie::find($this->movie->id);

    $name = json_decode($movie->getAttributes()['name'], true);

    $searchTerm = $name['ka'];

    actingAs($this->user);

    $response = getJson(route('quotes.index', ['search' => '@'.$searchTerm, 'per_page' => 10]))
        ->assertStatus(200);


    $response->assertJsonCount(3, 'data');

    foreach ($response->json('data') as $quote) {
        expect($quote['movie']['name']['ka'])->toBe($searchTerm);
    }
});
