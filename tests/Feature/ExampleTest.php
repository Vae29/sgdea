<?php

test('the home page redirects to the SGDEA panel', function () {
    $this->get('/')->assertRedirect(route('sgdea.dashboard'));
});
