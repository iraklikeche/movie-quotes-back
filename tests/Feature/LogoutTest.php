<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->withSession([]);
    \Illuminate\Support\Facades\Artisan::call('migrate');

});


test('authenticated users can log out', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $csrfToken = 'some-csrf-token';
    $response = $this->withHeaders([
        'X-CSRF-TOKEN' => $csrfToken,
        'Origin' => 'http://127.0.0.1:5173'
    ])->postJson('/api/logout');

    $response->assertOk()
             ->assertJson(['message' => 'You have been successfully logged out!']);

    $response = $this->postJson('/api/some-protected-route');
    $response->assertUnauthorized();
});

test('unauthenticated users cannot log out', function () {
    $response = $this->postJson('/api/logout');
    $response->assertUnauthorized();
});
