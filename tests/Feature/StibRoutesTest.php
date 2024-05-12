<?php

it('loads /stib/subways', function () {
    $this
        ->get('/stib/subways')
        ->assertStatus(200);
});

it('loads /stib/lines', function () {
    $this
        ->get('/stib/lines')
        ->assertStatus(200);
});

it('loads /stib/lines-and-stops', function () {
    $this
        ->get('/stib/lines-and-stops')
        ->assertStatus(200);
});

it('loads Laravel page', function () {
    $this
        ->get('/laravel')
        ->assertStatus(200);
});
