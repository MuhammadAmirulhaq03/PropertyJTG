<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'user@jtg.local', // not @example.com
        'phone' => '0895401550972', // valid 12-15 digits
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // With stricter flow, user is not automatically logged in
    $this->assertGuest();
    $response->assertRedirect(route('login', absolute: false));
});
