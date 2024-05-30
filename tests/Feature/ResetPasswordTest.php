<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

test('should prevent password reuse', function () {
    $user = User::factory()->create([
        'password' => bcrypt('oldPassword')
    ]);

    $this->postJson('/api/reset-password', [
        'email' => $user->email,
        'password' => 'oldPassword',
        'password_confirmation' => 'oldPassword',
        'token' => 'valid-token'
    ])->assertStatus(422)
      ->assertJson([
          'message' => 'You cannot reuse your old password.',
          'errors' => [
              'password' => ['You cannot reuse your old password.']
          ]
      ]);
});




test('successful password reset', function () {
    Event::fake();
    Notification::fake();

    $user = User::factory()->create([
        'password' => bcrypt('oldPassword')
    ]);

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => bcrypt('valid-token'),
        'created_at' => now()
    ]);

    $response = $this->postJson('/api/reset-password', [
        'email' => $user->email,
        'password' => 'newPassword',
        'password_confirmation' => 'newPassword',
        'token' => 'valid-token'
    ]);

    $response->assertOk()
             ->assertJson(['status' => 'Password has been reset.']);

    $user->refresh();
    expect(Hash::check('newPassword', $user->password))->toBeTrue();
    expect($user->getRememberToken())->not()->toEqual(null);
    Event::assertDispatched(PasswordReset::class);
});

test('password reset with invalid token fails', function () {
    Notification::fake();
    $user = User::factory()->create([
        'password' => bcrypt('oldPassword')
    ]);

    $response = $this->postJson('/api/reset-password', [
        'email' => $user->email,
        'password' => 'newPassword',
        'password_confirmation' => 'newPassword',
        'token' => 'invalid-token'
    ]);

    $response->assertStatus(422)
             ->assertJson([
                 'message' => 'Token expired.',
                 'errors' => [
                     'password' => ['Token expired.']
                 ]
             ]);

    $user->refresh();
    expect(Hash::check('oldPassword', $user->password))->toBeTrue();
});



test('password reset fails if new password is too short', function () {
    Notification::fake();
    $user = User::factory()->create([
        'password' => bcrypt('oldPassword12345')
    ]);

    $response = $this->postJson('/api/reset-password', [
        'email' => $user->email,
        'password' => 'short',
        'password_confirmation' => 'short',
        'token' => 'valid-token'
    ]);

    $response->assertStatus(422)
             ->assertJsonPath('errors.password', ['The password field must be at least 8 characters.']);

    $user->refresh();
    expect(Hash::check('oldPassword12345', $user->password))->toBeTrue();
});
