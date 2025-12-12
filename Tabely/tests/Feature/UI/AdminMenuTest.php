<?php
namespace Tests\Feature\WebSite;

use App\Models\Department;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    public function testAdminMenuDepartments() {
        $user = User::factory()->create([
            'isAdmin' => true
        ]);
        $department = Department::factory()->create();
        $this->actingAs($user);
        $this->get('admin/departments/select', [
            'dep_id' => $department->id
        ]);
        $response = $this->get('admin/departments');
        $response->assertSee($department->name);
        $response = $this->patch('admin/departments/update', [
            'dep_id' => $department->id,
            'dep_name' => 'new name'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('departments', [
            'dep_name' => 'new name'
        ]);
        $response = $this->post('admin/departments/create/create', [
            'dep_name' => 'new dep',
            'cleaning_start' => '09:00',
            'cleaning_end' => '09:00',
            'break_start' => '09:00',
            'break_end' => '09:00',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('departments', [
            'dep_name' => 'new dep',
        ]);

    }

    public function testAdminMenuScheduler() {
        $user = User::factory()->create([
            'isAdmin' => true
        ]);
        $department = Department::factory()->create([
            'dep_name' => 'test'
        ]);
        $this->actingAs($user);
        $response = $this->post('scheduler/select', [
            'dep_id' => $department->id
        ]);
        $response->assertStatus(302);
        $response = $this->post('scheduler/saveBreak', [
            'break_start' => '09:00',
            'break_end' => '09:00',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'break_time_start' => '09:00',
        ]);
        $response = $this->post('scheduler/saveCleaning', [
            'cleaning_start' => '09:00',
            'cleaning_end' => '09:00',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'cleaning_time_start' => '09:00',
            'cleaning_time_end' => '09:00',
        ]);
    }

    public function testAdminMenuAddUser() {
        $user = User::factory()->create([
            'isAdmin' => true
        ]);
        $department = Department::factory()->create([
            'dep_name' => 'test'
        ]);
        $table = Table::factory()->create([
            'department_id' => $department->id,
            'current_height' => 100
        ]);
        $this->actingAs($user);
        $response = $this->post('sendMail', [
            'email' => 'testAddUser@addUser.test',
            'table' => $table->id,
            'department' => $department->id,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'user_id' => User::where('email', 'testAddUser@addUser.test')->first()->id,
        ]);
    }

    public function testAdminMenuTables() {
        $user = User::factory()->create([
            'isAdmin' => true
        ]);
        $department = Department::factory()->create([
            'dep_name' => 'test'
        ]);
        $table = Table::factory()->create([
            'department_id' => $department->id,
            'current_height' => 100
        ]);
        $this->actingAs($user);
        $response = $this->post('admin/tables/select', [
            'table_id' => $table->id,
        ]);
        $response->assertStatus(302);
    }
}
