<?php

use App\Models\User;
use Database\Seeders\GenresTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(GenresTableSeeder::class);
});

test('a user can update their username', function () {
    $user = User::factory()->create([
        'username' => 'old_username',
    ]);

    $newUsername = 'new_username';

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'new_username' => $newUsername,
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Profile updated successfully!',
             ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'username' => $newUsername,
    ]);
});

test('a user can update their password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('old_password'),
    ]);

    $newPassword = 'new_secure_password';

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'new_password' => $newPassword,
        'new_password_confirmation' => $newPassword,
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Profile updated successfully!',
             ]);

    $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
});

test('a user can update their profile image', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'profile_image' => UploadedFile::fake()->image('profile.jpg')
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Profile updated successfully!',
             ]);

    $media = $user->fresh()->getFirstMedia('profile_images');
    Storage::disk('public')->assertExists($media->id . '/' . $media->file_name);
});


test('a user cannot update their username with invalid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'new_username' => 'ab'
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['new_username']);
});


test('a user cannot update their password with invalid data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'new_password' => 'short',
        'new_password_confirmation' => 'short'
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['new_password']);
});

test('a user cannot update their profile image with invalid data', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/user/update', [
        'profile_image' => UploadedFile::fake()->create('document.pdf', 100)
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['profile_image']);
});
