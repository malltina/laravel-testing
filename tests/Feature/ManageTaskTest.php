<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function task_can_store(){
        $attributes=[
            'title'=>'test',
            'body'=>'task body'
        ];

        $request=$this->post('api/v1/tasks', $attributes);
        $request->assertStatus(201);

        $this->assertDatabaseHas('tasks',$attributes);
    }
}
