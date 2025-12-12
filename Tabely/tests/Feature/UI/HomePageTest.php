<?php
namespace Tests\Feature\WebSite;

use App\Models\Profile;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase {
    use RefreshDatabase;

    public function testHomePage() {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $response = $this->get('home');
        $response->assertStatus(200);
        $response->assertSee('Picked Profile');

    }

    public function testHeighAdjustment() {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->picked_profile = $profile->id;
        $user->save();
        $this->actingAs($user);
        $table = Table::factory()->create([
            'user_id' => $user->id,
            'isAssigned' => true,
            'current_height' => 100,
        ]);
        $response = $this->patch('home/update', [
            'height' => 110,
        ]);
        $response->assertStatus(302);
        $response = $this->patch('home/standingHeight');
        $response->assertStatus(302);
        $response = $this->patch('home/sittingHeight');
        $response->assertStatus(302);
        $response = $this->patch('home/autoAdjust');
        $response->assertStatus(302);
    }
}
