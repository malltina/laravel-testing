<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function tasks_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('tasks', [
                'id', 'title', 'body', 'author_id',
            ]), 1);
    }

    /** @test */
    public function a_user_has_many_tasks()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['author_id' => $user->id]);
        $this->assertTrue($user->tasks->contains($task));
        $this->assertEquals(1, $user->tasks->count());
        $this->assertInstanceOf(Collection::class, $user->tasks);
    }

    /** @test */
    public function it_can_add_task(){
        $user = User::factory()->create();
        $attributes=Task::factory()->raw(['author_id'=>null]);
        $user->addTask($attributes);
        $this->assertEquals(1, $user->tasks->count());
    }
}
