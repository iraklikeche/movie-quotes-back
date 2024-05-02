<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Support\Facades\Log;

// beforeEach(function () {
//     // Mocking Socialite driver
//     $this->user = new SocialiteUser();
//     $this->user->id = '123456';
//     $this->user->email = 'test3@example.com';
//     $this->user->name = 'Test3 User';
//     $this->user->token = 'fake_google_token';

//     $this->socialiteMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
//     $this->socialiteMock->shouldReceive('stateless')->andReturnSelf();
//     $this->socialiteMock->shouldReceive('user')->andReturn($this->user);
//     $this->socialiteMock->shouldReceive('redirect')->andReturn(redirect('http://accounts.google.com'));
//     Socialite::shouldReceive('driver')->with('google')->andReturn($this->socialiteMock);
// });


// test('Google redirect works correctly', function () {
//     $response = $this->get('/api/auth/redirect');
//     $location = $response->headers->get('Location');
//     $response->assertStatus(302);
//     expect($location)->toContain('accounts.google.com');
// });




test('Google callback processes user correctly', function () {
    $response = $this->get('/api/auth/callback');
    $response->assertStatus(200);
    $response->assertJson(['success' => 'YAY!']);
});
