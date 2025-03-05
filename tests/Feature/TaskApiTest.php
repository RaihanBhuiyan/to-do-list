<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase; // Resets the database after each test

    /** @test */
    public function user_can_fetch_tasks()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // Log the user in

        // Create a task
        Task::factory()->create(['user_id' => $user->id]);

        // Send GET request to fetach tasks
        $response = $this->getJson('/api/tasks');

        // Assert that the response is successful and contains the task
        $response->assertStatus(200)
            ->assertJsonCount(1); // assuming only 1 task is created
    }

    /** @test */
    public function user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $taskData = ['title' => 'New Task'];

        // Send POST request to create a task
        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson($taskData); // Check that task is created with the correct data
    }

    /** @test */
    public function unauthenticated_user_cannot_create_task()
    {
        $taskData = ['title' => 'New Task'];

        // Send POST request without authentication
        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(401); // Unauthenticated user should get 401
    }
}
