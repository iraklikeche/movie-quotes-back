<?php

use App\Models\User;

test('failed login with incorrect credentials', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'password' => bcrypt('correct-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'login' => $user->email,
        'password' => 'wrong-password',
        'remember' => false
    ]);

    $response->assertStatus(401)
             ->assertJson(['message' => __('auth.login_fail')]);
});

test('failed login with unverified email', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
        'password' => bcrypt('user-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'login' => $user->email,
        'password' => 'user-password',
        'remember' => false
    ]);

    $response->assertStatus(401)
             ->assertJson(['message' => __('auth.login_fail')]);
});

test('successful login with correct credentials', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'password' => bcrypt('correct-password'),
    ]);

    $response = $this->postJson('/api/login', [
        'login' => $user->email,
        'password' => 'correct-password',
    ]);

    $response->assertStatus(200)
             ->assertJson(['message' => __('auth.login_success')]);
});
