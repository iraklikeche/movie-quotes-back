<?php


test('Google callback processes user correctly', function () {
    $response = $this->get('/api/auth/callback');
    $response->assertStatus(200);
    $response->assertJson(['success' => 'YAY!']);
});
