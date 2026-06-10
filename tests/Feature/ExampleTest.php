<?php

test('guest is redirected to login from homepage', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
