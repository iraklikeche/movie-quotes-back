<?php

use App\Models\User;

beforeEach(function () {
    $this->withSession([]);
    \Illuminate\Support\Facades\Artisan::call('migrate');

});

test('user can log out', function () {
    $user = User::factory()->create(['email' => 'test@gmail.com','password' => 'password']);
    $this->actingAs($user)->postJson(route('logout'))->assertStatus(200);
});


test('unauthenticated users cannot log out', function () {
    $response = $this->postJson('/api/logout');
    $response->assertUnauthorized();
});
