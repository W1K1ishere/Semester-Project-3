<?php
namespace Tests\Feature\WebSite;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function testProfilePage()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->get('profile/' . $user);
        $response->assertStatus(200);
        $response->assertSee('My Profile');
        $response->assertSee('Profiles');
        $response->assertSee($profile->name);
    }

    public function testPaginationOfProfiles() {
        $user = User::factory()->create();
        $profile = Profile::factory(15)->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->first()->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->get('profile/' . $user->id);
        $response->assertStatus(200);
        $response->assertSee('Next');
        $response->assertSee('Previous');
    }

    public function testUserUpdate() {
        $user = User::factory()->create([
            'name' => 'before',
            'email' => 'before@gmail.com',
            'phone' => '+1234',
            'height' => 170
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->patch(route('profile.update'), [
            'name' => 'after',
            'email' => 'after@gmail.com',
            'phone' => '+12345',
            'height' => 175
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'after',
            'email' => 'after@gmail.com',
            'phone' => '+12345',
            'height' => 175
        ]);
    }

    public function testProfileUpdate() {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'standing_height' => 100,
            'sitting_height' => 90,
            'session_length' => 30,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->patch(route('profile.save'), [
            'standing_height' => 110,
            'sitting_height' => 100,
            'session_length' => 40,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'standing_height' => 110,
            'sitting_height' => 100,
            'session_length' => 40,
        ]);
    }

    public function testProfileCreateAndPick() {
        $user = User::factory()->create([
            'name' => 'before',
            'email' => 'before@gmail.com',
            'phone' => '+1234',
            'height' => 170
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->post('/profile/create', [
            'standing_height' => 100,
            'sitting_height' => 100,
            'session_length' => 40,
            'name' => 'testProfile'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'standing_height' => 100,
            'sitting_height' => 100,
            'session_length' => 40,
            'name' => 'testProfile'
        ]);
        $profile2 = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->post('/profile/select', [
            'profile_id' => $profile2->id,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'picked_profile' => $profile2->id,
        ]);
    }
}
