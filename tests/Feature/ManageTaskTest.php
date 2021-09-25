<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use function route;

class ManageTaskTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function task_can_store()
    {
        $attributes = Task::factory()->raw();
        $response   = $this->postJson(route('tasks.store'), $attributes);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function task_can_update()
    {
        $task             = Task::factory()->create();
        $updateAttributes = [
            'title' => $this->faker->sentence(2),
        ];
        $response         = $this->patchJson(route('tasks.update', $task), $updateAttributes);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('tasks', $updateAttributes);
    }

    /** @test */
    public function task_can_delete()
    {
        $task     = Task::factory()->create();
        $response = $this->deleteJson(route('tasks.destroy', $task));
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('tasks',$task->only('id'));
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function when_stor_task_title_required($attributes)
    {
        $response = $this->postJson(route('tasks.store'), $attributes);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function dataProvider()
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
