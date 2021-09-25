<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use function route;
use App\Models\User;

class ManageTaskTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function user_can_see_all_self_task()
    {
        $user = User::factory()->create();
        Task::factory(3)->create(['author_id' => $user->id]);
        Task::factory(2)->create();
        $response = $this->actingAs($user)
                         ->getJson(route('tasks.index'))
                         ->assertOk();
        $response->assertJsonCount(3);
        $this->assertDatabaseCount('tasks', 5);
    }

    /** @test */
    public function user_can_create_task()
    {
        $user       = User::factory()->create();
        $attributes = Task::factory()->raw(['author_id' => null]);
        $this->actingAs($user)
             ->postJson(route('tasks.store'), $attributes)
             ->assertStatus(Response::HTTP_CREATED);
        $attributes['author_id'] = auth()->id();
        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function guest_user_cannot_create_task()
    {
        $attributes = Task::factory()->raw(['author_id' => null]);
        $this->postJson(route('tasks.store'), $attributes)
             ->assertUnauthorized();
        unset($attributes['author_id']);
        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function task_can_update()
    {
        $user             = User::factory()->create();
        $task             = Task::factory()->create(['author_id' => $user->id]);
        $updateAttributes = [
            'title' => $this->faker->sentence(2),
        ];
        $this->actingAs($user)
             ->patchJson(route('tasks.update', $task), $updateAttributes)
             ->assertOk();
        $this->assertDatabaseHas('tasks', $updateAttributes);
    }

    /** @test */
    public function task_can_delete()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user)
             ->deleteJson(route('tasks.destroy', $task))
             ->assertOk();
        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function when_store_task_title_required($attributes)
    {
        $user = User::factory()->create();
        $this->actingAs($user)
             ->postJson(route('tasks.store'), $attributes)
             ->assertUnprocessable();
    }

    public function dataProvider() : array
    {
        return [
            [
                ['body' => 'task body'],
            ],
            [
                ['title' => 'test'],
            ],
        ];
    }
}
