<?php

namespace Tests\Feature;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HolidayTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test for Holiday creation
     */
    public function test_can_create_holidays(): void
    {

        $user = User::factory()->create();
        
        Sanctum::actingAs($user);

        $response = $this->post('/api/holidays', [
            'title' => 'Test Holiday Title',
            'description' => 'Test Holiday Content',
            'date' => '2024-07-07',
            'participants' => '2',
            'user_id' => $user->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('holidays', [
            'title' => 'Test Holiday Title',
            'description' => 'Test Holiday Content',
            'date' => '2024-07-07',
            'participants' => '2',
        ]);
    }

    public function test_can_get_holidays(): void
    {

        $user = User::factory()->create();
        
        Sanctum::actingAs($user);

        $response = $this->get('/api/holidays');
        
        $response->assertStatus(200);
    }

    public function test_can_delete_holidays(): void {
        $user = User::factory()->create();
        
        Sanctum::actingAs($user);
        
        $holiday = Holiday::factory()->create([
            "user_id" => $user->id
        ]);

        $this->assertDatabaseHas('holidays', [
            'id' => $holiday->id,
            'title' => $holiday->title,
        ]);

        $response = $this->delete('/api/holidays/' . $holiday->id, ["user_id" => $user->id]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('holidays', [
            'id' => $holiday->id,
        ]);
    }

    public function test_can_update_holidays(): void {
        $user = User::factory()->create();
        
        Sanctum::actingAs($user);
        
        $holiday = Holiday::factory()->create([
            'title' => "test title",
            "description" => "test description",
            "user_id" => $user->id
        ]);

        $this->assertDatabaseHas('holidays', [
            'title' => "test title",
            "description" => "test description"
        ]);

        $updatedAttributes = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'user_id' => $user->id
        ];
        
        $response = $this->put('/api/holidays/' . $holiday->id, $updatedAttributes);

        $response->assertStatus(200);

        $this->assertDatabaseHas('holidays', [
            'id' => $holiday->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

    }
}
