<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
    Auth::shouldReceive('check')->andReturn(false);
    session()->start();

});


test('failed login with incorrect credentials', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Auth::shouldReceive('attemptWhen')->andReturn(false);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'remember' => false
    ]);

    $response->assertStatus(401)
             ->assertJson(['message' => __('auth.login_fail')]);
});

test('failed login with unverified email', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    Auth::shouldReceive('attemptWhen')
        ->andReturn(false);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'user-password',
        'remember' => false
    ]);

    $response->assertStatus(401)
             ->assertJson(['message' => __('auth.login_fail')]);
});


// test('successful login with correct credentials', function () {
//     $user = User::factory()->create([
//         'email_verified_at' => now(),
//     ]);

//     Auth::shouldReceive('attemptWhen')
//         ->with(Mockery::on(function ($args) {
//             return $args['email'] === $user->email && $args['password'] === 'correct-password';
//         }), Mockery::any(), false)
//         ->andReturnUsing(function ($credentials, $callback, $remember) use ($user) {
//             return $callback($user) && $credentials['password'] === 'correct-password';
//         });

//     session()->shouldReceive('regenerate')->once();

//     $response = $this->postJson('/api/login', [
//         'email' => $user->email,
//         'password' => 'correct-password',
//         'remember' => false
//     ]);

//     $response->assertStatus(200)
//              ->assertJson(['message' => __('auth.login_success')]);
// });
