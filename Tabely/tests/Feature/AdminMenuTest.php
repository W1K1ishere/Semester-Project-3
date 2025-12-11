<?php
namespace Tests\Feature;

use App\Models\Table;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminPage()
    {
        $user = User::factory()->create([
            'isAdmin' => true
        ]);
        $this->actingAs($user);
        $response = $this->get('admin');
        $response->assertStatus(200);
        $response->assertSee([
            'Departments',
            'Scheduler',
            'Add User',
            'Tables',
            'Users',
        ]);
        $response = $this->get('admin/departments');
        $response->assertStatus(200);
        $response->assertSee([
            'All Departments:',
            'Department'
        ]);
        $response = $this->get('admin/scheduler');
        $response->assertStatus(200);
        $response->assertSee([
            'Schedule New Break Time',
            'Schedule New Cleaning Time',
            'Department'
        ]);
        $response = $this->get('admin/addUser');
        $response->assertStatus(200);
        $response->assertSee('Add new user to system');

        $response = $this->get('admin/tables');
        $response->assertStatus(200);
        $response->assertSee([
            'Tables',
            'Tables:',
            'Select Department:',
            'Picked Table:'
        ]);
        $response = $this->get('admin/users');
        $response->assertStatus(200);
        $response->assertSee([
            'Employees',
            'Select Department:',
            'Employees:',
            'Employee'
        ]);
    }
}
