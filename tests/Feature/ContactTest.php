<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('contact form stores a message', function () {
    $response = $this->post(route('contact.store'), [
        'name' => 'Alex Johnson',
        'email' => 'alex@example.com',
        'subject' => 'support',
        'message' => 'I need help with my payout.',
    ]);

    $response->assertRedirect(route('contact'))->assertSessionHas('status', 'sent');

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Alex Johnson',
        'email' => 'alex@example.com',
        'subject' => 'support',
        'message' => 'I need help with my payout.',
    ]);
});

test('contact form requires a message', function () {
    $response = $this->from(route('contact'))->post(route('contact.store'), [
        'name' => 'Alex Johnson',
        'email' => 'alex@example.com',
        'subject' => 'support',
    ]);

    $response->assertRedirect(route('contact'))->assertSessionHasErrors('message');

    $this->assertDatabaseCount('contact_messages', 0);
});
