<?php
use App\Models\User;

it('allows a user to update their profile information', function () {
    $user = User::factory()->create();
    /** @var \App\Models\User $user */
    $response = $this->actingAs($user)->put(route('profile.update.info'), [
        'name' => 'New Name',
        'email' => 'newemail@example.com',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
        'email' => 'newemail@example.com',
    ]);
});

it('allows a user to add a new shipping address', function () {
    $user = User::factory()->create();
    /** @var \App\Models\User $user */
    $response = $this->actingAs($user)->post(route('profile.addresses.store'), [
        'full_name'      => 'Ahmed Ali',
        'phone'          => '0123456789',
        'city'           => 'Cairo',
        'area'           => 'Maadi',
        'street_address' => '9th Street',
        'is_default'     => 1
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('addresses', [
        'user_id'   => $user->id,
        'full_name' => 'Ahmed Ali',
        'is_default' => 1
    ]);
});
