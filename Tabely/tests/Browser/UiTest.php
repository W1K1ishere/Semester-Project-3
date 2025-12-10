<?php

use Laravel\Dusk\Browser;
use App\Models\User;


it('welcome page guest', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Login to your Tabely')
            ->assertSee('Make your life easier with Tabely')
            ->assertVisible('a[href="/login"]')
            ->assertSee('Login');
    });
});

it('welcome page auth', function () {
    $user = \App\Models\User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/')
            ->assertSee('Explore your Tabely')
            ->assertSee('Tabely is making your everyday life easier')
            ->assertSee('Explore')
            ->assertPresent('a[href^="/profile/"]')
            ->assertDontSee('Login to your Tabely')
            ->assertDontSee('Make your life easier with Tabely')
            ->assertMissing('a[href^="/admin"]');
    });
});

it('welcome page admin', function () {
    $user = \App\Models\User::factory()->create();
    $user->isAdmin = true;
    $user->save();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/')
            ->assertSee('Explore your Tabely')
            ->assertSee('Tabely is making your everyday life easier')
            ->assertSee('Explore')
            ->assertPresent('a[href^="/profile/"]')
            ->assertDontSee('Login to your Tabely')
            ->assertDontSee('Make your life easier with Tabely')
            ->assertPresent('a[href^="/admin"]');
    });
});
